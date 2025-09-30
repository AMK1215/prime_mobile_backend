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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone_model');
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('product_category_id')->constrained('product_categories')->restrictOnDelete();
            $table->string('branch');
            $table->date('warranty_start_date');
            $table->date('warranty_end_date');
            $table->string('imei')->unique();
            $table->text('phone_information')->nullable();
            $table->string('phone_photo')->nullable();
            $table->decimal('sale_price', 10, 2);
            $table->date('sale_date');
            $table->string('sale_status')->default('sold');
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
