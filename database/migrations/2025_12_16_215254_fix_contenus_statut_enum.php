<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Correction de l'incohérence entre l'ENUM de la base de données
     * qui utilise 'publié' (avec accent) et le code PHP qui utilise 'publie' (sans accent)
     */
    public function up(): void
    {
        // Étape 1: Migrer les données existantes (si elles existent)
        // Convertir 'publié' -> 'publie'
        DB::table('contenus')
            ->where('statut', 'publié')
            ->update(['statut' => 'publie']);
            
        // Convertir 'rejeté' -> 'rejete'
        DB::table('contenus')
            ->where('statut', 'rejeté')
            ->update(['statut' => 'rejete']);
            
        // Convertir 'supprimé' -> 'supprime'
        DB::table('contenus')
            ->where('statut', 'supprimé')
            ->update(['statut' => 'supprime']);
            
        // Convertir 'archivé' -> 'archive'
        DB::table('contenus')
            ->where('statut', 'archivé')
            ->update(['statut' => 'archive']);
        
        // Étape 2: Modifier l'ENUM pour utiliser les valeurs sans accent
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE contenus MODIFY COLUMN statut ENUM('publie', 'en attente', 'brouillon', 'rejete', 'archive', 'supprime') DEFAULT 'brouillon'");
        } elseif ($driver === 'pgsql') {
            // Pour PostgreSQL, on doit d'abord supprimer la contrainte CHECK existante
            DB::statement("ALTER TABLE contenus DROP CONSTRAINT IF EXISTS contenus_statut_check");
            
            // Puis ajouter la nouvelle contrainte avec les valeurs sans accent
            DB::statement("ALTER TABLE contenus ADD CONSTRAINT contenus_statut_check CHECK (statut IN ('publie', 'en attente', 'brouillon', 'rejete', 'archive', 'supprime'))");
        } elseif ($driver === 'sqlite') {
            // Pour SQLite, on doit recréer la table
            Schema::create('contenus_temp', function (Blueprint $table) {
                $table->id('id_contenu');
                $table->string('titre', 255);
                $table->text('texte');
                $table->timestamp('date_creation')->useCurrent();
                $table->string('statut')->default('brouillon');
                $table->timestamp('date_validation')->nullable();
                $table->foreignId('id_region')->nullable()->constrained('regions', 'id_region');
                $table->foreignId('id_langue')->nullable()->constrained('langues', 'id_langue');
                $table->foreignId('id_moderateur')->nullable()->constrained('users', 'id');
                $table->foreignId('id_type_contenu')->nullable()->constrained('type_contenus', 'id_type_contenu');
                $table->foreignId('id_auteur')->constrained('users', 'id');
                $table->decimal('prix', 10, 2)->default(0);
                $table->boolean('is_active')->default(false);
                $table->timestamp('date_publication')->nullable();
                $table->timestamps();
                
                $table->index('statut');
                $table->index('date_creation');
            });
            
            DB::statement('INSERT INTO contenus_temp SELECT * FROM contenus');
            Schema::dropIfExists('contenus');
            Schema::rename('contenus_temp', 'contenus');
        }
        
        // Étape 3: Mettre à jour is_active pour tous les contenus publiés
        DB::table('contenus')
            ->where('statut', 'publie')
            ->update(['is_active' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        // Restaurer les données
        DB::table('contenus')
            ->where('statut', 'publie')
            ->update(['statut' => 'publié']);
            
        DB::table('contenus')
            ->where('statut', 'rejete')
            ->update(['statut' => 'rejeté']);
        
        if ($driver === 'mysql') {
            // Restaurer l'ancien ENUM
            DB::statement("ALTER TABLE contenus MODIFY COLUMN statut ENUM('publié', 'en attente', 'brouillon', 'rejeté') DEFAULT 'brouillon'");
        } elseif ($driver === 'sqlite') {
            // Pour SQLite, recréer avec l'ancien format
            Schema::create('contenus_temp', function (Blueprint $table) {
                $table->id('id_contenu');
                $table->string('titre', 255);
                $table->text('texte');
                $table->timestamp('date_creation')->useCurrent();
                $table->string('statut')->default('brouillon');
                $table->timestamp('date_validation')->nullable();
                $table->foreignId('id_region')->nullable()->constrained('regions', 'id_region');
                $table->foreignId('id_langue')->nullable()->constrained('langues', 'id_langue');
                $table->foreignId('id_moderateur')->nullable()->constrained('users', 'id');
                $table->foreignId('id_type_contenu')->nullable()->constrained('type_contenus', 'id_type_contenu');
                $table->foreignId('id_auteur')->constrained('users', 'id');
                $table->decimal('prix', 10, 2)->default(0);
                $table->boolean('is_active')->default(false);
                $table->timestamp('date_publication')->nullable();
                $table->timestamps();
                
                $table->index('statut');
                $table->index('date_creation');
            });
            
            DB::statement('INSERT INTO contenus_temp SELECT * FROM contenus');
            Schema::dropIfExists('contenus');
            Schema::rename('contenus_temp', 'contenus');
        }
    }
};
