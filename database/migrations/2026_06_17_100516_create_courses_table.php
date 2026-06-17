<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
    $table->id();

    $table->string('title');

    $table->unsignedInteger('price')->default(0);

    $table->unsignedInteger('duration')->nullable();

    $table->unsignedInteger('capacity')->default(1);

    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();

    $table->string('start_date_shamsi')->nullable();
    $table->string('end_date_shamsi')->nullable();

    $table->text('description')->nullable();

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
