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
        Schema::create('users_232187', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_seen_time')->nullable();

            $table->boolean('force_logout')->default(false);


            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_232187');
    }
};
