<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained();
            $table->enum('evaluation_type', ['progress', 'final', 'midterm']);
            $table->decimal('technical_score', 5, 2)->nullable();
            $table->decimal('documentation_score', 5, 2)->nullable();
            $table->decimal('presentation_score', 5, 2)->nullable();
            $table->decimal('innovation_score', 5, 2)->nullable();
            $table->decimal('teamwork_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('recommendations')->nullable();
            $table->boolean('is_final')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['project_id', 'supervisor_id', 'evaluation_type']);
            $table->index('is_final');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};