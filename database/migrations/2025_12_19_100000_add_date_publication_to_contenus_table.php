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
            if (!Schema::hasColumn('contenus', 'date_publication')) {
                $table->timestamp('date_publication')->nullable()->after('date_validation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            if (Schema::hasColumn('contenus', 'date_publication')) {
                $table->dropColumn('date_publication');
            }
        });
    }
};
