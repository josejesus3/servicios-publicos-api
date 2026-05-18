<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('direction');
            $table->decimal('latitude',12, 9);
            $table->decimal('longitude',12, 9);
            $table->enum('status',['pendiente','en_proceso', 'finalizado'])->default('pendiente');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('area_id')->constrained('areas');
            $table->dateTime('resolution_expire')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
