<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '1000')->nullable();
            $table->string('address', '100')->nullable();
            $table->string('phone1', '20')->nullable();
            $table->string('phone2', '20')->nullable();
            $table->string('email', '100')->nullable();
            $table->string('web', '100')->nullable();

            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant');
    }
}
