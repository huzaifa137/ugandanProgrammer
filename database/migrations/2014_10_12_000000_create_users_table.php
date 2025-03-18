<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();;
            $table->string('email')->nullable();;
            $table->string('password')->nullable();;
            $table->string('temp_otp')->nullable();;
            $table->string('user_role')->nullable();;
            $table->string('user_status')->nullable();;
            $table->string('firstname')->nullable();;
            $table->string('lastname')->nullable();;
            $table->string('gender')->nullable();;
            $table->string('phonenumber')->nullable();;
            $table->string('account_status')->nullable();;
            $table->integer('country')->nullable();
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
        Schema::dropIfExists('users');
    }
}
