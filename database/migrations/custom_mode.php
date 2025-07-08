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
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->json('custom_mode')->nullable()->after('mode_of_procurement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->dropColumn('custom_mode');
        });
    }
};

