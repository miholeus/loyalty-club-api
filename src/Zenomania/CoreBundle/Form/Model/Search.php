<?php

namespace Zenomania\CoreBundle\Form\Model;


class Search
{

    private $query;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function __construct($query = null)
    {
        if($query) {
            $this->setQuery($query);
        }
    }
}