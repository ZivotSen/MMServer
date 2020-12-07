<?php

namespace Modules\Administration\Models;

use App\Traits\TransactionMethods;
use Jenssegers\Mongodb\Eloquent\Model;

class UserSpecificFields extends Model
{
    use TransactionMethods;

    protected $connection = 'administration_schema';
    protected $collection = 'user_specific_fields';

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
     * The model's default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'address' => null,
        'address_alternative' => null,
        'city' => null,
        'county' => null,
        'state' => null,
        'zip' => null,
        'country' => 'USA',
        'company' => null,
        'url' => null,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address',
        'address_alternative',
        'city',
        'county',
        'state',
        'zip',
        'country',
        'company',
        'url',
    ];
}
