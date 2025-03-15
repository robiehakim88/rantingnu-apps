<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'Ketua', 'description' => 'Pemimpin organisasi']);
        Role::create(['name' => 'Sekretaris', 'description' => 'Penanggung jawab administrasi']);
        Role::create(['name' => 'Bendahara', 'description' => 'Penanggung jawab keuangan']);
    }
}
