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
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('media_id')->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string("name");
            $table->text("comment");
            $table->tinyInteger("status")->default(0);  // 0 for not active , 1 for active 
            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete();
            $table->foreign("media_id")->references("id")->on("media")->cascadeOnDelete();
            $table->foreign("parent_id")->references("id")->on("media_comments")->cascadeOnDelete();
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
