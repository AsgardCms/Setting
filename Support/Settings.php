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
     * @param  null   $locale
     * @param  null   $default
     * @return mixed
     */
    public function get($name, $locale = null, $default = null)
    {
        if (!$this->cache->has("setting.$name.$locale")) {
            $setting = $this->setting->get($name);
            if ($setting) {
                if ($setting->isTranslatable) {
                    $this->cache->put("setting.$name.$locale", $setting->translate($locale)->value, '3600');
                } else {
                    $this->cache->put("setting.$name.$locale", $setting->plainValue, '3600');
                }
            } else {
                return is_null($default) ? '' : $default;
            }
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
}
