<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postreports', function (Blueprint $table) {
            $table->id();
            $table->string('report_content')->nullable();
            $table->string('comments')->nullable();
            $table->string('post_by')->nullable();
            $table->string('post_id')->nullable();
            $table->string('post_type')->nullable();
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
        Schema::dropIfExists('postreports');
    }
}
