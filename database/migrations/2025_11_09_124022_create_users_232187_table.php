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
            $table->id('id_232187');
            $table->string('username_232187');
            $table->string('avatar_232187')->nullable();
            $table->string('email_232187')->unique();
            $table->string('password_232187');
            $table->string('role_232187');
            $table->timestamp('email_verified_at_232187')->nullable();
            $table->timestamp('last_login_time_232187')->nullable();
            $table->string('last_login_ip_232187')->nullable();
            $table->timestamp('last_seen_time_232187')->nullable();

            $table->boolean('force_logout_232187')->default(false);


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
