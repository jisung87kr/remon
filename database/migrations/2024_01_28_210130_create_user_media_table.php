<?php

use App\Enums\MediaConnectedStatusEnum;
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
            $table->string('connected_status')->default(MediaConnectedStatusEnum::UNCONNECTED->value)->comment('연결 상태');
            $table->string('mediaid')->nullable()->comment('미디어 아이디');
            $table->string('name')->nullable()->comment('이름');
            $table->string('display_name')->nullable()->comment('닉네임');
            $table->text('introduce')->nullable()->comment('소개');
            $table->string('profile_url')->nullable()->comment('프로필 이미지');
            $table->integer('day_visitor_count')->nullable()->comment('일 방문자');
            $table->integer('subscriber_count')->nullable()->comment('구독자');
            $table->integer('total_visitor_count')->nullable()->comment('전체 방문자');
            $table->integer('content_count')->nullable()->comment('컨텐츠 수');
            $table->boolean('official_blog')->nullable()->comment('공식블로그');
            $table->boolean('power_blog')->nullable()->comment('파워블로그');
            $table->string('blog_no')->nullable()->comment('블로그 고유아이디');
            $table->jsonb('raw_data')->nullable()->comment('원본 데이터');
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
