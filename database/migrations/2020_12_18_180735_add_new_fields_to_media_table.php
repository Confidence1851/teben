<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            if(!Schema::hasColumn('media', 'author_id')) {
                $table->unsignedBigInteger('author_id')->after("id")->index()->nullable();
                $table->foreign("author_id")->references("id")->on("users")->nullOnDelete();
            }
            if(!Schema::hasColumn('media', 'description')) $table->longText('description')->after("title");
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
