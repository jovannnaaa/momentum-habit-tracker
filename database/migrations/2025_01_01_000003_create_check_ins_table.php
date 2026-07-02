<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('note', 280)->nullable();
            $table->timestamps();

            $table->unique(['habit_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
