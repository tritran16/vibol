<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->integer('category_id');
            $table->string('thumb', 255)->nullable();
            $table->string('author', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('source', 255)->nullable();
            $table->string('link', 1000)->nullable();
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
        Schema::dropIfExists('videos');
    }
}
