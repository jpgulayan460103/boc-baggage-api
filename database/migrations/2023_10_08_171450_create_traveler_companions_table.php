<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelerCompanionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traveler_companions', function (Blueprint $table) {
            $table->id();
            $table->string('last_name')->nullable()->fulltext();
            $table->string('first_name')->nullable()->fulltext();
            $table->string('middle_name')->nullable()->fulltext();
            $table->string('fullname')->nullable()->fullText();
            $table->string('birth_date')->nullable();
            $table->foreignId('traveler_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('traveler_companions');
    }
}
