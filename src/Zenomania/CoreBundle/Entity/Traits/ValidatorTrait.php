<?php
/**
 * @package    Zenomania\CoreBundle\Entity\Trait
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Entity\Traits;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Zenomania\CoreBundle\Entity\Exception\ValidatorException;

trait ValidatorTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed $value The value to validate
     * @param Constraint|Constraint[] $constraints The constraint(s) to validate
     *                                             against
     * @param array|null $groups The validation groups to
     *                                             validate. If none is given,
     *                                             "Default" is assumed
     * @return bool
     * @throws ValidatorException
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        $validator = $this->getContainer()->get('validator');
        $result = $validator->validate($value, $constraints, $groups);
        if ($result->count() > 0) {
            // throw first exception in validation constraints
            /** @var \Symfony\Component\Validator\ConstraintViolation $validationConstraint */
            foreach ($result as $validationConstraint) {
                $messageTemplate = "Field <%s> has value <%s>. %s";

                $invalidValue = $validationConstraint->getInvalidValue();
                if ($invalidValue instanceof \DateTime) {
                    $invalidValue = $invalidValue->format('Y-m-d H:i:s.u T');
                }

                $message = sprintf($messageTemplate,
                    $validationConstraint->getPropertyPath(),
                    $invalidValue,
                    $validationConstraint->getMessage());

                throw new ValidatorException($message);
            }
        }
        return true;
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}
