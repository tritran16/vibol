<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('type')->comment('1: advice, 2: news, 3: video, 4: book, 5: other');
            $table->string('title', 255);
            $table->string('body', 1000);
            $table->bigInteger('item_id')->nullable();
            $table->smallInteger('send_to')->default(0)->comment('0: all; 1 : iOS, 2: Android');
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
        Schema::dropIfExists('notifications');
    }
}
