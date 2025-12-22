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
        Schema::table('paiements', function (Blueprint $table) {
            // Rendre media_id nullable pour permettre les paiements de contenus sans média
            $table->unsignedBigInteger('media_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Remettre media_id comme non nullable
            $table->unsignedBigInteger('media_id')->nullable(false)->change();
        });
    }
};
