<?php

$router->group(['prefix' => '/setting'], function () {
    get('settings/{module}', ['as' => 'dashboard.module.settings', 'uses' => 'SettingController@getModuleSettings']);
    get('settings', ['as' => 'admin.setting.settings.index', 'uses' => 'SettingController@index']);
    post('settings', ['as' => 'admin.setting.settings.store', 'uses' => 'SettingController@store']);
});
