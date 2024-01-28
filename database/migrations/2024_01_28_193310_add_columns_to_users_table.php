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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nick_name')->nullable()->comment('닉네임')->after('name');
            $table->string('phone')->nullable()->comment('휴대폰')->after('password');
            $table->dateTime('phone_verified_at')->nullable()->comment('휴대폰 인증')->after('phone');
            $table->enum('sex', ['man', 'woman'])->nullable()->comment('성별')->after('phone_verified_at');
            $table->string('birthdate')->nullable()->comment('생년월일')->after('sex');
            $table->integer('level')->default(0)->comment('회원 레벨')->after('profile_photo_path');
            $table->boolean('agree_email')->default(0)->comment('이메일 수신 여부')->after('level');
            $table->boolean('agree_sms')->default(0)->comment('문자 수신 여부')->after('agree_email');
            $table->boolean('agree_push')->default(0)->comment('푸시 수신 여부')->after('agree_sms');
            $table->boolean('point')->default(0)->comment('포인트')->after('agree_push');
            $table->string('status')->default('ACTIVE')->comment('회원 상태')->after('sex');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nick_name');
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified_at');
            $table->dropColumn('sex');
            $table->dropColumn('birthdate');
            $table->dropColumn('level');
            $table->dropColumn('agree_email');
            $table->dropColumn('agree_sms');
            $table->dropColumn('agree_push');
            $table->dropColumn('status');
        });
    }
};
