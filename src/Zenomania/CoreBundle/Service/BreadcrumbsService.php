<?php

namespace Zenomania\CoreBundle\Service;

use Closure;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\Twig\Helper;
use Symfony\Component\HttpFoundation\Request;
use Zenomania\CoreBundle\Menu\Breadcrumb;

/**
 * Class BreadcrumbsService
 *
 */
class BreadcrumbsService
{

    const REQUEST_BREADCRUMB_KEY = '_breadcrumb';

    private $menuHelper;
    private $matcher;
    /** @var Breadcrumb[] */
    private $appendedBreadcrumbs = [];

    public function __construct(Helper $menuHelper, MatcherInterface $matcher)
    {
        $this->menuHelper = $menuHelper;
        $this->matcher = $matcher;
    }

    /**
     * @param Breadcrumb $breadcrumb
     *
     * Enqueue breadcrumb to be rendered on getMenuBreadcrumbs()
     */
    public function registerAppendedBreadcrumb(Breadcrumb $breadcrumb)
    {
        array_push($this->appendedBreadcrumbs, $breadcrumb);
    }

    /**
     * @param $menu
     * @return Breadcrumb[]
     */
    public function getMenuBreadcrumbs($menu)
    {
        /** @var Breadcrumb[] $menuBreadcrumbs */
        $menuBreadcrumbs = array_map(
            function (ItemInterface $item) {
                return Breadcrumb::create($item->getName(), $item->getUri());
            },
            $this->getCurrentItems($this->menuHelper->get($menu))
        );

        return array_merge($menuBreadcrumbs, $this->appendedBreadcrumbs);
    }

    /**
     * Render breadcrumb label with parameters
     * Pass plain $data array, if label has printf format: "Project: %s"
     * Pass associative array, if breadcrumb has mustache format: "Project {{ name }}"
     *
     * @param Request $request
     * @param array $data
     */
    public function renderBreadcrumb(Request $request, $data)
    {
        if(!is_array($data)) {
            $data = [$data];
        }
        /** @var Breadcrumb $breadcrumb */
        $breadcrumb = $request->attributes->get(self::REQUEST_BREADCRUMB_KEY);
        if($breadcrumb) {
            if($this->hasStringKeys($data)) {
                foreach ($data as $key => $value) {
                    $breadcrumb->label = preg_replace("/{{\s*$key\s*}}/", $value, $breadcrumb->label, 1);
                }
            } else {
                $breadcrumb->label = vsprintf($breadcrumb->label, array_values($data));
            }
        }
    }

    private function hasStringKeys(array $array)
    {
        return count(
            array_filter(
                array_map('is_string', array_keys($array))
            )
        ) > 0;
    }

    /**
     * @param ItemInterface $item
     * @return ItemInterface[]
     */
    private function getCurrentItems(ItemInterface $item)
    {
        /** @var ItemInterface[] $items */
        $items = [];
        /** @var Closure $getActiveItems */
        $getActiveItems = function (ItemInterface $item) use (&$getActiveItems, &$items) {
            if ($this->matcher->isCurrent($item) or null === $item->getParent()) {
                $items[] = $item;
                foreach ($item->getChildren() as $child) {
                    $getActiveItems($child);
                }
            }
        };
        $getActiveItems($item);
        return $items;
    }
}
