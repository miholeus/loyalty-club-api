<?php
/**
 * @package    IntelliJ IDEA
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        /** @var ItemInterface $menu */
        $menu = $this->factory->createItem('Zenomania', ['route' => 'zenomania_core_homepage']);
        $menu->addChild('Home', ['route' => 'zenomania_core_homepage']);
        $menu->addChild('User Roles', self::makeResourceRoutes('user_role'));
        $menu->addChild('User statuses', self::makeResourceRoutes('user_status'));
        $menu->addChild('Users', self::makeResourceRoutes('user'));
        $menu->addChild('Countries', self::makeResourceRoutes('country'));
        $menu->addChild('Cities', self::makeResourceRoutes('city'));
        $menu->addChild('Districts', self::makeResourceRoutes('district'));
        $menu->addChild('Clubs', self::makeResourceRoutes('club'));
        $menu->addChild('Actors', self::makeResourceRoutes('actor'));

        $this->fillBranchRoutes($menu->getChildren());

        return $menu;
    }

    private static function makeResourceRoutes($resource)
    {
        return [
            'route' => "{$resource}_index",
            'extras' => [
                'routes' => [
                    ['route' => "{$resource}_new"],
                    ['route' => "{$resource}_edit"],
                    ['route' => "{$resource}_show"],
                ]
            ]
        ];
    }

    /**
     * Для пунктов меню, имеющих дочерние элементы, добавить их маршруты
     * для определения активной группы меню
     *
     * @param $menuItems ItemInterface[]
     */
    private function fillBranchRoutes($menuItems)
    {
        foreach ($menuItems as $menuItem) {
            if (!$menuItem->hasChildren()) {
                continue;
            }
            /** @var array $extraRoutes */
            $extraRoutes = array_map(
                function (MenuItem $menuSubItem) {
                    if ($routes = $menuSubItem->getExtra('routes') and is_array($routes)) {
                        return $routes;
                    } else {
                        return null;
                    }
                },
                $menuItem->getChildren()
            );
            if ($extraRoutes) {
                $menuItem->setExtra(
                    'routes',
                    call_user_func_array('array_merge', $extraRoutes)
                );
            }
        }
    }
}
