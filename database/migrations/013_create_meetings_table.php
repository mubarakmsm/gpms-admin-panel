<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('meeting_date');
            $table->integer('duration_minutes')->default(60);
            $table->enum('meeting_type', ['regular', 'progress', 'emergency', 'evaluation'])->default('regular');
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['team_id', 'supervisor_id']);
            $table->index('meeting_date');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('meetings');
    }
};