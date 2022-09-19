<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateTopKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keywords')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'TopKeyWordsSeeder',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_keywords');
    }
}
