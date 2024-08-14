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
        Schema::create('campaign_application_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_application_id')->constrained();
            $table->string('carrier_id')->comment('택배사 아이디');
            $table->string('tracking_number')->comment('송장번호');
            $table->string('tracking_status')->default(\App\Enums\TrackDelivery\TrackEventStatusCodeEnum::UNKNOWN->value)->comment('배송상태');
            $table->string('callback_url')->nullable()->comment('콜백 URL');
            $table->dateTime('expired_at')->nullable()->comment('콜백 URL 만료기간');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_application_parcels');
    }
};
