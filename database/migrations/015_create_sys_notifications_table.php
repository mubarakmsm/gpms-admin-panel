<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sys_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamp('read_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['task', 'meeting', 'submission', 'evaluation', 'supervision', 'system', 'general', 'chat'])->default('general');
            $table->boolean('is_broadcast')->default(false);
            $table->json('target_roles')->nullable();
            $table->json('target_departments')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_broadcast', 'expires_at']);
            $table->index('created_at');
        });

         Schema::create('sys_notification_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sys_notifications_id')->constrained('sys_notifications')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->unique(['sys_notifications_id', 'user_id']);
            $table->index(['user_id', 'is_read']);
            $table->index('read_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sys_notifications');
        Schema::dropIfExists('sys_notification_user');
    }
};