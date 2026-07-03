<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trainee_id')->constrained()->cascadeOnDelete();

            $table->string('exam_title');                 // نام آزمون
            $table->date('exam_date');                    // تاریخ
            $table->time('start_time')->nullable();       // ساعت شروع
            $table->time('end_time')->nullable();         // ساعت پایان

            $table->string('exam_type', 50)->default('dakheli');
            // fanni-herfei | dakheli | miandore | payan_dore (یا هرچی خواستی)

            $table->string('location')->nullable();       // محل برگزاری
            $table->string('status', 50)->nullable();     // نتیجه/وضعیت: passed/failed/absent/pending/...

            $table->text('note')->nullable();             // توضیح (اختیاری)

            $table->timestamps();

            // ایندکس‌های مفید برای گزارش/فیلتر
            $table->index(['trainee_id', 'exam_date']);
            $table->index(['exam_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
