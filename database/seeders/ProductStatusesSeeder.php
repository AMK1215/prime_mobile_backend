<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class ProductStatusesSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Stock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Out of Stock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Limited Stock', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Discontinued', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'New Arrival', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Best Seller', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'On Sale', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pre-Order', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Coming Soon', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Under Warranty', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Warranty Expired', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Refurbished', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Second Hand', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Damaged', 'created_at' => now(), 'updated_at' => now()],
        ];

        ProductStatus::insert($statuses);
    }
}
