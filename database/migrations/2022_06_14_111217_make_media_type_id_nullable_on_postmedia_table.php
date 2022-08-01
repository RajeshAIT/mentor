<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMediaTypeIdNullableOnPostmediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postmedia', function (Blueprint $table) {
            $table->bigInteger('media_type_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postmedia', function (Blueprint $table) {
            $table->bigint('media_type_id')->unsigned()->nullable(false)->change();
        });
    }
}
