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
            $table->timestamps();
            $table->string('temp_otp')->nullable();;
            $table->string('user_role')->nullable();;
            $table->string('user_status')->nullable();;
            $table->string('procurement_approval_status')->nullable();;
            $table->string('firstname')->nullable();;
            $table->string('lastname')->nullable();;
            $table->string('gender')->nullable();;
            $table->string('phonenumber')->nullable();;
            $table->string('user_id')->nullable();;
            $table->string('account_status')->nullable();;
            $table->integer('supervisor')->nullable();
            $table->string('title')->nullable();;
            $table->string('user_supervisor')->nullable();;
            $table->string('user_title')->nullable();
            $table->integer('procurement_year')->nullable();;
            $table->string('user_reference', 255)->nullable();
            $table->string('user_last_active', 255)->nullable();
            $table->string('user_signature', 255)->nullable();
            $table->string('passport_number', 255)->nullable();
            $table->integer('country')->nullable();
            $table->primary('id');            
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
