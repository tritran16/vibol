<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedBigInteger('news_id');
            $table->unique(['news_id', 'locale']);
            $table->foreign('news_id')->references('id')->on('news');//->onDelete('cascade');

            // Actual fields you want to translate
            $table->string('title');
            $table->string('short_desc', 1000);
            $table->longText('content');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_translations');
    }
}
