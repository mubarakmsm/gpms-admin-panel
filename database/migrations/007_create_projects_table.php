<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('abstract')->nullable();
            $table->text('objectives')->nullable();
            $table->enum('status', ['pending', 'approved', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->integer('progress')->default(0);
            $table->string('academic_year');
            $table->date('submission_date')->nullable();
            $table->date('defense_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['team_id', 'academic_year']);
            $table->index(['team_id', 'status']);
            $table->index('academic_year');
            $table->index('progress');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};