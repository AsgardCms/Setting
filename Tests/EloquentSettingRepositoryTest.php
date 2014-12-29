<?php namespace Modules\Setting\Tests;

class EloquentSettingRepositoryTest extends BaseSettingTest
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_creates_translated_setting()
    {
        // Prepare
        $data = [
            'core::site-name' => [
                'en' => 'AsgardCMS_en',
                'fr' => 'AsgardCMS_fr',
            ]
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $setting = $this->settingRepository->find(1);
        $this->assertEquals('core::site-name', $setting->name);
        $this->assertEquals('AsgardCMS_en', $setting->translate('en')->value);
        $this->assertEquals('AsgardCMS_fr', $setting->translate('fr')->value);
    }

    /** @test */
    public function it_creates_plain_setting()
    {
        // Prepare
        $data = [
            'core::template' => 'asgard'
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $setting = $this->settingRepository->find(1);
        $this->assertEquals('core::template', $setting->name);
        $this->assertEquals('asgard', $setting->plainValue);
    }
}
