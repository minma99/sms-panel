<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();

            $table->string('mobile');
            $table->text('message');

            $table->string('type')->default('manual');
            $table->string('status')->default('pending');
            $table->string('provider')->nullable();

            $table->string('template_key')->nullable();
            $table->string('provider_message_id')->nullable();

            $table->text('response')->nullable();
            $table->text('error_message')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->nullableMorphs('related');

            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
