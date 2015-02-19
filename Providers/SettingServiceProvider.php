<?php namespace Modules\Setting\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repositories\Eloquent\EloquentSettingRepository;
use Modules\Setting\Support\Settings;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app['setting.settings'] = $this->app->share(function ($app) {
            return new Settings($app['Modules\Setting\Repositories\SettingRepository'], $app['cache']);
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Settings', 'Modules\Setting\Facades\Settings');
        });

        $this->registerAllThemes();
        $this->setActiveTheme();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Setting\Repositories\SettingRepository',
            function () {
                return new EloquentSettingRepository(new Setting());
            }
        );
        $this->app->bind(
            'Modules\Core\Contracts\Setting',
            'Modules\Setting\Support\Settings'
        );
    }

    /**
     * Set the active theme based on the settings
     */
    private function setActiveTheme()
    {
        if ($this->app->runningInConsole() || ! $this->asgardIsInstalled()) {
            return;
        }

        if ($this->inAdministration() || $this->onAuthentication()) {
            $themeName = $this->app['config']->get('asgard.core.core.admin-theme');

            return $this->app['stylist']->activate($themeName, true);
        }

        $themeName = $this->app['setting.settings']->get('core::template', null, 'Demo');

        return $this->app['stylist']->activate($themeName, true);
    }

    /**
     * Check if we are in the administration
     * @return bool
     */
    private function inAdministration()
    {
        $segment = config('laravellocalization.hideDefaultLocaleInURL', false) ? 1 : 2;

        return $this->app['request']->segment($segment) === $this->app['config']->get('asgard.core.core.admin-prefix');
    }

    /**
     * Register all themes with activating them
     */
    private function registerAllThemes()
    {
        $themePaths = $this->app['stylist']->discover(base_path('Themes'));

        $this->app['stylist']->registerPaths($themePaths);
    }

    /**
     * Check if Asgard is installed
     * @return bool
     */
    private function asgardIsInstalled()
    {
        /** @var \Illuminate\Contracts\Filesystem\Filesystem $finder */
        $finder = app('Illuminate\Contracts\Filesystem\Filesystem');

        return $finder->exists('.env');
    }

    /**
     * Check if we are on the authentication pages
     * @return bool
     */
    private function onAuthentication()
    {
        return $this->app['request']->segment(2) === 'auth';
    }
}
