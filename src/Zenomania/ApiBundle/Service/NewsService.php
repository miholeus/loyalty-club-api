<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.10.17
 * Time: 11:06
 */

namespace Zenomania\ApiBundle\Service;


use Zenomania\ApiBundle\Request\Filter\NewsFilter;
use Zenomania\CoreBundle\Repository\NewsRepository;

class NewsService
{
    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNews(NewsFilter $filter)
    {
       return $this->getRepository()->getNews($filter);
    }

    /**
     * @return NewsRepository
     */
    public function getRepository(): NewsRepository
    {
        return $this->repository;
    }
}