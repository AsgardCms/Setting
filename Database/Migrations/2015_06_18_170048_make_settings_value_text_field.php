<?php

use Illuminate\Database\Migrations\Migration;

class MakeSettingsValueTextField extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `setting__settings` CHANGE `plainValue` `plainValue` TEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;');
        DB::statement('ALTER TABLE `setting__setting_translations` CHANGE `value` `value` TEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL;');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `setting__settings` CHANGE `plainValue` `plainValue` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;');
        DB::statement('ALTER TABLE `setting__setting_translations` CHANGE `value` `value` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL;');
    }

}
