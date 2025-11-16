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
        Schema::create('comments_232187', function (Blueprint $table) {
            $table->id('id_232187');
            $table->foreignId('user_id_232187')->nullable();
            $table->foreignId('social_media_id_232187')->nullable();
            $table->text('comment_232187')->nullable();
            $table->string('status_232187')->nullable();
            $table->timestamps('created_at_232187');
            $table->timestamps('updated_at_232187');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_232187');
    }
};
