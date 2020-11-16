<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('feedback');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('content')->nullable();
            $table->dateTime('time');

            $table->bigInteger('review_id')->unsigned();
            $table->foreign('review_id')->references('id')->on('review')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('feedback_id')->unsigned();
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
