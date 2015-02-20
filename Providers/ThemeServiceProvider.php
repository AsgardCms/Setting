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
        $this->registerAllThemes();
        $this->setActiveTheme();
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
