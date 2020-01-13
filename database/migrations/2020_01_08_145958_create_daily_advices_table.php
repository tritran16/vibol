<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAdvicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_advices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('advice', 1000);
            $table->text('description')->nullable();

            $table->string('author', 50);
            $table->smallInteger('status')->nullable()->comment('1: new; 2: active; 3 un-active');
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
        Schema::dropIfExists('daily_advices');
    }
}
