<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    public function up(){
        Schema::create('buses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('busname', 255);
            $table->timestamps();

        });
    }
    public function down(){
        Schema::dropIfExists('buses');
    }
}