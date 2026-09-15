<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('father');
            $table->string('village');
            $table->string('mobile', 10);

            $table->string('aadhar_no', 12);
            $table->string('biometric_no')->nullable();

            $table->string('student_photo')->nullable();
            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};