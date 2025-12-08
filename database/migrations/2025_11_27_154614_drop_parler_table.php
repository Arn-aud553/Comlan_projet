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
        Schema::dropIfExists('parler');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('parler', function (Blueprint $table) {
            $table->foreignId('id_utilisateur')
                ->constrained('utilisateurs', 'id_utilisateur')
                ->onDelete('cascade');

            $table->foreignId('id_langue')
                ->constrained('langues', 'id_langue')
                ->onDelete('cascade');

            $table->primary(['id_utilisateur', 'id_langue']);
            $table->timestamps();
        });
    }
};
