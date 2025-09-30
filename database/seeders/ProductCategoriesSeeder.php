<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Phones',
                'parent_id' => 1, // Electronics
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Android Phones',
                'parent_id' => 2, // Mobile Phones
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'iOS Phones',
                'parent_id' => 2, // Mobile Phones
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phone Accessories',
                'parent_id' => 1, // Electronics
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phone Cases',
                'parent_id' => 5, // Phone Accessories
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chargers & Cables',
                'parent_id' => 5, // Phone Accessories
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Screen Protectors',
                'parent_id' => 5, // Phone Accessories
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ProductCategory::insert($categories);
    }
}
