<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait TransactionMethods
{
    protected $inserted = null;

    public function createFromTransaction($data, $session){
        if(method_exists($this,'transformData')){
            $this->transformData($data);
        }

        $this->fill($data);

        if($this->timestamps){
            $this->updateTimestamps();
        }

        // Making hidden values visible to persis
        if(method_exists($this,'saveHidden')){
            $this->makeVisible($this->saveHidden());
        }

        // Save the entire object
        $save = $this->toArray();

        $client = $this->getClient();
        $this->inserted = $client
            ->{self::getDataBase()}
            ->{self::getCollection()}
            ->insertOne($save, ['session' => $session]);

        // Reverting visible values to hidden
        if(method_exists($this,'saveHidden')){
            $this->makeHidden($this->saveHidden());
        }
    }

    public function getClient(){
        return DB::connection('mongodb')->getMongoClient();
    }

    public function getDataBase(){
        return $this->getConnection()->getName();
    }

    public function getCollection(){
        return $this->getTable();
    }

    public function getInsertedID(){
        if($this->inserted->getInsertedId()){
            return (string) $this->inserted->getInsertedId();
        }
        return null;
    }
}
