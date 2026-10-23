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
        Schema::create('channels', function (Blueprint $table) {
        $table->id();
        // Связь со станцией. При удалении станции удалятся и её каналы (onDelete('cascade'))
        $table->foreignId('station_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Название канала (например, "Основной", "Rock")
        $table->string('stream_url'); // Ссылка на аудиопоток
        $table->boolean('is_main')->default(false); // Флаг главного канала
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
