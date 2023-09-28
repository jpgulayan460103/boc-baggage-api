<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelers', function (Blueprint $table) {
            $table->id();
            $table->string('last_name')->nullable()->fulltext();
            $table->string('first_name')->nullable()->fulltext();
            $table->string('middle_name')->nullable()->fulltext();
            $table->string('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_place_issued')->nullable();
            $table->date('passport_date_issued')->nullable();
            $table->string('occupation')->nullable()->fulltext();
            $table->string('contact_number')->nullable();
            $table->text('philippines_address')->nullable();
            $table->date('last_departure_date')->nullable()->index();
            $table->string('origin_country')->nullable()->fulltext();
            $table->date('arrival_date')->nullable()->index();
            $table->string('flight_number')->nullable()->fulltext();
            $table->string('remarks')->nullable()->fulltext();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travelers');
    }
}
