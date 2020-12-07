<?php

namespace Modules\Administration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            ['name' => 'Super_Admin', 'description' => 'Used by Super Administrators'],
            ['name' => 'Administrator', 'description' => 'Used by regular Administrators'],
            ['name' => 'Subscriber', 'description' => 'Used by Subscribers'],
        ];

        DB::table('profiles')->insert($defaults);
    }
}
