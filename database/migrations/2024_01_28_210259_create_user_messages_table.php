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
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('message_type')->comment('메세지 유형(sms, push, email 등)');
            $table->string('message_name')->comment('메세지 이름(광고, 계정, 캠페인 등)');
            $table->text('content')->comment('메세지 내용');
            $table->string('status')->nullable()->comment('전송 상태');
            $table->dateTime('confirmed_at')->nullable()->comment('확인 시간');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_messages');
    }
};
