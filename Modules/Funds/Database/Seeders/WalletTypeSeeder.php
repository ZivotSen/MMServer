<?php

namespace Modules\Funds\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Funds\Models\WalletType;

class WalletTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            ['name' => 'Checking', 'key' => 'chk', 'description' => 'Checking line type'],
            ['name' => 'Saving', 'key' => 'sav', 'description' => 'Saving line type'],
            ['name' => 'Credit', 'key' => 'crd', 'description' => 'Credit line type'],
            ['name' => 'IRA', 'key' => 'ira', 'description' => 'Individual Retirement Account line type'],
            ['name' => 'Loan', 'key' => 'loa', 'description' => 'Loan line type'],
            ['name' => 'Fund', 'key' => 'fnd', 'description' => 'Fund line type'],
            ['name' => 'Unlimited', 'key' => 'unl', 'description' => 'Unlimited line type'],
        ];

        foreach ($defaults as $type){
            WalletType::create($type);
        }
    }
}
