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
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type')->comment('추가, 차감 구분');
            $table->integer('point')->comment('포인트');
            $table->string('description')->comment('설명');
            $table->foreignId('campaign_id')->nullable()->comment('캠페인 아이디(옵션)');
            $table->datetime('expired_at')->nullable()->comment('만료일');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points');
    }
};
