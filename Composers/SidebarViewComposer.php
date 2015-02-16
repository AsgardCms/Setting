<?php namespace Modules\Setting\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('workshop::workshop.title'), function (SidebarGroup $group) {

            $group->addItem(trans('setting::settings.title.settings'), function (SidebarItem $item) {
                $item->icon = 'fa fa-cog';
                $item->weight = 50;
                $item->route('admin.setting.settings.index');
                $item->authorize(
                    $this->auth->hasAccess('settings.index')
                );
            });
        });
    }
}
