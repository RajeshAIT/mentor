<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VideoReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videoreports', function (Blueprint $table) {
            $table->id();
            $table->string('report_content')->nullable();
            $table->string('comments')->nullable();
            $table->string('answer_by')->nullable();
            $table->string('answer_id')->nullable();
            $table->string('question_id')->nullable();
            $table->string('report_by')->nullable();
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
        Schema::dropIfExists('videoreports');
    }
}
