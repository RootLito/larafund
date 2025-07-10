<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
    $table->id();
    $table->string('user_name'); // Name of the user who made the change
    $table->string('model_name'); // E.g., ProcurementProject
    $table->text('changed_fields')->nullable(); // JSON or text describing what changed
    $table->string('procurement_project')->nullable(); // add project name
    $table->json('lot_description')->nullable(); // add JSON array for lots
    $table->timestamps(); // includes created_at (log time)
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
