<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeAdvicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_advices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('advice_id');
            $table->integer('device_id');
            $table->tinyInteger('status')->default(0)->comment('o: dislike, 1: like');
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
        Schema::dropIfExists('like_advices');
    }
}
