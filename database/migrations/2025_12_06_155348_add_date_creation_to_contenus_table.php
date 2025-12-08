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
            if (!Schema::hasColumn('contenus', 'date_creation')) {
                $table->timestamp('date_creation')->useCurrent();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenus', function (Blueprint $table) {
            if (Schema::hasColumn('contenus', 'date_creation')) {
                $table->dropColumn('date_creation');
            }
        });
    }
};
