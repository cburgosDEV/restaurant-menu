<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantImageTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_image', function (Blueprint $table) {
            $table->id();
            $table->string('url')->default('no-image.png');
            $table->boolean('isPrincipal')->default(false);
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idRestaurant')->unsigned();
            $table->foreign('idRestaurant')->references('id')->on('restaurant')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_image');
    }
}
