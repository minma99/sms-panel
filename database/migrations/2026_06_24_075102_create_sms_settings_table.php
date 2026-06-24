<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('auto_sms_enabled')->default(false);
            $table->boolean('test_mode')->default(true);

            $table->string('provider')->nullable();
            $table->string('api_key')->nullable();
            $table->string('sender_number')->nullable();
            $table->string('base_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_settings');
    }
};
