<?php

namespace Zenomania\CoreBundle\Doctrine;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class CustomPaginator extends Paginator
{

    /** @var  int */
    private $pageSize = null;
    /** @var  int */
    private $currentPage = null;
    private $route;
    /** @var array $routeParams */
    private $routeParams = [];
    /** @var  Request $request */
    private $request;

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
        $this->getQuery()->setMaxResults($pageSize);
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
        $this->getQuery()->setFirstResult($this->getPageSize() * ($this->getCurrentPage() - 1));
    }

    public function getCurrentPage()
    {
        if (!$this->currentPage) {
            throw new \ErrorException('Current page is not set');
        }
        return $this->currentPage;
    }

    public function getTotalPages()
    {
        return ceil($this->count() / $this->getPageSize());
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
