<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('namoNr');
            $table->string('pastatoTip');
            $table->string('irengimoTip');
            $table->string('sildymoTip');
            $table->string('namoTip');
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
        Schema::dropIfExists('nams');
    }
}
