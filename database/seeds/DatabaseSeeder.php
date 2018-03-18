<?php

use Illuminate\Database\Seeder; 
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call(UsersTableSeeder::class);        
        // $this->call(PermissionSeeder::class);
        $this->call(Backpack\LangFileManager\database\seeds\LanguageTableSeeder::class);
        $this->call(Backpack\Settings\database\seeds\SettingsTableSeeder::class);
        $this->call(ProductionSeeder::class);

        Model::reguard();

    }
}
