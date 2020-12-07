<?php

namespace Modules\Administration\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'administration_schema';
    protected $collection = 'roles';

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
     * The associated Profiles and permissions for this Role.
     */
    public function profileRoles(){
        return $this->hasMany(ProfileRole::class, 'role_id');
    }
}
