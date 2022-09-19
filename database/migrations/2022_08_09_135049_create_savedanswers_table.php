<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedanswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savedanswers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saved_by');
            $table->foreign('saved_by')->references('id')->on('users');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('question');
            $table->string('status'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savedanswers');
    }
}
