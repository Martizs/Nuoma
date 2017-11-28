<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('namoNr');
            $table->integer('butoNr');
            $table->integer('aukstas');
            $table->integer('kambSk');
            $table->string('pastatoTip');
            $table->string('irengimoTip');
            $table->string('sildymoTip');
            $table->integer('aukstuSk');
            $table->integer('metai');
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
        Schema::dropIfExists('buts');
    }
}
