<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graphs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diena');
            $table->string('laikas');
            $table->integer('savaitesNr');
            $table->string('statusas');
            $table->integer('user_id'); //Nuomotojo ID
            $table->integer('nuomin_id');
            $table->integer('post_id');
            $table->text('komentaras');
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
        Schema::dropIfExists('graphs');
    }
}
