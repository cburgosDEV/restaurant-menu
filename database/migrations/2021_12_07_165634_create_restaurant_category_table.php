<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_category', function (Blueprint $table) {
            $table->id();
            $table->boolean('state')->default(true);

            //Relations
            $table->unsignedBigInteger('idRestaurant')->unsigned();
            $table->foreign('idRestaurant')->references('id')->on('restaurant')->onUpdate('no action')->onDelete('no action');

            $table->unsignedBigInteger('idCategory')->unsigned();
            $table->foreign('idCategory')->references('id')->on('category')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_category');
    }
}
