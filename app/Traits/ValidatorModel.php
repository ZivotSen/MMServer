<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidatorModel
{
    protected $errors;

    public function isValid(array $data){
        $validator = self::validator($data);
        if($validator->fails()){
            $this->errors = $validator->messages()->get('*');
            return false;
        }

        return true;
    }

    public function getErrors(){
        return $this->errors;
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, $this->getRules());
    }

    protected function getRules() {
        return property_exists($this, 'rules') ? $this->rules : [];
    }
}
