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
            $table->text('thumbnail')->nullable()->comment('컨텐츠 썸네일');
            $table->text('title')->nullable()->comment('컨텐츠 설명');
            $table->text('content')->nullable()->comment('컨텐츠 본문');
            $table->text('author')->nullable()->comment('컨텐츠 작성자');
            $table->text('profile_img')->nullable()->comment('컨텐츠 작성자 프로필');
            $table->dateTime('content_created_at')->nullable()->comment('원본 컨텐츠 등록일자');
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
