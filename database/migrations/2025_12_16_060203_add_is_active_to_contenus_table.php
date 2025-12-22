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
            // Add is_active column as boolean, default to false
            $table->boolean('is_active')->default(false)->after('statut');
        });
        
        // Update existing records: set is_active = true where statut = 'publie'
        DB::table('contenus')
            ->where('statut', 'publie')
            ->update(['is_active' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
