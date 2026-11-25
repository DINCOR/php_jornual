<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('task_id')->constrained()->restrictOnDelete();
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->boolean('is_office');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'started_at']);
        });

        DB::statement("ALTER TABLE work_logs ADD CONSTRAINT work_logs_period_check CHECK (ended_at > started_at AND ended_at - started_at <= interval '8 hours')");
    }

    public function down(): void
    {
        Schema::dropIfExists('work_logs');
    }
};
