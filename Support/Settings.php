<?php namespace Modules\Setting\Support;

use Modules\Setting\Repositories\SettingRepository;

class Settings
{
    /**
     * @var SettingRepository
     */
    private $setting;

    /**
     * @param SettingRepository $setting
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Getting the setting
     * @param $setting
     * @param null $locale
     * @return mixed
     */
    public function get($setting, $locale = null)
    {
        $setting = $this->setting->get($setting);

        if ($setting->isTranslatable) {
            return $setting->translate($locale)->value;
        }

        return $setting->plainValue;
    }
}
