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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->comment('상품명');
            $table->string('title')->comment('제목');
            $table->text('benefit')->nullable()->comment('제공내역');
            $table->integer('benefit_point')->nullable()->comment('제공포인트');
            $table->text('visit_instruction')->nullable()->comment('방문 및 예약안내');
            $table->string('address')->nullable()->comment('주소');
            $table->text('mission')->comment('미션');
            $table->text('extra_information')->nullable()->comment('추가사항');
            $table->dateTime('application_start_at')->comment('캠페인 신청 시작일');
            $table->dateTime('application_end_at')->comment('캠페인 신청 마감일');
            $table->dateTime('announcement_at')->comment('선정결과 발표일');
            $table->dateTime('registration_start_date_at')->comment('콘텐츠 등록기간 시작일');
            $table->dateTime('registration_end_date_at')->comment('콘텐츠 등록기간 마감일');
            $table->dateTime('result_announcement_date_at')->comment('캠페인 결과발표일');
            $table->string('status')->default('DRAFT')->comment('캠페인 상');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
