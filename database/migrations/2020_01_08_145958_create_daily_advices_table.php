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
            $table->string('image', 1000);
            $table->text('content')->nullable();
            $table->smallInteger('text_position')
                ->comment('1: top; 2: middle, 3: bottom');
            $table->string('author', 50)->nullable();
            $table->smallInteger('status')->nullable()->comment('1: new; 2: active; 3 un-active');
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
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
