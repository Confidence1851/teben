<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('media_id')->index();
            $table->unsignedBigInteger('parent_id');
            $table->text("comment");
            $table->tinyInteger("status")->default(0);  // 0 for not active , 1 for active 
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("media_id")->references("id")->on("media")->cascadeOnDelete();
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
        Schema::dropIfExists('media_comments');
    }
}
