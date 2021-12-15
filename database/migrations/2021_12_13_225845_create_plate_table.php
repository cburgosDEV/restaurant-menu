<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlateTable extends Migration
{
    public function up()
    {
        Schema::create('plate', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('description', '1000')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('state')->default(true);
            $table->string('image', 255)->default('no-image.png');

            //Relations
            $table->unsignedBigInteger('idCategory')->unsigned();
            $table->foreign('idCategory')->references('id')->on('category')->onUpdate('no action')->onDelete('no action');

            //Stamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plate');
    }
}
