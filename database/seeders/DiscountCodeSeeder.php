<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscountCode;
use Carbon\Carbon;

class DiscountCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing discount codes
        DiscountCode::truncate();

        // Create test discount codes with 1 year validity
        $expiryDate = Carbon::now()->addYear();

        DiscountCode::create([
            'code' => 'GAME5',
            'type' => 'percentage',
            'value' => 5,
            'expires_at' => $expiryDate,
            'usage_limit' => null, // unlimited
            'used_count' => 0,
            'is_active' => true,
        ]);

        DiscountCode::create([
            'code' => 'GAME10',
            'type' => 'percentage',
            'value' => 10,
            'expires_at' => $expiryDate,
            'usage_limit' => null, // unlimited
            'used_count' => 0,
            'is_active' => true,
        ]);

        DiscountCode::create([
            'code' => 'WELCOME50',
            'type' => 'fixed',
            'value' => 50000, // 50,000 VND
            'expires_at' => $expiryDate,
            'usage_limit' => 100, // limited to 100 uses
            'used_count' => 0,
            'is_active' => true,
        ]);

        $this->command->info('Discount codes created successfully!');
        $this->command->info('Available codes: GAME5 (5%), GAME10 (10%), WELCOME50 (50,000 VND)');
    }
}
