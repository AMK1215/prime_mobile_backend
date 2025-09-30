<?php

namespace Database\Seeders;

use App\Models\Admin\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['title' => 'Owner',         'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Customer',      'created_at' => now(), 'updated_at' => now()],
            ['title' => 'SystemWallet',  'created_at' => now(), 'updated_at' => now()],
        ];

        Role::insert($roles);
    }
}
