<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTravelerTypePurpose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travelers', function (Blueprint $table) {
            $table->string('traveler_type')->nullable();
            $table->string('travel_purpose')->nullable();
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
            $table->dropColumn('traveler_type');
            $table->dropColumn('travel_purpose');
        });
    }
}
