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
            // Check if columns exist before adding (safeguard)
            if (!Schema::hasColumn('contenus', 'id_region')) {
                $table->foreignId('id_region')->nullable()->constrained('regions', 'id_region');
            }
            if (!Schema::hasColumn('contenus', 'id_langue')) {
                $table->foreignId('id_langue')->nullable()->constrained('langues', 'id_langue');
            }
             if (!Schema::hasColumn('contenus', 'id_moderateur')) {
                $table->foreignId('id_moderateur')->nullable()->constrained('users', 'id');
            }
            // created_at & updated_at are likely missing too based on 'timestamps' usually adding them
             if (!Schema::hasColumn('contenus', 'created_at')) {
                 $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            //
        });
    }
};
