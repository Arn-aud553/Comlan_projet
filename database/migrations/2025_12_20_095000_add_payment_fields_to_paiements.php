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
            // Ajouter payment_method et payment_details si elles n'existent pas
            if (!Schema::hasColumn('paiements', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('paiements', 'payment_details')) {
                $table->text('payment_details')->nullable()->after('payment_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            if (Schema::hasColumn('paiements', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('paiements', 'payment_details')) {
                $table->dropColumn('payment_details');
            }
        });
    }
};
