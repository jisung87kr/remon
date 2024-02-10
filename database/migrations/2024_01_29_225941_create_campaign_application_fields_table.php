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
        Schema::create('campaign_application_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id');
            $table->string('field_category')->nullable()->comment('필드 카테고리');
            $table->string('name')->comment('필드명(enum 클래스 value 값)');
            $table->string('type')->comment('필드유형(select, radio ...)');
            $table->string('label')->comment('필드 레이블');
            $table->longText('option')->nullable()->comment('필드 항목, 시리얼라이즈로 입력(예:셀렉트박스 옵션값)');
            $table->boolean('is_required')->default(0)->comment('필수여부');
            $table->timestamps();
            $table->comment('신청 정보 필드');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_application_fields');
    }
};
