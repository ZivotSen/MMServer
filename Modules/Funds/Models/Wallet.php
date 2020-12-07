<?php

namespace Modules\Funds\Models;

use App\Traits\TransactionMethods;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\Decimal128;

class Wallet extends Model
{
    use TransactionMethods;

    protected $connection = 'funds_schema';
    protected $collection = 'wallets';

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
        'funds_holder_id', 'previous_balance', 'enabled'
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
        'iban' => null,
        'bic' => null,
        'account_number' => null,
        'card_id' => null,
        'primary' => false,
        'enabled' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',
        'balance',
        'previous_balance',
        'funds_holder_id',
        'iban',             // International Bank Account Number
        'bic',              // Bank Identifier Code
        'account_number',
        'card_id',
        'primary',
        'enabled',
    ];

    /**
     * The attributes that always should be persisted independent if are hidden.
     * Use always as copy of hidden attributes
     *
     * @return array
     */
    protected function saveHidden(){
        return ['funds_holder_id', 'previous_balance', 'enabled'];
    }

    /**
     * The transforms to be applied before create a wallet.
     *
     * @param array|null $data
     * @return void
     */
    protected function transformData(&$data = null){
        // Setting default additional fields
        if($type = WalletType::where('key', config('funds.default_wallet_type'))->first()){
            $data['type_id'] = $type->_id;
        }
        $data['balance'] = new Decimal128(0.00);
        $data['previous_balance'] = new Decimal128(0.00);
    }

    /**
     * The Funds Holder that belong to the Wallet.
     */
    public function fundsHolder(){
        return $this->belongsTo(FundsHolder::class, 'funds_holder_id');
    }

    // Function to get balances in a correct format
    public function getBalance(){
        $value = (string) $this->balance;
        return number_format($value, 2, '.', ',');
    }

    /**
     * Function to properly modify the wallet balance.
     * @param $amount
     * @param $operation
     *
     * @return void
     */
    public function modifyBalance($amount, $operation = "+"){
        switch ($operation){
            case "-":
                $newBalance = $this->getBalance() - number_format($amount, 2, '.', ',');
                $this->balance = new Decimal128($newBalance);
                break;
            default:
                $newBalance = $this->getBalance() + number_format($amount, 2, '.', ',');
                $this->balance = new Decimal128($newBalance);
                break;
        }
    }
}
