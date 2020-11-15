<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name');
            $table->decimal("amount")->default(0);
            $table->decimal("processing_amount")->default(0);
            $table->decimal("total_amount")->default(0);
            $table->decimal("withdrawn_amount")->default(0);
            $table->integer("direct_refs")->default(0);
            $table->integer("indirect_refs")->default(0);
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
        Schema::dropIfExists('ref_wallets');
    }
}
