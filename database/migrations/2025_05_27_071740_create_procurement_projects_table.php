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



            $table->json('philgeps_posting_date')->nullable();
            $table->json('rfq_itb_number')->nullable();
            $table->json('bid_opening')->nullable();
            $table->json('sq_number')->nullable();
            $table->json('bac_res_number')->nullable();
            $table->json('date_of_bac_res_completely_signed')->nullable();
            $table->json('noa_number')->nullable();
            $table->json('canvasser')->nullable();
            $table->json('name_of_supplier')->nullable();
            $table->json('contract_price')->nullable();
            $table->json('date_forwarded_to_gss')->nullable();
            $table->json('remarks')->nullable();
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
