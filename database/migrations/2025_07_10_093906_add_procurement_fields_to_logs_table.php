<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // Add new fields
            $table->string('procurement_project')->nullable()->after('user_name');
            $table->text('lot_description')->nullable()->after('procurement_project');

            // Drop model_name
            $table->dropColumn('model_name');
        });
    }

    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn(['procurement_project', 'lot_description']);
            $table->string('model_name')->nullable(); // restore if needed
        });
    }
};
