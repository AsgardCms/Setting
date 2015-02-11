<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/setting'], function (Router $router) {
    $router->get('settings/{module}', ['as' => 'dashboard.module.settings', 'uses' => 'SettingController@getModuleSettings']);

    $router->resource('settings', 'SettingController', ['except' => ['show', 'edit', 'update', 'destroy', 'create'], 'names' => [
        'index' => 'dashboard.setting.index',
        'store' => 'dashboard.setting.store',
    ]]);
});
