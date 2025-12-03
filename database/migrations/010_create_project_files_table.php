<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->nullable()->constrained('team_members')->onDelete('set null');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size');
            $table->enum('file_type', ['proposal', 'progress_report', 'final_report', 'presentation', 'source_code', 'documentation', 'other']);
            $table->string('mime_type')->nullable();
            $table->text('description')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_final')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['team_id', 'file_type']);
            $table->index('is_final');
            $table->index('version');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_files');
    }
};