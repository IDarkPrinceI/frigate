<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_id');
            $table->string('control_id');
            $table->string('date_start');
            $table->string('date_finish');
            $table->integer('lasting');
        });
//        Schema::create('checks', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('object');
//            $table->string('control');
//            $table->string('date_start');
//            $table->string('date_finish');
//            $table->integer('lasting');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checks');
    }
}
