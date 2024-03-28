<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Campaign\ApplicantStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('name')->comment('신청자 이름');
            $table->string('birthdate')->comment('신청자 생년월일');
            $table->enum('sex', ['man', 'woman'])->comment('신청자 성별');
            $table->string('phone')->comment('신청자 연락처');
            $table->string('status')->default(ApplicantStatus::APPLIED->value)->comment('신청상태');
            $table->boolean('portrait_right_consent')->default(0)->comment('초상권 활용 동의');
            $table->boolean('base_right_consent')->default(0)->comment('캠페인 유의사항, 개인정보 및 콘텐츠 제3자 제공, 저작물이용 동의');
            $table->string('shipping_name')->nullable()->comment('받는 사람');
            $table->string('shipping_phone')->nullable()->comment('받는 사람 연락처');
            $table->string('address_postcode')->nullable()->comment('우편번호');
            $table->string('address')->nullable()->comment('주소');
            $table->string('address_detail')->nullable()->comment('주소 상세');
            $table->string('address_extra')->nullable()->comment('참고항목');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_applicants');
    }
};
