<?php

namespace Modules\Administration\Models;

use App\Traits\TransactionMethods;
use App\Traits\ValidatorModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Modules\Funds\Models\FundsHolder;
use Modules\Funds\Models\UserFundsHolder;
use Zivot\Mongodb\Passport\HasApiTokens;
use \Zivot\Mongodb\Passport\Auth\User as Authenticable;

class User extends Authenticable
{
    use HasApiTokens, HasFactory, Notifiable, ValidatorModel, TransactionMethods;

    protected $connection = 'administration_schema';
    protected $collection = 'users';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'profile_id', 'verified', 'enabled', 'deleted'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /**
     * The model's default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'verified' => false,
        'logged' => false,
        'enabled' => true,
        'deleted' => false
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_id',
        'username',
        'name',
        'last',
        'email',
        'phone',
        'password',
        'verified',
        'logged',
        'enabled',
        'deleted',
        'last_activity',
    ];

    /**
     * The rules that should be validated.
     *
     * @var array
     */
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'last' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'string', 'min:8', 'max:25', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    /**
     * The attributes that always should be persisted independent if are hidden.
     * Use always as copy of hidden attributes
     *
     * @return array
     */
    protected function saveHidden(){
        return ['password', 'remember_token', 'profile_id', 'verified', 'enabled', 'deleted'];
    }

    /**
     * The transforms to be applied before create an user.
     *
     * @param array|null $data
     * @return void
     */
    protected function transformData(&$data = null){
        $data['password'] = Hash::make($data['password'], [
            'rounds' => 12,
        ]);

        // Setting default additional fields
        $data['profile_id'] = null;
        if($profile = Profile::where('name', config('administration.default_profile_name'))->first()){
            $data['profile_id'] = $profile->_id;
        }

        $data['last_activity'] = new \DateTime('now');
    }

    /**
     * The Profile that belong to the User.
     */
    public function profile(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * The Funds Holder associated with the User.
     */
    public function funds(){
        $collection = array();
        $resources = UserFundsHolder::where('user_id', $this->_id)->get();
        foreach ($resources as $resource){
            $collection[] = $resource->fundsHolder;
        }
        return $collection;
    }

    public function ownerOfFunds(){
        return $this->hasMany(FundsHolder::class, "owner_user_id");
    }

    public function roles(){
        $roles = array();
        if($this->enabled && !$this->deleted){
            if($profile = $this->profile) {
                $roles = $profile->rolesList();
            }
        }
        return $roles;
    }

    public function hasRole($role){
        if($role && !empty($this->roles())){
            if(in_array($role, $this->roles())){
                return true;
            }
        }
        return false;
    }
}
