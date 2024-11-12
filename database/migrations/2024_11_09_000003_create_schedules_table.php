<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up(){
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('busid');
            $table->unsignedBigInteger('stopid');
            $table->time('arrivaltime');
            $table->timestamps();

            $table->foreign('busid')->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('stopid')->references('id')->on('stops')->onDelete('cascade');
        });
    }
    public function down(){
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['busid','stopid']);
        });
        Schema::dropIfExists('schedules');
    }
}
