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
        Schema::create('contenus', function (Blueprint $table) {
            $table->id('id_contenu');
            $table->string('titre', 255);
            $table->text('texte');
            $table->timestamp('date_creation')->useCurrent();
            $table->enum('statut', ['publié', 'en attente', 'brouillon', 'rejeté'])->default('brouillon');
            // parent_id RETIRÉ
            $table->timestamp('date_validation')->nullable();
            $table->foreignId('id_region')->constrained('regions', 'id_region');
            $table->foreignId('id_langue')->constrained('langues', 'id_langue');
            $table->foreignId('id_moderateur')->nullable()->constrained('users', 'id');
            $table->foreignId('id_type_contenu')->constrained('type_contenus', 'id_type_contenu');
            $table->foreignId('id_auteur')->constrained('users', 'id');
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('statut');
            $table->index('date_creation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};