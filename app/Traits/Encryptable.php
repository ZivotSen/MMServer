<?php

namespace App\Traits;

/*Use as*/
/*
    use Encryptable;
    protected $encrypts = [
        'blood_type',
        'medical_conditions',
        'allergies',
        'emergency_contact_id',
    ];
 * */

use Illuminate\Support\Facades\Crypt;

trait Encryptable
{
    public function getAttribute($key) {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->getEncrypts())) {
            $value = Crypt::decrypt($value);
        }
        return $value;
    }

    public function setAttribute($key, $value) {
        if (in_array($key, $this->getEncrypts())) {
            $value = Crypt::encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function attributesToArray() {
        $attributes = parent::attributesToArray();
        foreach($this->getEncrypts() as $key) {
            if(array_key_exists($key, $attributes)) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }

    protected function getEncrypts() {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }
}
