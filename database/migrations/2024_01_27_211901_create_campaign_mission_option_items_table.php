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
        Schema::create('campaign_mission_option_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_mission_option_id')->constrained('campaign_mission_option')->onDelete('cascade');
            $table->text('content')->comment('내용');
            $table->text('sub_content')->nullable()->comment('부가 내용');
            $table->text('extra_content1')->nullable()->comment('여분필드1');
            $table->text('extra_content2')->nullable()->comment('여분필드2');
            $table->text('extra_content3')->nullable()->comment('여분필드3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_mission_option_items');
    }
};
