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
        // Vérifier si la colonne n'existe pas déjà
        if (!Schema::hasColumn('users', 'id_langue')) {
            Schema::table('users', function (Blueprint $table) {
                // Ajouter la colonne id_langue
                $table->foreignId('id_langue')
                      ->nullable()
                      ->after('email')
                      ->constrained('langues', 'id_langue')
                      ->onDelete('set null');
                
                // Pour PostgreSQL, alternative :
                // $table->bigInteger('id_langue')->nullable()->after('email');
                // $table->foreign('id_langue')
                //       ->references('id_langue')
                //       ->on('langues')
                //       ->nullOnDelete();
            });
            
            // Info de débogage
            echo "Colonne id_langue ajoutée à la table users\n";
        } else {
            echo "La colonne id_langue existe déjà dans la table users\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la contrainte étrangère d'abord
            $table->dropForeign(['id_langue']);
            // Puis la colonne
            $table->dropColumn('id_langue');
        });
    }
};