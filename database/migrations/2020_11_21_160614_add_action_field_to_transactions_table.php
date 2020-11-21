<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionFieldToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if(!Schema::hasColumn('transactions', 'action')) $table->tinyInteger('action')->after("status");
            if(!Schema::hasColumn('transactions', 'reference_id')) $table->unsignedBigInteger('reference_id')->nullable();
            // if(Schema::hasColumn('transactions', 'type')) $table->tinyInteger('type')->change();
            // if(Schema::hasColumn('transactions', 'status')) $table->string('status')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
