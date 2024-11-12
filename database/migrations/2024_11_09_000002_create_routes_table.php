<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('busid')->constrained('buses')->onDelete('cascade'); 
            $table->jsonb('stops')->nullable(); 
            $table->string('routename', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign(['busid']);
        });
        Schema::dropIfExists('routes'); 
    }
}