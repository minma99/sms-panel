<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trainees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('national_code', 10)->unique();
            $table->string('phone', 20)->nullable()->index();
            $table->date('birth_date')->nullable();
            $table->enum('registration_status', ['ثبت نام شده', 'انصراف داده', 'تکمیل شده'])->default('ثبت نام شده');
            $table->string('exam_status')->nullable();
            $table->string('certificate_status')->nullable();
            $table->decimal('total_fee', 15, 0)->default(0);
            $table->integer('discount_percent')->default(0);
            $table->decimal('exam_fee', 15, 0)->default(0);
            $table->date('exam_date')->nullable();
            $table->string('exam_date_shamsi')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // ایجاد رابطه به صورت صریح
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }
    public function down(): void { Schema::dropIfExists('trainees'); }
};
