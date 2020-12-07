<?php

namespace Modules\Administration\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ProfileRole extends Model
{
    protected $connection = 'administration_schema';
    protected $collection = 'profile_role';

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
        'profile_id',
        'role_id',
        'grant',
    ];

    /**
     * The Profile that belong to this association.
     */
    public function profile(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * The Role that belong to this association.
     */
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function grants(){
        $grants = array();
        $start = "ROLE_";

        if($this->role){
            $grants[] = strtoupper($start.$this->role->name);
        }

        if(isset($this->grant) && !empty($this->grant)){
            foreach ($this->grant as $permission){
                if(array_search(strtoupper($permission), config('administration.permissions'))){
                    $grants[] = strtoupper($start.$this->role->name."_{$permission}");
                }
            }
        }

        return $grants;
    }
}
