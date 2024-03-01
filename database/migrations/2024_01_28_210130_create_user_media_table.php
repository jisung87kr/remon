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
        Schema::create('user_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('media')->comment('미디어 채널명(블로그, 인스타, 유튜브 등)');
            $table->string('url')->comment('미디어 채널 url');
            $table->string('connected_status')->default('UNCONNECTED')->comment('연결 상태');
            $table->timestamps();
            $table->unique(['user_id', 'media', 'url', 'connected_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_media');
    }
};
