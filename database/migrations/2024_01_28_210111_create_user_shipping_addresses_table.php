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
        Schema::create('user_shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_default')->default(0)->comment('기본 배송지');
            $table->string('title')->comment('배송지 제목');
            $table->string('name')->comment('받는 사람');
            $table->string('phone')->comment('받는 사람 연락처');
            $table->string('address_postcode')->comment('우편번호');
            $table->string('address')->comment('주소');
            $table->string('address_detail')->comment('주소 상세');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shipping_addresses');
    }
};
