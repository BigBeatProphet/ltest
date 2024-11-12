<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStopsTable extends Migration
{
    public function up(){
        Schema::create('stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stopname', 255);
            $table->string('location', 255);
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('stops');
    }
}
