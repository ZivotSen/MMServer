<?php

namespace Modules\Funds\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Funds\Models\FundsHolderType;

class FundsHolderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            ['name' => 'Subscriber', 'key' => 'subscriber', 'description' => 'Subscriber type'],
            ['name' => 'Merchant', 'key' => 'merchant', 'description' => 'Merchant type'],
            ['name' => 'Distributor', 'key' => 'distributor', 'description' => 'Distributor type'],
            ['name' => 'Sub Distributor', 'key' => 'sub-distributor', 'description' => 'Sub Distributor type'],
            ['name' => 'Reseller', 'key' => 'reseller', 'description' => 'Reseller type'],
            ['name' => 'Sub Reseller', 'key' => 'sub-reseller', 'description' => 'Sub Reseller type'],
            ['name' => 'Operator', 'key' => 'operator', 'description' => 'Operator type'],
            ['name' => 'Stand Alone Reseller', 'key' => 'stand-alone-reseller', 'description' => 'Stand Alone Reseller type'],
        ];

        foreach ($defaults as $type){
            FundsHolderType::create($type);
        }
    }
}
