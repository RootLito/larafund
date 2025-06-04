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
        Schema::create('procurement_projects', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->text('procurement_project');
            $table->json('lot_description');
            $table->json('abc_per_lot');  
            $table->decimal('total_abc', 15, 2);
            $table->string('end_user');
            $table->string('pr_number')->nullable();
            $table->string('approved_app')->nullable();
            $table->date('date_received_from_planning')->nullable(); 
            $table->date('date_received_by_twg')->nullable();
            $table->string('twg')->nullable();
            $table->date('date_forwarded_to_budget')->nullable();
            $table->date('approved_pr_received')->nullable();
            $table->date('philgeps_posting_date')->nullable();
            $table->string('rfq_itb_number')->nullable();
            $table->date('bid_opening')->nullable();
            $table->string('sq_number')->nullable();
            $table->string('bac_res_number')->nullable();
            $table->date('date_of_bac_res_completely_signed')->nullable();
            $table->string('noa_number')->nullable();
            $table->string('canvasser')->nullable();
            $table->string('name_of_supplier')->nullable();
            $table->decimal('contract_price', 15, 2)->nullable();
            $table->date('date_forwarded_to_gss')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_projects');
    }
};
