<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On supprime la table si elle existe déjà pour éviter l'erreur
        if (Schema::hasTable('contenus_temp')) {
            Schema::drop('contenus_temp');
        }

        // Création de la table
        Schema::create('contenus_temp', function (Blueprint $table) {
            $table->id('id_contenu');
            $table->string('titre');
            $table->text('texte');
            $table->timestamp('date_creation')->useCurrent();
            $table->string('statut')->default('brouillon');
            $table->timestamp('date_validation')->nullable();
            $table->foreignId('id_region')->nullable()->constrained('regions');
            $table->foreignId('id_langue')->nullable()->constrained('langues');
            $table->foreignId('id_moderateur')->nullable()->constrained('users');
            $table->foreignId('id_type_contenu')->nullable()->constrained('type_contenus');
            $table->foreignId('id_auteur')->constrained('users');
            $table->decimal('prix', 10, 2)->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamp('date_publication')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenus_temp');
    }
};
