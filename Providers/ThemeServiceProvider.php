<?php namespace Modules\Setting\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->booted(function () {
            $this->registerAllThemes();
            $this->setActiveTheme();
        });
    }

    /**
     * Set the active theme based on the settings
     */
    private function setActiveTheme()
    {
        if ($this->app->runningInConsole() || ! $this->asgardIsInstalled()) {
            return;
        }

        if ($this->inAdministration()) {
            $themeName = $this->app['config']->get('asgard.core.core.admin-theme');

            return $this->app['stylist']->activate($themeName, true);
        }

        $themeName = $this->app['setting.settings']->get('core::template', null, 'Flatly');

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
        $directories = $this->app['cache']->rememberForever('stylist.theme.directories', function () {
            return $this->app['files']->directories(config('stylist.themes.paths')[0]);
        });

        foreach ($directories as $directory) {
            $this->app['stylist']->registerPath($directory);
        }
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
