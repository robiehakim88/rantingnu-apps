<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImamsTable extends Migration
{
    public function up()
    {
        Schema::create('imams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade');
            $table->string('name'); // Nama Imam Taraweh
            $table->integer('year_hijriyah'); // Tahun Hijriyah
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imams');
    }
}
