<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedInteger('news_category_id');
            $table->unique(['news_category_id', 'locale']);
            $table->foreign('news_category_id')->references('id')->on('news_categories');//->onDelete('cascade');

            // Actual fields you want to translate
            $table->string('name');
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_category_translations');
    }
}
