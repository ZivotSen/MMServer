<?php

namespace Modules\Funds\Models;

use App\Traits\TransactionMethods;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\Administration\Models\User;

class UserFundsHolder extends Model
{
    use TransactionMethods;

    protected $connection = 'funds_schema';
    protected $collection = 'user_funds_holder';

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
        'user_id',
        'funds_holder_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fundsHolder(){
        return $this->belongsTo(FundsHolder::class, 'funds_holder_id');
    }
}
