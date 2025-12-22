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
        Schema::table('contenus', function (Blueprint $table) {
            $table->unsignedBigInteger('id_region')->nullable()->change();
            $table->unsignedBigInteger('id_langue')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            // Attention: cela peut échouer s'il y a déjà des valeurs NULL
            // On fait le best effort pour reverser mais sans garantie absolue selon les données
            $table->unsignedBigInteger('id_region')->nullable(false)->change();
            $table->unsignedBigInteger('id_langue')->nullable(false)->change();
        });
    }
};
