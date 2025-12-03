<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->nullable()->constrained('supervisors')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('project_title');
            $table->string('project_title_eng')->nullable();
            $table->text('project_description')->nullable();
            $table->text('project_description_eng')->nullable();
            $table->enum('status', ['forming', 'active', 'completed', 'cancelled'])->default('forming');
            $table->integer('progress')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['department_id', 'supervisor_id']);
            $table->index('status');
            $table->index('progress');
            $table->index('created_at');
        });

         Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['leader', 'member'])->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->enum('status', ['active', 'left', 'removed'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['team_id', 'student_id']);
            $table->index(['team_id', 'status']);
            $table->index(['student_id', 'status']);
            $table->index('role');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_members');
    }
};