<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipclassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internshipclass', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_day');
            $table->dateTime('end_day');
            $table->string('note')->nullable();
            $table->string('name_unsigned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internshipclass');
    }
}
