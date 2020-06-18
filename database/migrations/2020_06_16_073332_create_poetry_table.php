<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoetryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poetries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->string('author', 100)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('video_link', 1000)->nullable();
            $table->text('content')->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->smallInteger('status')->default(1)
                ->comment('1: public,  2: un-public');
            $table->tinyInteger('is_hot')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poetries');
    }
}
