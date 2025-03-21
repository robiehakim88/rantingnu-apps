<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberRolesTable extends Migration
{
    public function up()
    {
        Schema::create('member_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->year('start_year');
            $table->year('end_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_roles');
    }
}