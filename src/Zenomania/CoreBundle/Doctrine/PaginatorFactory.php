<?php

namespace Zenomania\CoreBundle\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaginatorFactory
{

    const ITEMS_BY_PAGE = 20;

    /**
     * @param $query Query|QueryBuilder
     * @param array $options
     * @return CustomPaginator
     */
    public static function createPaginator($query, array $options = [])
    {
        $options = self::getOptionsResolver()->resolve($options);
        $paginator = new CustomPaginator($query);
        $paginator->setPageSize($options['items_by_page']);
        $paginator->setCurrentPage(self::getCurrentPage($options));
        $paginator->setRoute($options['route']);
        if ($options['request']) {
            $paginator->setRequest($options['request']);
        }

        return $paginator;
    }

    private static function getCurrentPage(array $options)
    {
        if ($options['current_page']) {
            return $options['current_page'];
        } elseif ($options['request'] and $page = $options['request']->get('page')) {
            return $page;
        } else {
            return 1;
        }
    }

    private static function getOptionsResolver()
    {

        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefaults(
            [
                'route' => null,
                'request' => null,
                'items_by_page' => self::ITEMS_BY_PAGE,
                'current_page' => null
            ]
        );
        $optionsResolver->setAllowedTypes('request', Request::class);

        return $optionsResolver;
    }
}
