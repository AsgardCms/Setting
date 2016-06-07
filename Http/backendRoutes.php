<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/setting'], function (Router $router) {
    $router->get('settings/{module}', ['as' => 'dashboard.module.settings', 'uses' => 'SettingController@getModuleSettings']);
    $router->get('settings', ['as' => 'admin.setting.settings.index', 'uses' => 'SettingController@index']);
    $router->post('settings', ['as' => 'admin.setting.settings.store', 'uses' => 'SettingController@store']);
});
