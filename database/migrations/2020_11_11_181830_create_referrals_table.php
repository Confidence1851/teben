<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal("parent_points")->default(0);
            $table->decimal("my_points")->default(0);
            $table->tinyInteger("ref_direct")->default(0); //0 for code , 1 for url
            $table->tinyInteger("type")->default(0);  // 0 for manual , 1 for auto
            $table->tinyInteger("status")->default(1);  // 0 for not active , 1 for active 
            $table->string('coupon')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('referrals');
    }
}
