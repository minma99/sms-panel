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
       Schema::create('payments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('trainee_id')
          ->constrained()
          ->cascadeOnDelete();

    // مبلغ این پرداخت
    $table->unsignedBigInteger('amount');

    // باقی مانده بعد از این پرداخت
    $table->unsignedBigInteger('remaining_after_payment')->nullable();

    // نوع پرداخت
    $table->enum('payment_type', ['full', 'installment'])
          ->default('installment');

    // روش پرداخت
    $table->enum('payment_method', ['cash','card','online'])
          ->nullable();

    $table->string('tracking_code')->nullable();

    $table->date('payment_date')->nullable();
    $table->string('payment_date_shamsi')->nullable();

    $table->text('note')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
