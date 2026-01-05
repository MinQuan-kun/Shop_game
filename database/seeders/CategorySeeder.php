<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hành động',
                'slug' => 'hanh-dong',
                'description' => 'Game hành động, phiêu lưu, chiến đấu'
            ],
            [
                'name' => 'Nhập vai',
                'slug' => 'nhap-vai',
                'description' => 'Game nhập vai, RPG'
            ],
            [
                'name' => 'Chiến thuật',
                'slug' => 'chien-thuat',
                'description' => 'Game chiến thuật, strategy'
            ],
            [
                'name' => 'Thể thao',
                'slug' => 'the-thao',
                'description' => 'Game thể thao, racing'
            ],
            [
                'name' => 'Mô phỏng',
                'slug' => 'mo-phong',
                'description' => 'Game mô phỏng, simulation'
            ],
            [
                'name' => 'Kinh dị',
                'slug' => 'kinh-di',
                'description' => 'Game kinh dị, horror'
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Đã seed 6 categories chuẩn!');
    }
}
