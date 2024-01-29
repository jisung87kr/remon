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
            $table->string('field_type')->comment('데이터 타입');
            $table->string('field_name')->comment('필드명');
            $table->string('field_options')->nullable()->comment('필드옵션');
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
