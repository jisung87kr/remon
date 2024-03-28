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
        Schema::create('campaign_application_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_application_id');
            $table->foreignId('campaign_application_field_id');
            $table->text('value')->comment('신청정보 필드 사용자 입력 값');
            $table->timestamps();
            $table->comment('신청 정보 사용자 입력 테이블');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_application_values');
    }
};
