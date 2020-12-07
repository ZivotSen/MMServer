<?php

namespace Modules\Administration\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'administration_schema';
    protected $collection = 'profiles';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The Users that have this Profile.
     */
    public function users(){
        return $this->hasMany(User::class, 'profile_id');
    }

    /**
     * The associated Roles and permissions for this Profile.
     */
    public function profileRoles(){
        return $this->hasMany(ProfileRole::class, 'profile_id');
    }

    public function rolesList(){
        $roles = array();
        if ($profileRoles = $this->profileRoles) {
            foreach ($profileRoles as $profileRole){
                $roles = array_merge($profileRole->grants(), $roles);
            }
        }
        return $roles;
    }
}
