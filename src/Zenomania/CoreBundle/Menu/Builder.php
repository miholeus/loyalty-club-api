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

        $users = $menu->addChild('Users');
        $users->addChild('User Roles', self::makeResourceRoutes('user_role'));
        $users->addChild('User statuses', self::makeResourceRoutes('user_status'));
        $users->addChild('Users', self::makeResourceRoutes('user'));

        $geo = $menu->addChild('Countries');
        $geo->addChild('Countries', self::makeResourceRoutes('country'));
        $geo->addChild('Cities', self::makeResourceRoutes('city'));
        $geo->addChild('Districts', self::makeResourceRoutes('district'));

        $menu->addChild('Clubs', self::makeResourceRoutes('club'));
        $menu->addChild('Sport', self::makeResourceRoutes('sport'));
        $menu->addChild('Education', self::makeResourceRoutes('education'));
        $menu->addChild('Matches & Results', self::makeResourceRoutes('event'));
        $menu->addChild('Player', self::makeResourceRoutes('player'));
        $menu->addChild('Promo coupon', self::makeResourceRoutes('promocoupon'));
        $menu->addChild('Points', self::makeResourceRoutes('pointstype'));


        $badges = $menu->addChild('Badges');
        $badges->addChild('Badges', self::makeResourceRoutes('badge'));
        $badges->addChild('Badge Types', self::makeResourceRoutes('badge_type'));

        $orders = $menu->addChild('Orders');
        $orders->addChild('Orders', self::makeResourceRoutes('order'));
        $orders->addChild('Orders status', self::makeResourceRoutes('order_status'));

        $product = $menu->addChild('Product');
        $product->addChild('Products', self::makeResourceRoutes('product'));
        $product->addChild('Product Categories', self::makeResourceRoutes('productcategory'));

        $menu->addChild('TicketForZen', self::makeResourceRoutes('ticketforzen'));

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
