<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundsHolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('funds_schema')->create('funds_holder', function (Blueprint $table) {
            $table->string('name', 50)->index();
            $table->string('owner_user_id')->index();
            $table->string('description')->nullable();
            $table->string('type_id')->index();
            $table->integer('kyc_level')->nullable();
            $table->string( 'currency', 5);
            $table->boolean('shared');
            $table->boolean('enabled');
            $table->boolean('deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funds_holder');
    }
}
