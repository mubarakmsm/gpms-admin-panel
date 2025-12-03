<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('previous_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->string('project_title');
            $table->string('academic_year');
            $table->text('abstract');
            $table->text('keywords');
            $table->string('project_domain')->nullable();
            $table->text('technologies_used')->nullable();
            $table->string('file_path')->nullable();
            $table->double('final_grade')->nullable();
            $table->enum('access_level', ['public', 'university', 'department', 'private'])->default('department');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['team_id', 'academic_year']);
            $table->index('access_level');
            $table->index('final_grade');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('previous_projects');
    }
};