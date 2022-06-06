<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            //$table->dropcolumn('name');
            $table->unsignedBigInteger('userrole_id')->nullable();
            $table->foreign('userrole_id')->references('id')->on('userrole');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phonenumber')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropcolumn('firstname');
            $table->dropcolumn('lastname');
            $table->dropcolumn('phonenumber');
            $table->dropForeign(['user_role_id']);
            $table->dropColumn('user_role_id');
        });
    }
}