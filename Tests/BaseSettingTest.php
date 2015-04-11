<?php namespace Modules\Setting\Tests;

use Orchestra\Testbench\TestCase;

abstract class BaseSettingTest extends TestCase
{
    /**
     * @var \Modules\Setting\Repositories\SettingRepository
     */
    protected $settingRepository;

    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();

        $this->settingRepository = app('Modules\Setting\Repositories\SettingRepository');
    }

    protected function getPackageProviders($app)
    {
        return ['Modules\Setting\Providers\SettingServiceProvider'];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('asgard.core.settings', [
            'site-name' => [
                'description' => 'core::settings.site-name',
                'view' => 'text',
                'translatable' => true,
            ],
            'template' => [
                'description' => 'core::settings.template',
                'view' => 'core::fields.select-theme',
            ],
        ]);
    }

    protected function getPackageAliases($app)
    {
        return ['Eloquent' => 'Illuminate\Database\Eloquent\Model'];
    }

    private function resetDatabase()
    {
        // Relative to the testbench app folder: vendors/orchestra/testbench/src/fixture
        $migrationsPath = 'Database/Migrations';
        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');
        // Makes sure the migrations table is created
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
        // We empty all tables
        $artisan->call('migrate:reset', [
            '--database' => 'sqlite',
        ]);
        // Migrate
        $artisan->call('migrate', [
            '--database' => 'sqlite',
            '--path'     => $migrationsPath,
        ]);
    }
}
