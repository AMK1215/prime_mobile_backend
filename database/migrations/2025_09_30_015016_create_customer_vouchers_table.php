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
        Schema::create('customer_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('voucher_code')->unique();
            $table->string('voucher_type')->default('purchase'); // purchase, discount, warranty_extension
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->json('metadata')->nullable(); // Additional voucher data
            $table->timestamps();
            $table->softDeletes(); // Add soft delete support
            
            $table->index(['voucher_code', 'is_used']);
            $table->index(['valid_from', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_vouchers');
    }
};