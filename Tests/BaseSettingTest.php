<?php namespace Modules\Setting\Tests;

use Modules\Core\Tests\BaseTestCase;

abstract class BaseSettingTest extends BaseTestCase
{
    /**
     * @var \Modules\Setting\Repositories\Eloquent\EloquentSettingRepository
     */
    protected $settingRepository;

    public function setUp()
    {
        parent::setUp();

        /** @var \Illuminate\Console\Application $artisan */
        $artisan = $this->app->make('Illuminate\Console\Application');
        $artisan->call('module:migrate', ['module' => 'Setting']);

        $this->settingRepository = app('Modules\Setting\Repositories\SettingRepository');
    }
}
