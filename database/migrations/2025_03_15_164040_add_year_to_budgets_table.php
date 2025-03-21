<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToBudgetsTable extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->year('year')->nullable(); // Kolom untuk tahun anggaran
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
}
