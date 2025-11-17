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
        Schema::create('point_withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('point')->comment('출금 요청 포인트');
            $table->string('bank_name')->comment('은행명');
            $table->string('account_number')->comment('계좌번호');
            $table->string('account_holder')->comment('예금주');
            $table->string('status')->default('pending')->comment('상태: pending, approved, rejected, completed');
            $table->text('admin_note')->nullable()->comment('관리자 메모');
            $table->timestamp('processed_at')->nullable()->comment('처리 일시');
            $table->foreignId('processed_by')->nullable()->constrained('users')->comment('처리한 관리자 ID');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_withdrawal_requests');
    }
};
