<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailcheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailcheck', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->bigInteger('check_id')->unsigned();
            $table->foreign('check_id')->references('id')->on('check')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailcheck');
    }
}
