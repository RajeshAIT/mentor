<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postmedia', function (Blueprint $table) {
            $table->dropForeign('postmedia_post_id_foreign');
            //$table->dropForeign('postmedia_media_type_id_foreign');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('media_type_id')->references('id')->on('mediatypes')->onDelete('cascade');
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
            $table->dropForeign('post_id');
            $table->dropForeign('media_type_id');
        });
    }
}
