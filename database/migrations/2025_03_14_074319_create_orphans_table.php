<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrphansTable extends Migration
{
    public function up()
    {
        Schema::create('orphans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nama anak yatim/piatu
            $table->enum('gender', ['male', 'female'])->nullable(); // Jenis kelamin
            $table->date('birthdate')->nullable(); // Tanggal lahir
            $table->text('address')->nullable(); // Alamat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orphans');
    }
}
