<?php

namespace Modules\Funds\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FundsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(FundsHolderTypeSeeder::class);
        $this->call(WalletTypeSeeder::class);
    }
}
