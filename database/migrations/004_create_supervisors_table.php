<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('specialization');
            $table->string('specialization_eng')->nullable();
            $table->string('academic_rank');
            $table->string('academic_rank_eng')->nullable();
            $table->integer('max_projects')->default(5);
            $table->integer('current_projects')->default(0);
            $table->json('expertise_areas')->nullable();
            $table->json('expertise_areas_eng')->nullable();
            $table->text('bio')->nullable();
            $table->enum('status', ['active', 'on_leave', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'department_id']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('supervisors');
    }
};