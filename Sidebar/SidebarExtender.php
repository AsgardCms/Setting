<?php namespace Modules\Setting\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('workshop::workshop.title'), function (SidebarGroup $group) {
            $group->addItem(trans('setting::settings.title.settings'), function (SidebarItem $item) {
                $item->icon('fa fa-cog');
                $item->weight(50);
                $item->route('admin.setting.settings.index');
                $item->authorize(
                    $this->auth->hasAccess('setting.settings.index')
                );
            });
        });

        return $menu;
    }
}
