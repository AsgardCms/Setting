<?php namespace Modules\Setting\Support;

use Illuminate\Cache\CacheManager;
use Modules\Core\Contracts\Setting;
use Modules\Setting\Repositories\SettingRepository;

class Settings implements Setting
{
    /**
     * @var SettingRepository
     */
    private $setting;
    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * @param SettingRepository $setting
     * @param CacheManager      $cache
     */
    public function __construct(SettingRepository $setting, CacheManager $cache)
    {
        $this->setting = $setting;
        $this->cache = $cache;
    }

    /**
     * Getting the setting
     * @param  string $name
     * @param  string   $locale
     * @param  string   $default
     * @return mixed
     */
    public function get($name, $locale = null, $default = null)
    {
        if ($this->cache->has("setting.$name.$locale")) {
            return $this->cache->get("setting.$name.$locale");
        }

        $defaultFromConfig = $this->getDefaultFromConfigFor($name);

        $setting = $this->setting->get($name);
        if (! $setting) {
            return is_null($default) ? $defaultFromConfig : $default;
        }

        if ($setting->isTranslatable) {
            if ($setting->hasTranslation($locale)) {
                $default = empty($setting->translate($locale)->value) ? $defaultFromConfig : $setting->translate($locale)->value;
                $this->cache->put("setting.$name.$locale", $default, '3600');
            } else {
                $this->cache->put("setting.$name.$locale", $defaultFromConfig, '3600');
            }
        } else {
            $default = empty($setting->plainValue) ? $defaultFromConfig : $setting->plainValue;
            $this->cache->put("setting.$name.$locale", $default, '3600');
        }

        return $this->cache->get("setting.$name.$locale");
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $name
     * @return bool
     */
    public function has($name)
    {
        $default = microtime(true);

        return $this->get($name, null, $default) !== $default;
    }

    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value)
    {
    }

    /**
     * Get the default value from the settings configuration file,
     * for the given setting name.
     * @param string $name
     * @return string
     */
    private function getDefaultFromConfigFor($name)
    {
        list($module, $settingName) = explode('::', $name);

        return config("asgard.$module.settings.$settingName.default", '');
    }
}
