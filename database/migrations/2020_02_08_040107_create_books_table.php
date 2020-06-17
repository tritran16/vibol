<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->integer('type')->default(1)->comment('1: pdf, 2 : video');
            $table->string('filename', 255)->nullable();
            $table->string('file_link', 1000)->nullable();
            $table->string('video_link', 1000)->nullable();
            $table->integer('page_number')->default(1);
            $table->integer('category_id');
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(1)->comment('1: public, 2: pending; 3: un-public');
            $table->tinyInteger('is_hot')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('books');
    }
}
