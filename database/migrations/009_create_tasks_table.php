<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('team_members')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable();
            $table->double('completion_percentage')->default(0);
            $table->date('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['project_id', 'assigned_to']);
            $table->index(['status', 'priority']);
            $table->index('due_date');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};