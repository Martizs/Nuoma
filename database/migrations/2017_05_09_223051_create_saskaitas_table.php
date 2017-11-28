<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaskaitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saskaitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('metai');
            $table->string('menesis');
            $table->double('elektra');
            $table->double('dujos');
            $table->double('karstas');
            $table->double('saltas');
            $table->double('bendraSum');
            $table->string('statusas');
            $table->string('path');
            $table->integer('post_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saskaitas');
    }
}
