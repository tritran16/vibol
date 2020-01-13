<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->integer('category_id');
            $table->string('thumbnail', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('author', 50)->nullable();
            $table->string('short_desc', 1000)->nullable();
            $table->text('content')->nullable();
            $table->string('source', 255)->nullable();
            $table->date('published_date')->nullable();
            $table->text('comment')->nullable();
            $table->smallInteger('status')->default(0)->comment('0: new; 1: public, 2: pending; 3: un-public');
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
        Schema::dropIfExists('news');
    }
}
