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
            if (!Schema::hasColumn('contenus', 'id_auteur')) {
                $table->foreignId('id_auteur')->nullable()->constrained('users', 'id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            if (Schema::hasColumn('contenus', 'id_auteur')) {
                $table->dropForeign(['id_auteur']);
                $table->dropColumn('id_auteur');
            }
        });
    }
};
