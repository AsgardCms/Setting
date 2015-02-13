<?php namespace Modules\Setting\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group('Setting', function (SidebarGroup $group) {
            $group->enabled = false;

            $group->addItem('Setting', function (SidebarItem $item) {
                $item->route('admin.setting.settings.index');
                $item->icon = 'fa fa-cog';
                $item->name = 'Setting';
                $item->authorize(
                    $this->auth->hasAccess('settings.index')
                );
            });
        });
    }
}
