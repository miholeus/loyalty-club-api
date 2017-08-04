<?php

namespace Zenomania\CoreBundle\Menu;

/**
 * Class Breadcrumb
 *
 * Breadcrumb data object
 */
class Breadcrumb
{

    public $label;
    public $url;

    public static function create($title, $href)
    {
        $breadcrumb = new static();
        $breadcrumb->label = $title;
        $breadcrumb->url = $href;

        return $breadcrumb;
    }
}
