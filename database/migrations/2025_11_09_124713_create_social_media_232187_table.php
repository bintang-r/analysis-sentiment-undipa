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
        Schema::create('social_media_232187', function (Blueprint $table) {
            $table->id('id_232187');
            $table->string('name_232187')->nullable();
            $table->boolean('is_active_232187')->default(true)->nullable();
            $table->timestamps('update_at_232187');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_232187');
    }
};
