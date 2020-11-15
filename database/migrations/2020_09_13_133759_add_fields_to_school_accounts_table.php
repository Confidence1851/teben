<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSchoolAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_accounts', function (Blueprint $table) {
            if(!Schema::hasColumn('school_accounts', 'status')) $table->tinyinteger('status')->default(0)->after('available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_accounts', function (Blueprint $table) {
            //
        });
    }
}
