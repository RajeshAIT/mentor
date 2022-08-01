<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateQuestionAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_associations', function (Blueprint $table) {
            $table->id();
            $table->string('question_association')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'QuestionAssociationSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_associations');
    }
}
