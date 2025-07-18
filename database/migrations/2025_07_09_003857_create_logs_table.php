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
    $table->string('user_name');
    $table->string('model_name'); 
    $table->text('changed_fields')->nullable(); 
    $table->string('procurement_project')->nullable(); 
    $table->json('lot_description')->nullable(); 
    $table->timestamps(); 
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
