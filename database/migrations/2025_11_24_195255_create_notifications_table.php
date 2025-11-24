<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // email, push, sms, webhook
            $table->string('channel')->default('app'); // app, email, sms, push
            $table->string('recipient'); // email, phone, user_id, etc
            $table->string('subject')->nullable();
            $table->text('message');
            $table->json('data')->nullable(); // metadata adicional
            $table->string('status')->default('pending'); // pending, sent, failed, read
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->timestamp('scheduled_at')->nullable(); // para notificaciones programadas
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->string('service_name')->nullable(); // qué microservicio la envió
            $table->string('reference_id')->nullable(); // ID del recurso relacionado
            $table->integer('retry_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas rápidas
            $table->index(['status', 'created_at']);
            $table->index(['recipient', 'status']);
            $table->index(['service_name', 'created_at']);
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};