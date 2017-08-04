<?php

namespace Zenomania\CoreBundle\Annotation;

/**
 * Class ActionBreadcrumb
 * @Annotation
 *
 * Can be used on controller actions to append a breadcrumb
 */
class ActionBreadcrumb
{

    public $label;

    public function __construct($label)
    {
        $this->label = $label;
    }
}
