<?php
/**
 * @package    Zenomania\CoreBundle\Service
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\File\File;


class EntitySerializer
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Serialize entity to array
     *
     * @param $entity
     * @return array
     */
    public function serialize($entity)
    {
        $data = array();

        if ($entity instanceof \DateTimeInterface) {
            return $entity;
        }

        if ($entity instanceof File) {
            return $entity->getRealPath();
        }

        $className = get_class($entity);

        $metaData = $this->em->getClassMetadata($className);

        foreach ($metaData->fieldMappings as $field => $mapping) {
            $method = "get" . ucfirst($field);
            $data[$field] = call_user_func(array($entity, $method));
        }

        foreach ($metaData->associationMappings as $field => $mapping) {
            // Sort of entity object
            $object = $metaData->reflFields[$field]->getValue($entity);

            if (null === $object) continue;
            if ($object instanceof Collection) {
                $fieldData = [];
                $objectData = $object->toArray();

                foreach ($objectData as $key => $objectField) {
                    $objectField = $this->serializeAsArray($objectField);
                    $fieldData[$key] = $objectField[1];
                }
                $data[$field] = $fieldData;
            } else {
                $uow = $this->em->getUnitOfWork();
                $data[$field] = $uow->getEntityIdentifier($object);
            }
        }

        return $data;
    }

    /**
     * Serialize entity to array keeping database field names
     *
     * @param $entity
     * @return array
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function serializeAsArray($entity)
    {
        $className = get_class($entity);

        $uow = $this->em->getUnitOfWork();
        $entityPersister = $uow->getEntityPersister($className);
        $classMetadata = $entityPersister->getClassMetadata();

        $result = array();
        if($uow->getEntityState($entity) == UnitOfWork::STATE_NEW) {

            $changeSet = self::diffDoctrineObject($this->em, $entity);

            foreach($changeSet as $field => $value) {
                $columnName = $field;
                $result[$columnName] = $value[1];
            }

        } else {
            foreach ($uow->getOriginalEntityData($entity) as $field => $value) {
                if (isset($classMetadata->associationMappings[$field])) {
                    $assoc = $classMetadata->associationMappings[$field];

                    // Only owning side of x-1 associations can have a FK column.
                    if (!$assoc['isOwningSide'] || !($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
                        continue;
                    }

                    $newValId = [];
                    if ($value !== null) {
                        $newValId = $uow->getEntityIdentifier($value);
                    }

                    $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
//                $owningTable = $entityPersister->getOwningTable($field);

                    foreach ($assoc['joinColumns'] as $joinColumn) {
                        $sourceColumn = $joinColumn['name'];
                        $targetColumn = $joinColumn['referencedColumnName'];

                        if ($value === null) {
                            $result[$sourceColumn] = null;
                        } else if ($targetClass->containsForeignIdentifier) {
                            $result[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
                        } else {
                            $result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
                        }
                    }
                } elseif (isset($classMetadata->columnNames[$field])) {
                    $columnName = $classMetadata->columnNames[$field];
                    $result[$columnName] = $value;
                }
            }
        }

        return array($className, $result);
    }

    /**
     * Deserialize array of data to entity
     *
     * @param array $data
     * @return object
     */
    public function deserialize(array $data)
    {
        list($class, $result) = $data;

        $uow = $this->em->getUnitOfWork();
        return $uow->createEntity($class, $result);
    }

    /**
     * Try to get an Entity changeSet without changing the UnitOfWork
     *
     * @param EntityManager $em
     * @param $entity
     * @return null|array
     */
    public static function diffDoctrineObject(EntityManager $em, $entity)
    {
        $uow = $em->getUnitOfWork();

        /*****************************************/
        /* Equivalent of $uow->computeChangeSet($this->em->getClassMetadata(get_class($entity)), $entity);
        /*****************************************/
        $class = $em->getClassMetadata(get_class($entity));
        $oid = spl_object_hash($entity);
        $entityChangeSets = array();

        if ($uow->isReadOnly($entity)) {
            return null;
        }

        if ( ! $class->isInheritanceTypeNone()) {
            $class = $em->getClassMetadata(get_class($entity));
        }

        // These parts are not needed for the changeSet?
        // $invoke = $uow->listenersInvoker->getSubscribedSystems($class, Events::preFlush) & ~ListenersInvoker::INVOKE_MANAGER;
        //
        // if ($invoke !== ListenersInvoker::INVOKE_NONE) {
        //     $uow->listenersInvoker->invoke($class, Events::preFlush, $entity, new PreFlushEventArgs($em), $invoke);
        // }

        $actualData = array();

        foreach ($class->reflFields as $name => $refProp) {
            $value = $refProp->getValue($entity);

            if ($class->isCollectionValuedAssociation($name) && $value !== null) {
                if ($value instanceof PersistentCollection) {
                    if ($value->getOwner() === $entity) {
                        continue;
                    }

                    $value = new ArrayCollection($value->getValues());
                }

                // If $value is not a Collection then use an ArrayCollection.
                if ( ! $value instanceof Collection) {
                    $value = new ArrayCollection($value);
                }

                $assoc = $class->associationMappings[$name];

                // Inject PersistentCollection
                $value = new PersistentCollection(
                    $em, $em->getClassMetadata($assoc['targetEntity']), $value
                );
                $value->setOwner($entity, $assoc);
                $value->setDirty( ! $value->isEmpty());

                $class->reflFields[$name]->setValue($entity, $value);

                $actualData[$name] = $value;

                continue;
            }

            if (( ! $class->isIdentifier($name) || ! $class->isIdGeneratorIdentity()) && ($name !== $class->versionField)) {
                $actualData[$name] = $value;
            }
        }

        $originalEntityData = $uow->getOriginalEntityData($entity);
        if (empty($originalEntityData)) {
            // Entity is either NEW or MANAGED but not yet fully persisted (only has an id).
            // These result in an INSERT.
            $originalEntityData = $actualData;
            $changeSet = array();

            foreach ($actualData as $propName => $actualValue) {
                if ( ! isset($class->associationMappings[$propName])) {
                    $changeSet[$propName] = array(null, $actualValue);

                    continue;
                }

                $assoc = $class->associationMappings[$propName];

                if ($assoc['isOwningSide'] && $assoc['type'] & ClassMetadata::TO_ONE) {
                    $changeSet[$propName] = array(null, $actualValue);
                }
            }

            $entityChangeSets[$oid] = $changeSet; // @todo - remove this?
        } else {
            // Entity is "fully" MANAGED: it was already fully persisted before
            // and we have a copy of the original data
            $originalData           = $originalEntityData;
            $isChangeTrackingNotify = $class->isChangeTrackingNotify();
            $changeSet              = $isChangeTrackingNotify ? $uow->getEntityChangeSet($entity) : array();

            foreach ($actualData as $propName => $actualValue) {
                // skip field, its a partially omitted one!
                if ( ! (isset($originalData[$propName]) || array_key_exists($propName, $originalData))) {
                    continue;
                }

                $orgValue = $originalData[$propName];

                // skip if value haven't changed
                if ($orgValue === $actualValue) {
                    continue;
                }

                // if regular field
                if ( ! isset($class->associationMappings[$propName])) {
                    if ($isChangeTrackingNotify) {
                        continue;
                    }

                    $changeSet[$propName] = array($orgValue, $actualValue);

                    continue;
                }

                $assoc = $class->associationMappings[$propName];

                // Persistent collection was exchanged with the "originally"
                // created one. This can only mean it was cloned and replaced
                // on another entity.
                if ($actualValue instanceof PersistentCollection) {
                    $owner = $actualValue->getOwner();
                    if ($owner === null) { // cloned
                        $actualValue->setOwner($entity, $assoc);
                    } else if ($owner !== $entity) { // no clone, we have to fix
                        // @todo - what does this do... can it be removed?
                        if (!$actualValue->isInitialized()) {
                            $actualValue->initialize(); // we have to do this otherwise the cols share state
                        }
                        $newValue = clone $actualValue;
                        $newValue->setOwner($entity, $assoc);
                        $class->reflFields[$propName]->setValue($entity, $newValue);
                    }
                }

                if ($orgValue instanceof PersistentCollection) {
                    // A PersistentCollection was de-referenced, so delete it.
                    // These parts are not needed for the changeSet?
                    //            $coid = spl_object_hash($orgValue);
                    //
                    //            if (isset($uow->collectionDeletions[$coid])) {
                    //                continue;
                    //            }
                    //
                    //            $uow->collectionDeletions[$coid] = $orgValue;
                    $changeSet[$propName] = $orgValue; // Signal changeset, to-many assocs will be ignored.

                    continue;
                }

                if ($assoc['type'] & ClassMetadata::TO_ONE) {
                    if ($assoc['isOwningSide']) {
                        $changeSet[$propName] = array($orgValue, $actualValue);
                    }

                    // These parts are not needed for the changeSet?
                    //            if ($orgValue !== null && $assoc['orphanRemoval']) {
                    //                $uow->scheduleOrphanRemoval($orgValue);
                    //            }
                }
            }

            if ($changeSet) {
                $entityChangeSets[$oid]     = $changeSet;
                // These parts are not needed for the changeSet?
                //        $originalEntityData         = $actualData;
                //        $uow->entityUpdates[$oid]   = $entity;
            }
        }

        // These parts are not needed for the changeSet?
        //// Look for changes in associations of the entity
        //foreach ($class->associationMappings as $field => $assoc) {
        //    if (($val = $class->reflFields[$field]->getValue($entity)) !== null) {
        //        $uow->computeAssociationChanges($assoc, $val);
        //        if (!isset($entityChangeSets[$oid]) &&
        //            $assoc['isOwningSide'] &&
        //            $assoc['type'] == ClassMetadata::MANY_TO_MANY &&
        //            $val instanceof PersistentCollection &&
        //            $val->isDirty()) {
        //            $entityChangeSets[$oid]   = array();
        //            $originalEntityData = $actualData;
        //            $uow->entityUpdates[$oid]      = $entity;
        //        }
        //    }
        //}
        /*********************/

        return $entityChangeSets[$oid];
    }
}
