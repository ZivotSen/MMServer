<?php

namespace Modules\Administration\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Administration\Models\Profile;
use Modules\Administration\Models\Role;

class ProfileRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = Profile::where('name', config('administration.default_profile_name'))->first();
        $role = Role::where('name', config('administration.default_role_name'))->first();
        $grant = [config('administration.default_role_permission')];

        $defaults = [
            'profile_id' => $profile->_id,
            'role_id' => $role->_id,
            'grant' => $grant,
        ];

        DB::table('profile_role')->insert($defaults);
    }
}
