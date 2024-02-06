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
        Schema::create('campaign_mission_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('mission_option_id')->comment('미션 옵션 아이디');
            $table->text('content')->nullable();;
            $table->text('sub_content')->nullable();
            $table->text('extra_content1')->nullable();
            $table->text('extra_content2')->nullable();
            $table->text('extra_content3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_mission_option');
    }
};
