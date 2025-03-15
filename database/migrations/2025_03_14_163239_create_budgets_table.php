<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('timeframe'); // Mingguan, Bulanan, Tahunan, Insidental
            $table->string('activity_name'); // Nama kegiatan
            $table->text('description')->nullable(); // Deskripsi kegiatan
            $table->decimal('planned_budget', 15, 2); // Anggaran direncanakan
            $table->decimal('actual_budget', 15, 2)->nullable(); // Anggaran terserap
            $table->date('start_date')->nullable(); // Tanggal mulai
            $table->date('end_date')->nullable(); // Tanggal selesai
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}