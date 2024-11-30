<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('at_ip_address', 255)->nullable();
            $table->string('at_username', 255)->nullable();
            $table->string('at_page', 255)->nullable();
            $table->string('at_action', 255)->nullable();
            $table->text('at_description')->nullable();
            $table->text('at_browser')->nullable();
            $table->text('at_sql')->nullable();
            $table->integer('at_date_added')->nullable();
            $table->string('at_section', 255)->nullable();
            
            $table->primary('id');
            $table->index('at_ip_address');
            $table->index('at_username');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
