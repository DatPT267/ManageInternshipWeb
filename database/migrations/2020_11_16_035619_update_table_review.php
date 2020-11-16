<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review', function (Blueprint $table) {
            $table->dropForeign('review_group_id_foreign');
            $table->dropForeign('review_reviewer_id_foreign');
            $table->dropForeign('review_task_id_foreign');
            $table->dropForeign('review_user_id_foreign');

            $table->dropColumn(['task_id', 'group_id', 'user_id']);

            $table->integer('reviewOf');
            $table->bigInteger('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('review')->onDelete('cascade')->onUpdate('cascade');


            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->dropForeign('review_reviewer_id_foreign');
            $table->foreign('reviewer_id')->references('id')->on('member')->onDelete('cascade')->onUpdate('cascade');

            $table->dropForeign('review_parent_id_foreign');
            $table->dropColumn(['reviewOf', 'parent_id']);

        });
    }
}
