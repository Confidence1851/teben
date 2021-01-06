<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            if(!Schema::hasColumn('media', 'downloads_count')) $table->bigInteger('downloads_count')->default(0);
            if(!Schema::hasColumn('media', 'views_count')) $table->bigInteger('views_count')->default(0);
            if(!Schema::hasColumn('media', 'likes_count')) $table->bigInteger('likes_count')->default(0);
            if(!Schema::hasColumn('media', 'comments_count')) $table->bigInteger('comments_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            //
        });
    }
}
