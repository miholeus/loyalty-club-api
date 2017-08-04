<?php

namespace Zenomania\CoreBundle\Doctrine;

use Doctrine\ODM\MongoDB\Query\Builder;
use Symfony\Component\HttpFoundation\Request;

class MongoPaginator
{
    /** @var  Builder */
    private $queryBuilder;
    /** @var  int */
    private $pageSize = null;
    /** @var  int */
    private $currentPage = null;
    private $route;
    /** @var array $routeParams */
    private $routeParams = [];
    /** @var  Request $request */
    private $request;

    public function __construct(Builder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function getQuery()
    {
        return $this->queryBuilder->getQuery();
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $page int
     * @return array
     */
    public function getPageParameters($page)
    {
        return array_merge(
            $this->routeParams,
            $this->request->query->all(),
            ['page' => $page]
        );
    }

    /**
     * @param $pageSize int
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->queryBuilder->limit($pageSize);
    }

    public function getPageSize()
    {
        if (!$this->pageSize) {
            throw new \ErrorException('Page size is not set');
        }
        return $this->pageSize;
    }

    /**
     * @param $page int
     */
    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
        $this->queryBuilder->skip($this->getPageSize() * ($this->getCurrentPage() - 1));
    }

    public function getCurrentPage()
    {
        if (!$this->currentPage) {
            return $this->request->query->has('page') ? $this->request->query->get('page') : 1;
        }
        return $this->currentPage;
    }

    public function getTotalPages()
    {
        return ceil($this->count() / $this->getPageSize());
    }

    private function count()
    {
        return $this->queryBuilder->getQuery()->count();
    }

    public function setRoute($route, $routeParams = [])
    {
        $this->route = $route;
        $this->routeParams = $routeParams;
    }

    public function getRoute()
    {
        return $this->route;
    }
}
