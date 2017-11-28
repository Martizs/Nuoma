<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patalpuTipas');
            $table->string('savivaldybe');
            $table->string('gyvenviete');
            $table->string('mikroRaj');
            $table->string('gatve');
            $table->double('plotas');
            $table->text('komentaras');
            $table->integer('kaina');
            $table->string('statusas');
            $table->double('ivertinimas');
            $table->integer('user_id');
            $table->integer('nuomin_id');
            $table->string('apsilankymas');
            $table->integer('post_history_id');
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
        Schema::dropIfExists('posts');
    }
}
