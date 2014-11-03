<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => LaravelLocalization::setLocale(), 'before' => 'LaravelLocalizationRedirectFilter|auth.admin'], function(Router $router) {
	$router->group(['prefix' => Config::get('core::core.admin-prefix'), 'namespace' => 'Modules\Setting\Http\Controllers'], function(Router $router)
	{
		$router->get('settings/{module}', ['as' => 'dashboard.module.settings', 'uses' => 'Admin\SettingController@getModuleSettings']);
		$router->resource('settings', 'Admin\SettingController', ['except' => ['show', 'edit', 'update', 'destroy', 'create'], 'names' => [
			'index' => 'dashboard.setting.index',
			'store' => 'dashboard.setting.store'
		]]);
	});
});
