<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('student_number')->unique();
            $table->string('academic_year');
            $table->enum('status', ['active', 'graduated', 'transferred', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'department_id']);
            $table->index('student_number');
            $table->index('academic_year');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};