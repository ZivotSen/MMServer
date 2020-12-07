<?php

namespace Modules\Funds\Models;

use App\Traits\TransactionMethods;
use App\Traits\ValidatorModel;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\Administration\Models\User;

class FundsHolder extends Model
{
    use ValidatorModel, TransactionMethods;

    protected $connection = 'funds_schema';
    protected $collection = 'funds_holder';

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
        'owner_user_id', 'shared', 'enabled', 'deleted'
    ];

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
     * The model's default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'kyc_level' => 1,
        'currency' => "USD",
        'shared' => false,
        'enabled' => true,
        'deleted' => false
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'owner_user_id',
        'type_id',
        'kyc_level',
        'currency',
        'shared',
        'enabled',
        'deleted',
    ];

    /**
     * The rules that should be validated.
     *
     * @var array
     */
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'owner_user_id' => ['required', 'string'],
    ];

    /**
     * The attributes that always should be persisted independent if are hidden.
     * Use always as copy of hidden attributes
     *
     * @return array
     */
    protected function saveHidden(){
        return ['owner_user_id', 'shared', 'enabled', 'deleted'];
    }

    /**
     * The transforms to be applied before create a funds holder.
     *
     * @param array|null $data
     * @return void
     */
    protected function transformData(&$data = null){
        // Setting default additional fields
        if($type = FundsHolderType::where('key', config('funds.default_funds_holder_type'))->first()){
            $data['type_id'] = $type->_id;
        }
        $data['currency'] = config('funds.default_funds_holder_currency');
    }

    /**
     * The Funds Holder owner User.
     */
    public function owner(){
        return $this->hasOne(User::class, 'owner_user_id');
    }

    /**
     * The Funds Holder owner User.
     */
    public function type(){
        return $this->hasOne(FundsHolderType::class, 'type_id');
    }

    /**
     * The Users associated with the Funds Holder.
     */
    public function users(){
        $collection = array();
        $resources = UserFundsHolder::where('funds_holder_id', $this->_id)->get();
        foreach ($resources as $resource){
            $collection[] = $resource->user;
        }
        return $collection;
    }

    /**
     * The Wallets that have this Funds Holder.
     */
    public function wallets(){
        return $this->hasMany(Wallet::class, "funds_holder_id");
    }
}
