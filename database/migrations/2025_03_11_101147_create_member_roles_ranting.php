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
        Schema::create('member_roles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('member_id')->constrained('users');
    $table->foreignId('role_id')->constrained('roles');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_roles_ranting');
    }
};
