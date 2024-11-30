<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('Iso');
            $table->string('Name');
            $table->string('Iso3');
            $table->string('NumCode');
            $table->string('PhoneCode');
            $table->timestamps(0);
            $table->string('Nationality')->nullable();
            $table->integer('member_state')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
