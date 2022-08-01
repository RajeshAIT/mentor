<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCompanyVerifies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_verifies', function (Blueprint $table) {
            $table->boolean('verify')->after('website')->default('0')->nullable();
            $table->string('token')->after('verify')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_verifies', function (Blueprint $table) {
            $table->dropColumn('verify')->nullable(false);
            $table->dropColumn('token')->nullable(false);
        });
    }
}
