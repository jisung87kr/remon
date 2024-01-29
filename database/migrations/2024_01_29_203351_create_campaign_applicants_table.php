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
            $table->string('status')->default(ApplicantStatus::APPLIED->name)->comment('신청상태');
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
