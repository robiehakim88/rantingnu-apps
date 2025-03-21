<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Nama masjid/musholla
            $table->enum('type', ['masjid', 'musholla'])->nullable(); // Jenis: Masjid atau Musholla
            $table->text('address')->nullable(); // Alamat
            $table->decimal('latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Longitude
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('places');
    }
};
