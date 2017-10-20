<?php

namespace Zenomania\CoreBundle\Repository;

use Zenomania\ApiBundle\Request\Filter\NewsFilter;
use Zenomania\CoreBundle\Entity\News;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Возвращает новые записи из ВК
     *
     * @return array
     */
    public function findAllNewNews()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('n')
            ->from('ZenomaniaCoreBundle:News', 'n')
            ->where('n.status = :status')
            ->setParameter('status', News::STATUS_NEW)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param int $vkId
     * @param int $limit
     * @return mixed
     */
    public function getLastNews(int $vkId, int $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('n')
            ->from('ZenomaniaCoreBundle:News', 'n')
            ->where('n.vkId >= :vkId')
            ->setParameter('vkId', $vkId)
            ->orderBy('n.vkId')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Возвращает записи из ВК, находящиеся под контролем
     *
     * @return array
     */
    public function findAllControlledNews()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('n')
            ->from('ZenomaniaCoreBundle:News', 'n')
            ->where('n.status = :status')
            ->setParameter('status', News::STATUS_CONTROLLED)
            ->getQuery();

        return $query->getResult();
    }

    public function deleteNews($data)
    {
        foreach ($data as $news) {
            $this->_em->remove($news);
        }
        $this->_em->flush();
    }

    public function saveNews($data)
    {
        foreach ($data as $news) {
            $this->_em->persist($news);
        }
        $this->_em->flush();
    }

    public function save(News $news)
    {
        $this->_em->persist($news);
        $this->_em->flush();
    }

    /**
     * @param NewsFilter $filter
     * @return News[]
     */
    public function getNews(NewsFilter $filter)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $select = $qb->select('n')
            ->from('ZenomaniaCoreBundle:News', 'n')
            ->setMaxResults($filter->getOffset())
            ->setFirstResult($filter->getOffset())
            ->orderBy('n.dt', 'DESC');

        $select->setMaxResults($filter->getLimit());
        $select->setFirstResult($filter->getOffset());

        $result = $select->getQuery()->getResult();
        return $result;
    }
}
