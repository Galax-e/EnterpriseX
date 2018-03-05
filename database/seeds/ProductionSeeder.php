<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Team;
use App\Models\Project;
use App\User;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'   => 'Super User',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('Password1'),
            // 'role' => 'admin'
        ]);
        // DB::table('users')
        //     ->where('id', 1)
        //     ->update(['password' => bcrypt('Password1')]);
        
        User::create([
            'name'   => 'Super Admin',
            'email'    => 'nwaugha@gmail.com',
            'password' => bcrypt('Password1'),
            // 'role' => 'admin'
        ]);
    }
}
