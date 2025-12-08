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
        // Drop the existing media table and recreate it with proper structure
        Schema::dropIfExists('media');
        
        Schema::create('media', function (Blueprint $table) {
            $table->id('id_media');
            $table->string('nom_fichier', 255);
            $table->string('chemin_fichier', 500);
            $table->string('type_fichier', 100); // image, video, document, livre
            $table->string('extension', 20); // jpg, png, mp4, pdf, etc.
            $table->bigInteger('taille_fichier')->nullable(); // en bytes
            $table->string('mime_type', 100)->nullable();
            
            // Relations
            $table->foreignId('id_contenu')
                ->nullable()
                ->constrained('contenus', 'id_contenu')
                ->onDelete('cascade');
            
            $table->foreignId('id_utilisateur')
                ->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('type_fichier');
            $table->index('id_contenu');
            $table->index('id_utilisateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
        
        // Recréer l'ancienne structure si nécessaire
        Schema::create('media', function (Blueprint $table) {
            $table->foreignId('id_langue')
                ->constrained('langues', 'id_langue')
                ->onDelete('cascade');
            $table->primary(['id_langue']);
            $table->timestamps();
        });
    }
};
