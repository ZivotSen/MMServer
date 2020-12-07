<?php

namespace Modules\Administration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            ['name' => 'ADMIN', 'description' => 'Role Administrator'],
            ['name' => 'BALANCE', 'description' => 'Role Balance'],
            ['name' => 'BENEFICIARY', 'description' => 'Role Beneficiary'],
            ['name' => 'COMMISSION', 'description' => 'Role Commission'],
            ['name' => 'FUNDS', 'description' => 'Role Funds'],
            ['name' => 'HISTORY', 'description' => 'Role History'],
            ['name' => 'KYC', 'description' => 'Role KYC'],
            ['name' => 'LOG', 'description' => 'Role Log'],
            ['name' => 'MENU', 'description' => 'Role Menu'],
            ['name' => 'PROFILE', 'description' => 'Role Profile'],
            ['name' => 'PROMOTION', 'description' => 'Role Promotion'],
            ['name' => 'ROLE', 'description' => 'Role Role'],
            ['name' => 'SUPPORT', 'description' => 'Role Support'],
            ['name' => 'TRANSACTION', 'description' => 'Role History'],
            ['name' => 'USER', 'description' => 'Role User'],
        ];

        DB::table('roles')->insert($defaults);
    }
}
