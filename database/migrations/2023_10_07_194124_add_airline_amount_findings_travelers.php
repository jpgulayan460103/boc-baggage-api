<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAirlineAmountFindingsTravelers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travelers', function (Blueprint $table) {
            $table->string('airline')->nullable();
            $table->string('findings')->nullable();
            $table->string('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travelers', function (Blueprint $table) {
            $table->dropColumn('airline');
            $table->dropColumn('findings');
            $table->dropColumn('amount');
        });
    }
}
