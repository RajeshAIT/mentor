<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('emotion_id');
            $table->foreign('emotion_id')->references('id')->on('emotions');
            $table->unsignedBigInteger('question_association_id');
            $table->foreign('question_association_id')->references('id')->on('question_associations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question', function (Blueprint $table) {
		$table->dropForeign(['category_id']);
		$table->dropForeign(['emotion_id']);
		$table->dropForeign(['question_association_id']);
		$table->dropColumn('category_id');
		$table->dropColumn('emotion_id');
		$table->dropColumn('question_association_id');
        });
    }
}
