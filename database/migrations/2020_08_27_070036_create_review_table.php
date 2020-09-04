<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->string('content');

            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('reviewer_id')->unsigned();
            $table->foreign('reviewer_id')->references('id')->on('member')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
