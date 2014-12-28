<?php namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Repositories\SettingRepository;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * @var SettingRepository
     */
    private $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            'name' => 'core::template',
            'plainValue' => 'Demo',
            'isTranslatable' => false,
        ];

        $this->setting->create($data);
    }
}
