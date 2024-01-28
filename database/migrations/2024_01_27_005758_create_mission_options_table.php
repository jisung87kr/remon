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
        Schema::create('mission_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_id')->constrained()->onDelete('cascade');
            $table->string('option_name')->comment('옵션명');
            $table->string('option_value')->nullable()->comment('옵션값');
            $table->string('additional_price')->comment('옵션금액');
            $table->string('extra_name1')->nullable()->comment('여분필드1');
            $table->string('extra_value1')->nullable()->comment('여분필드1');
            $table->string('extra_name2')->nullable()->comment('여분필드2');
            $table->string('extra_value2')->nullable()->comment('여분필드2');
            $table->string('extra_name3')->nullable()->comment('여분필드3');
            $table->string('extra_value3')->nullable()->comment('여분필드3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_options');
    }
};
