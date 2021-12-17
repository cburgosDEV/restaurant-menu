<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            //Relations
            $table->unsignedBigInteger('idRestaurant')->unsigned()->nullable();
            $table->foreign('idRestaurant')->references('id')->on('restaurant')->onUpdate('no action')->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {

        });
    }
}
