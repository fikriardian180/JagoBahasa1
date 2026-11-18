<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('title');
            $table->longText('content_text');
            $table->string('audio_url')->nullable();
            $table->text('transcript')->nullable();
            $table->json('vocabulary')->nullable();
            $table->string('speaking_target_phrase')->nullable();
            $table->text('grammar_prompt')->nullable();
            $table->integer('xp_reward')->default(50);
            $table->integer('order_number')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
