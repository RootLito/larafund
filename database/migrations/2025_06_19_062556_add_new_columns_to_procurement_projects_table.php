<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToProcurementProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->json('philgeps_advertisement')->nullable();
            $table->json('pre_bid_conference')->nullable();
            $table->json('post_qualification')->nullable();
        });
    }

    public function down()
    {
        Schema::table('procurement_projects', function (Blueprint $table) {
            $table->dropColumn('philgeps_advertisement');
            $table->dropColumn('pre_bid_conference');
            $table->dropColumn('post_qualification');
        });
    }
}