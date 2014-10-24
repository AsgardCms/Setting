<?php namespace Modules\Setting\Support;

use Modules\Setting\Repositories\SettingRepository;

class Reader
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function read($name, $module = null)
    {

    }
}
