<?php

namespace Database\Seeders;

use App\Models\Admin\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            [
                'title' => 'owner_access',
                'group' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'title' => 'customer_index',
                'group' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'customer_create',
                'group' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'customer_edit',
                'group' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'customer_delete',
                'group' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'title' => 'owner_index',
                'group' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'owner_create',
                'group' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'owner_edit',
                'group' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'owner_delete',
                'group' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'system_wallet',
                'group' => 'systemwallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'system_wallet_access',
                'group' => 'systemwallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'title' => 'customer_access',
                'group' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            

        ];

        Permission::insert($permissions);
    }
}
