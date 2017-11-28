<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('statusas'); //Ar atsiliepimas apie skelbima ar apie vartotoja
            $table->text('atsiliepimas');
            $table->integer('user_id'); //Userio palikusio atsiliepima ID
            $table->integer('rev_id'); //Patalpu arba userio id apie kuri paliktas atsiliepimas
            $table->double('ivertinimas');
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
        Schema::dropIfExists('reviews');
    }
}
