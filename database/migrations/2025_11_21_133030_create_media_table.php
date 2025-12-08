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
          Schema::create('media', function (Blueprint $table) {
            $table->foreignId('id_langue')
                ->constrained('langues', 'id_langue')
                ->onDelete('cascade');

            // Définition de la clé primaire composite
            $table->primary(['id_langue']);

            $table->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
