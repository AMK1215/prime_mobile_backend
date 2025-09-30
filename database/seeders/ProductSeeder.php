<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Copy image from public/img to storage/app/public/products
     */
    private function copyProductImage(string $imageName): ?string
    {
        $sourcePath = public_path('img/' . $imageName);
        
        if (!File::exists($sourcePath)) {
            return null;
        }

        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $newImageName = time() . '_' . Str::random(10) . '.' . $extension;
        $destinationPath = storage_path('app/public/products/' . $newImageName);
        
        // Ensure products directory exists
        if (!File::exists(storage_path('app/public/products'))) {
            File::makeDirectory(storage_path('app/public/products'), 0755, true);
        }

        File::copy($sourcePath, $destinationPath);
        
        return 'products/' . $newImageName;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Available phone images from public/img
        $availableImages = [
            'amanz-FTyGryAQxm8-unsplash.jpg',
            'thai-nguyen-4Phhf8eNH7g-unsplash.jpg',
            'amanz-Yp6WyTkGTBk-unsplash.jpg',
            'amanz-o1_Ri2CB1MI-unsplash.jpg',
            'thai-nguyen-fw_KhcwHmlY-unsplash.jpg',
            'amanz-gt9JU68j_0Q-unsplash.jpg',
            'thai-nguyen-M32wJj7Q3UA-unsplash.jpg',
            'nilay-patel-8zCfvjt7CPE-unsplash.jpg',
            'nilay-patel-otLWcl8dDoc-unsplash.jpg',
            'thai-nguyen-4DElej86tUE-unsplash.jpg',
            'amanz-Q5bMi_SdwX4-unsplash.jpg',
            'salman-majeed-8hul526qKeA-unsplash.jpg',
            'salman-majeed-qOCirB965dk-unsplash.jpg',
            'daniel-romero-bR_r3fJu-vk-unsplash.jpg',
            'thai-nguyen-Xx7FM76bA8k-unsplash.jpg',
            'thai-nguyen-waQ9MbaxCZs-unsplash.jpg',
            'daniel-romero-JSQva3za368-unsplash.jpg',
            'amanz-FkEfFVrbM3o-unsplash.jpg',
            'thai-nguyen-UKZhQVri0OI-unsplash.jpg',
            'amanz-hhniivY7iyw-unsplash.jpg',
        ];

        // Get existing data for relationships
        $categories = ProductCategory::all();
        $statuses = ProductStatus::all();

        if ($categories->isEmpty() || $statuses->isEmpty()) {
            $this->command->warn('Required data not found. Please run ProductCategoriesSeeder and ProductStatusesSeeder first.');
            return;
        }

        // Get Android and iOS categories
        $androidCategory = $categories->where('name', 'Android Phones')->first();
        $iosCategory = $categories->where('name', 'iOS Phones')->first();

        if (!$androidCategory || !$iosCategory) {
            $this->command->warn('Android Phones or iOS Phones category not found.');
            return;
        }

        // Get common statuses
        $availableStatus = $statuses->where('name', 'Available')->first() ?? $statuses->first();
        $inStockStatus = $statuses->where('name', 'In Stock')->first() ?? $statuses->first();
        $newArrivalStatus = $statuses->where('name', 'New Arrival')->first() ?? $statuses->first();
        $bestSellerStatus = $statuses->where('name', 'Best Seller')->first() ?? $statuses->first();

        // Sample Android phones
        $androidPhones = [
            // Samsung Galaxy Series
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android flagship with S Pen, 200MP camera, and AI-powered features. Titanium design with 6.8" Dynamic AMOLED display.',
                'price' => 1199.99,
                'quantity' => 25,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Samsung Galaxy S24+',
                'description' => 'Powerful Android smartphone with 6.7" display, 50MP camera system, and all-day battery life. Premium aluminum design.',
                'price' => 999.99,
                'quantity' => 30,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Compact flagship with 6.2" display, advanced camera system, and AI-enhanced photography. Perfect for one-handed use.',
                'price' => 799.99,
                'quantity' => 35,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Samsung Galaxy Z Fold5',
                'description' => 'Revolutionary foldable smartphone with 7.6" main display and 6.2" cover screen. Multi-tasking powerhouse with S Pen support.',
                'price' => 1799.99,
                'quantity' => 15,
                'category_name' => 'Android Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'Samsung Galaxy Z Flip5',
                'description' => 'Compact foldable phone with 6.7" main display and 3.4" cover screen. Unique flex mode for hands-free use.',
                'price' => 999.99,
                'quantity' => 20,
                'category_name' => 'Android Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'Samsung Galaxy A54 5G',
                'description' => 'Mid-range smartphone with 6.4" display, 50MP camera, and 5000mAh battery. Great value for money.',
                'price' => 449.99,
                'quantity' => 50,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Samsung Galaxy A34 5G',
                'description' => 'Affordable 5G smartphone with 6.6" display, 48MP camera, and long-lasting battery. Perfect for everyday use.',
                'price' => 349.99,
                'quantity' => 60,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // Google Pixel Series
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'AI-powered smartphone with 6.7" display, 50MP camera with Magic Eraser, and 7 years of software updates.',
                'price' => 999.99,
                'quantity' => 28,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Google Pixel 8',
                'description' => 'Compact flagship with 6.2" display, advanced AI features, and exceptional camera quality. Pure Android experience.',
                'price' => 699.99,
                'quantity' => 32,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Google Pixel 7a',
                'description' => 'Budget-friendly Pixel with 6.1" display, 64MP camera, and Google AI features. Great camera at affordable price.',
                'price' => 499.99,
                'quantity' => 45,
                'category_name' => 'Android Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'Google Pixel Fold',
                'description' => 'Google\'s first foldable with 7.6" main display and 5.8" cover screen. Tensor G2 chip with AI features.',
                'price' => 1799.99,
                'quantity' => 12,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // OnePlus Series
            [
                'name' => 'OnePlus 12',
                'description' => 'Flagship killer with 6.82" LTPO display, 50MP camera, and 100W fast charging. Premium performance at competitive price.',
                'price' => 799.99,
                'quantity' => 25,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'OnePlus 12R',
                'description' => 'Performance-focused smartphone with 6.78" display, 50MP camera, and 100W SuperVOOC charging.',
                'price' => 599.99,
                'quantity' => 30,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'OnePlus Nord 3',
                'description' => 'Mid-range smartphone with 6.74" display, 50MP camera, and 80W fast charging. Great balance of features and price.',
                'price' => 449.99,
                'quantity' => 40,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // Xiaomi Series
            [
                'name' => 'Xiaomi 14 Ultra',
                'description' => 'Photography powerhouse with 6.73" display, 50MP Leica camera system, and 90W fast charging.',
                'price' => 1299.99,
                'quantity' => 18,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Xiaomi 14 Pro',
                'description' => 'Premium smartphone with 6.73" display, 50MP camera, and 120W HyperCharge. High-end features at competitive price.',
                'price' => 999.99,
                'quantity' => 22,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Xiaomi 14',
                'description' => 'Compact flagship with 6.36" display, 50MP camera, and 90W fast charging. Perfect size and performance.',
                'price' => 799.99,
                'quantity' => 28,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Xiaomi Redmi Note 13 Pro',
                'description' => 'Budget smartphone with 6.67" display, 200MP camera, and 67W fast charging. Excellent value for money.',
                'price' => 299.99,
                'quantity' => 55,
                'category_name' => 'Android Phones',
                'status_name' => 'Best Seller'
            ],

            // OPPO Series
            [
                'name' => 'OPPO Find X7 Ultra',
                'description' => 'Flagship with 6.82" display, dual 50MP cameras, and 100W SuperVOOC charging. Premium design and performance.',
                'price' => 1199.99,
                'quantity' => 20,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'OPPO Find X7',
                'description' => 'High-end smartphone with 6.78" display, 50MP camera, and 100W fast charging. Sleek design with powerful features.',
                'price' => 899.99,
                'quantity' => 25,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'OPPO Reno11 Pro',
                'description' => 'Mid-range smartphone with 6.74" display, 50MP camera, and 67W fast charging. Great camera performance.',
                'price' => 549.99,
                'quantity' => 35,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // Vivo Series
            [
                'name' => 'Vivo X100 Pro',
                'description' => 'Camera-focused flagship with 6.78" display, 50MP ZEISS camera, and 100W fast charging.',
                'price' => 999.99,
                'quantity' => 22,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Vivo X100',
                'description' => 'Premium smartphone with 6.78" display, 50MP camera, and 120W fast charging. Great performance and design.',
                'price' => 799.99,
                'quantity' => 28,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Vivo V30 Pro',
                'description' => 'Mid-range smartphone with 6.78" display, 50MP camera, and 80W fast charging. Excellent value proposition.',
                'price' => 499.99,
                'quantity' => 38,
                'category_name' => 'Android Phones',
                'status_name' => 'Best Seller'
            ],

            // Nothing Series
            [
                'name' => 'Nothing Phone (2a)',
                'description' => 'Unique design with 6.7" display, 50MP camera, and transparent back with LED strips. Distinctive style.',
                'price' => 399.99,
                'quantity' => 30,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Nothing Phone (2)',
                'description' => 'Premium smartphone with 6.7" display, 50MP camera, and Glyph Interface. Unique design meets performance.',
                'price' => 599.99,
                'quantity' => 25,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // Motorola Series
            [
                'name' => 'Motorola Edge 50 Pro',
                'description' => 'Mid-range smartphone with 6.7" display, 50MP camera, and 125W fast charging. Stock Android experience.',
                'price' => 699.99,
                'quantity' => 32,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'Motorola Edge 50',
                'description' => 'Affordable smartphone with 6.7" display, 50MP camera, and 68W fast charging. Great for everyday use.',
                'price' => 449.99,
                'quantity' => 40,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],

            // Realme Series
            [
                'name' => 'Realme GT 6',
                'description' => 'Gaming-focused smartphone with 6.78" display, 50MP camera, and 120W fast charging. High performance.',
                'price' => 649.99,
                'quantity' => 28,
                'category_name' => 'Android Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'Realme 12 Pro+',
                'description' => 'Camera smartphone with 6.7" display, 50MP periscope camera, and 67W fast charging. Great photography.',
                'price' => 449.99,
                'quantity' => 35,
                'category_name' => 'Android Phones',
                'status_name' => 'Available'
            ],
        ];

        // Sample iOS phones
        $iosPhones = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest flagship iPhone with 6.7" display, A17 Pro chip, 48MP camera, and titanium design. Premium performance.',
                'price' => 1199.99,
                'quantity' => 30,
                'category_name' => 'iOS Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Premium iPhone with 6.1" display, A17 Pro chip, 48MP camera, and titanium design. Professional features.',
                'price' => 999.99,
                'quantity' => 35,
                'category_name' => 'iOS Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'iPhone 15 Plus',
                'description' => 'Large iPhone with 6.7" display, A16 chip, 48MP camera, and all-day battery life. Perfect for media consumption.',
                'price' => 899.99,
                'quantity' => 40,
                'category_name' => 'iOS Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'iPhone 15',
                'description' => 'Standard iPhone with 6.1" display, A16 chip, 48MP camera, and Dynamic Island. Great balance of features.',
                'price' => 799.99,
                'quantity' => 45,
                'category_name' => 'iOS Phones',
                'status_name' => 'New Arrival'
            ],
            [
                'name' => 'iPhone 14 Pro Max',
                'description' => 'Previous generation flagship with 6.7" display, A16 chip, 48MP camera, and Dynamic Island. Excellent value.',
                'price' => 999.99,
                'quantity' => 25,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'Previous generation Pro with 6.1" display, A16 chip, 48MP camera, and Dynamic Island. Premium features.',
                'price' => 899.99,
                'quantity' => 30,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 14 Plus',
                'description' => 'Large iPhone with 6.7" display, A15 chip, 12MP camera, and excellent battery life. Great for big screen lovers.',
                'price' => 799.99,
                'quantity' => 35,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 14',
                'description' => 'Standard iPhone with 6.1" display, A15 chip, 12MP camera, and reliable performance. Solid choice.',
                'price' => 699.99,
                'quantity' => 40,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 13 Pro Max',
                'description' => 'Previous flagship with 6.7" display, A15 chip, 12MP camera system, and ProRAW support. Great value.',
                'price' => 899.99,
                'quantity' => 20,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 13 Pro',
                'description' => 'Previous Pro model with 6.1" display, A15 chip, 12MP camera system, and ProMotion display.',
                'price' => 799.99,
                'quantity' => 25,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 13',
                'description' => 'Popular iPhone with 6.1" display, A15 chip, 12MP camera, and excellent battery life. Best seller.',
                'price' => 599.99,
                'quantity' => 50,
                'category_name' => 'iOS Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'iPhone 13 mini',
                'description' => 'Compact iPhone with 5.4" display, A15 chip, 12MP camera, and one-handed use. Perfect size.',
                'price' => 499.99,
                'quantity' => 30,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 12 Pro Max',
                'description' => 'Previous generation with 6.7" display, A14 chip, 12MP camera system, and 5G connectivity.',
                'price' => 799.99,
                'quantity' => 18,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 12 Pro',
                'description' => 'Previous Pro with 6.1" display, A14 chip, 12MP camera system, and premium build quality.',
                'price' => 699.99,
                'quantity' => 22,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 12',
                'description' => 'Popular model with 6.1" display, A14 chip, 12MP camera, and 5G support. Great performance.',
                'price' => 599.99,
                'quantity' => 35,
                'category_name' => 'iOS Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'iPhone 12 mini',
                'description' => 'Small iPhone with 5.4" display, A14 chip, 12MP camera, and compact design. Easy to handle.',
                'price' => 499.99,
                'quantity' => 25,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone SE (3rd Gen)',
                'description' => 'Budget iPhone with 4.7" display, A15 chip, 12MP camera, and Touch ID. Great entry point.',
                'price' => 429.99,
                'quantity' => 40,
                'category_name' => 'iOS Phones',
                'status_name' => 'Best Seller'
            ],
            [
                'name' => 'iPhone 11 Pro Max',
                'description' => 'Previous flagship with 6.5" display, A13 chip, 12MP camera system, and excellent battery life.',
                'price' => 699.99,
                'quantity' => 15,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 11 Pro',
                'description' => 'Previous Pro with 5.8" display, A13 chip, 12MP camera system, and premium materials.',
                'price' => 599.99,
                'quantity' => 20,
                'category_name' => 'iOS Phones',
                'status_name' => 'Available'
            ],
            [
                'name' => 'iPhone 11',
                'description' => 'Popular model with 6.1" display, A13 chip, 12MP camera, and great value. Still excellent.',
                'price' => 499.99,
                'quantity' => 45,
                'category_name' => 'iOS Phones',
                'status_name' => 'Best Seller'
            ],
        ];

        // Combine all phones
        $allPhones = array_merge($androidPhones, $iosPhones);

        // Create products with images
        $imageIndex = 0;
        foreach ($allPhones as $phoneData) {
            // Find category
            $category = $phoneData['category_name'] === 'Android Phones' ? $androidCategory : $iosCategory;

            // Find status
            $status = $statuses->where('name', $phoneData['status_name'])->first() ?? $availableStatus;

            // Assign image (cycle through available images)
            $imagePath = null;
            if (!empty($availableImages)) {
                $imageSource = $availableImages[$imageIndex % count($availableImages)];
                $imagePath = $this->copyProductImage($imageSource);
                $imageIndex++;
            }

            Product::create([
                'product_category_id' => $category->id,
                'name' => $phoneData['name'],
                'description' => $phoneData['description'],
                'price' => $phoneData['price'],
                'quantity' => $phoneData['quantity'],
                'product_status_id' => $status->id,
                'image' => $imagePath,
            ]);

            if ($imagePath) {
                $this->command->info('Created product: ' . $phoneData['name'] . ' with image');
            }
        }

        $this->command->info('Successfully seeded ' . count($allPhones) . ' phone products with images!');
    }
}
