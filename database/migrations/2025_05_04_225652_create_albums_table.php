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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();                         // первичный ключ
            $table->string('title');              // название альбома
            $table->foreignId('artist_id')        // ссылка на автора (user с ролью author)
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->string('cover_path')->nullable(); // путь до обложки
            $table->timestamps();                 // created_at, updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
