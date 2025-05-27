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
            $table->string('procurement_project');
            $table->string('lot_description');
            $table->decimal('abc_per_lot', 15, 2);  
            $table->decimal('total_abc', 15, 2);
            $table->string('end_user');
            $table->string('pr_number');
            $table->string('approved_app');
            $table->date('date_received_from_planning')->nullable(); 
            $table->date('date_received_by_twg')->nullable();
            $table->string('twg');
            $table->date('date_forwarded_to_budget')->nullable();
            $table->date('approved_pr_received')->nullable();
            $table->date('philgeps_posting_date')->nullable();
            $table->string('rfq_itb_number');
            $table->date('bid_opening')->nullable();
            $table->string('sq_number');
            $table->string('bac_res_number');
            $table->date('date_of_bac_res_completely_signed')->nullable();
            $table->string('noa_number');
            $table->string('canvasser');
            $table->string('name_of_supplier');
            $table->decimal('contract_price', 15, 2);
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
