<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Ensure valid JSON values for status and mode_of_procurement
        DB::statement("UPDATE procurement_projects SET status = JSON_QUOTE(status) WHERE status IS NOT NULL AND JSON_VALID(status) = 0");
        DB::statement("UPDATE procurement_projects SET mode_of_procurement = JSON_QUOTE(mode_of_procurement) WHERE mode_of_procurement IS NOT NULL AND JSON_VALID(mode_of_procurement) = 0");

        // Step 2: Change column types
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->json('status')->nullable()->change();
            $table->json('mode_of_procurement')->nullable()->change();

            // Step 3: Add new column
            $table->json('bid_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->string('status')->change();
            $table->string('mode_of_procurement')->change();
            $table->dropColumn('bid_status');
        });
    }
};

