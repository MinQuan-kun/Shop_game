<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $action = Category::where('slug', 'action')->first();
        if (!$action) {
            $action = Category::create(['name' => 'Action', 'slug' => 'action', 'description' => 'Game hành động']);
        }

        $rpg = Category::where('slug', 'rpg')->first();
        if (!$rpg) {
            $rpg = Category::create(['name' => 'RPG', 'slug' => 'rpg', 'description' => 'Game nhập vai']);
        }

        $adventure = Category::where('slug', 'adventure')->first();
        if (!$adventure) {
            $adventure = Category::create(['name' => 'Adventure', 'slug' => 'adventure', 'description' => 'Game phiêu lưu']);
        }

        $strategy = Category::where('slug', 'strategy')->first();
        if (!$strategy) {
            $strategy = Category::create(['name' => 'Strategy', 'slug' => 'strategy', 'description' => 'Game chiến thuật']);
        }

        // Sample games data
        $gamesData = [
            [
                'name' => 'Elden Ring',
                'slug' => 'elden-ring',
                'category_ids' => [$action->_id],
                'description' => 'Elden Ring là một game action RPG được phát triển bởi FromSoftware. Trò chơi kết hợp các yếu tố chơi game khám phá thế giới mở với chiến đấu từ lên cao với các boss khó.',
                'price' => 599000,
                'image' => 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/570940/ELDEN_RING/',
                'publisher' => 'FromSoftware',
                'platforms' => ['PC', 'PS5', 'Xbox'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 1200,
                'is_active' => true,
            ],
            [
                'name' => 'The Witcher 3: Wild Hunt',
                'slug' => 'witcher-3',
                'category_ids' => [$rpg->_id, $adventure->_id],
                'description' => 'The Witcher 3: Wild Hunt là một game nhập vai hành động phiêu lưu được phát triển bởi CD Projekt Red. Bạn sẽ đóng vai Geralt of Rivia, một thợ săn quái vật chuyên nghiệp.',
                'price' => 399000,
                'image' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/292030/The_Witcher_3_Wild_Hunt/',
                'publisher' => 'CD Projekt Red',
                'platforms' => ['PC', 'PS5', 'Xbox'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 2100,
                'is_active' => true,
            ],
            [
                'name' => 'Cyberpunk 2077',
                'slug' => 'cyberpunk-2077',
                'category_ids' => [$rpg->_id, $action->_id],
                'description' => 'Cyberpunk 2077 là một game RPG hành động lấy bối cảnh thành phố tương lai Night City. Bạn sẽ nhập vai V, một mercenary đang tìm cách sống sót trong thế giới công nghệ cao.',
                'price' => 799000,
                'image' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/1091500/Cyberpunk_2077/',
                'publisher' => 'CD Projekt Red',
                'platforms' => ['PC', 'PS5', 'Xbox'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 1850,
                'is_active' => true,
            ],
            [
                'name' => 'Starcraft II',
                'slug' => 'starcraft-2',
                'category_ids' => [$strategy->_id],
                'description' => 'StarCraft II là một game chiến thuật thời gian thực (RTS) được phát triển bởi Blizzard Entertainment. Đây là phần tiếp theo của bộ game StarCraft huyền thoại.',
                'price' => 0,
                'image' => 'https://images.unsplash.com/photo-1552335731-e41991471f50?w=500&h=650&fit=crop',
                'download_link' => 'https://starcraft2.com/en-us/',
                'publisher' => 'Blizzard Entertainment',
                'platforms' => ['PC', 'Mac'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 5000,
                'is_active' => true,
            ],
            [
                'name' => 'Dark Souls III',
                'slug' => 'dark-souls-3',
                'category_ids' => [$action->_id, $rpg->_id],
                'description' => 'Dark Souls III là game action RPG khó khăn được phát triển bởi FromSoftware. Trò chơi nổi tiếng với độ khó cao và hệ thống chiến đấu phức tạp.',
                'price' => 449000,
                'image' => 'https://images.unsplash.com/photo-1535482656322-13bab5e7ebb3?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/374320/DARK_SOULS_III/',
                'publisher' => 'FromSoftware',
                'platforms' => ['PC', 'PS5', 'Xbox'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 2300,
                'is_active' => true,
            ],
            [
                'name' => 'Hollow Knight',
                'slug' => 'hollow-knight',
                'category_ids' => [$adventure->_id, $action->_id],
                'description' => 'Hollow Knight là một game phiêu lưu 2D Metroidvania được phát triển bởi Team Cherry. Bạn sẽ khám phá một thế giới ngầm đầy bí ẩn và gặp những boss khó chịu.',
                'price' => 129000,
                'image' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/367520/Hollow_Knight/',
                'publisher' => 'Team Cherry',
                'platforms' => ['PC', 'Nintendo Switch', 'PS5'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 3100,
                'is_active' => true,
            ],
            [
                'name' => 'Monster Hunter: World',
                'slug' => 'monster-hunter-world',
                'category_ids' => [$action->_id, $adventure->_id],
                'description' => 'Monster Hunter: World là game hành động phiêu lưu được phát triển bởi Capcom. Bạn sẽ trở thành một thợ săn quái vật chuyên nghiệp.',
                'price' => 349000,
                'image' => 'https://images.unsplash.com/photo-1578303512936-24a735eafadb?w=500&h=650&fit=crop',
                'download_link' => 'https://store.steampowered.com/app/582160/MONSTER_HUNTER_WORLD/',
                'publisher' => 'Capcom',
                'platforms' => ['PC', 'PS5', 'Xbox'],
                'languages' => ['English', 'Vietnamese'],
                'sold_count' => 2800,
                'is_active' => true,
            ],
        ];

        // Create games
        foreach ($gamesData as $data) {
            try {
                Game::create($data);
                echo "✓ Created: {$data['name']}\n";
            } catch (\Exception $e) {
                echo "⚠ Skipped: {$data['name']} (already exists)\n";
            }
        }
    }
}
