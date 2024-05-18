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
        Schema::create('campaign_media_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('campaign_id');
            $table->foreignId('campaign_media_id');
            $table->uuid('banner_id')->nullable();
            $table->foreignId('campaign_application_id');
            $table->string('content_url')->nullable()->comment('컨텐츠 url');
            $table->text('description')->nullable()->comment('컨텐츠 설명');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_media_contents');
    }
};
