<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // $table->string('procurement_project')->nullable()->after('user_name');
            $table->text('lot_description')->nullable()->after('procurement_project');

            $table->dropColumn('model_name');
        });
    }

    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['procurement_project', 'lot_description']);
            $table->string('model_name')->nullable(); 
        });
    }
};
