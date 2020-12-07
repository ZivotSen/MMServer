<?php

namespace App\Traits;

trait Helper {
    public function isJSON($string){
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getJSONDecoded($string){
        if(self::isJSON($string)){
            return json_decode($string, true);
        }
        return false;
    }
}
