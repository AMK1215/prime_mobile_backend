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
        Schema::table('products', function (Blueprint $table) {
            $table->string('ram')->nullable()->after('description');
            $table->string('storage')->nullable()->after('ram');
            $table->string('screen_size')->nullable()->after('storage');
            $table->string('color')->nullable()->after('screen_size');
            $table->string('battery_capacity')->nullable()->after('color');
            $table->string('battery_watt')->nullable()->after('battery_capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'ram',
                'storage', 
                'screen_size',
                'color',
                'battery_capacity',
                'battery_watt'
            ]);
        });
    }
};
