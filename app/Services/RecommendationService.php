<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    /**
     * LOGIC 1: Đề xuất cho TRANG CHỦ (Dựa trên lịch sử mua của User)
     */
    public function getForHome(?User $user, $limit = 8)
    {
        // 1. Nếu khách chưa đăng nhập -> Đề xuất game bán chạy nhất (Trending)
        if (!$user) {
            return $this->getTrendingGames($limit);
        }

        // 2. Lấy danh sách game User đã mua
        // Giả sử quan hệ: User -> Orders -> Items -> Game
        $purchasedGameIds = [];
        $orders = Order::where('user_id', $user->id)->where('status', 'completed')->with('items')->get(); //

        foreach ($orders as $order) {
            foreach ($order->items as $item) { // (Cần đảm bảo relationship items trong Order model)
                $purchasedGameIds[] = $item->game_id;
            }
        }
        $purchasedGameIds = array_unique($purchasedGameIds);

        // 3. Nếu User chưa mua gì -> Vẫn đề xuất game bán chạy
        if (empty($purchasedGameIds)) {
            return $this->getTrendingGames($limit);
        }

        // 4. "AI" Logic: Phân tích sở thích (Lấy Category của game đã mua)
        $favoriteCategories = Game::whereIn('_id', $purchasedGameIds) //
            ->pluck('category_ids') // Lấy mảng category_ids
            ->flatten()
            ->unique()
            ->toArray();

        // 5. Tìm game chưa mua nhưng CÙNG THỂ LOẠI
        $recommendations = Game::where('is_active', true)
            ->whereNotIn('_id', $purchasedGameIds)
            ->whereIn('category_ids', $favoriteCategories)
            ->take($limit)
            ->get();

        // 6. Nếu không đủ số lượng (ví dụ user thích thể loại hiếm), bù thêm bằng game Hot
        if ($recommendations->count() < $limit) {
            $needed = $limit - $recommendations->count();
            $trending = Game::where('is_active', true)
                ->whereNotIn('_id', $purchasedGameIds)
                ->whereNotIn('_id', $recommendations->pluck('_id'))
                ->orderBy('sold_count', 'desc')
                ->take($needed)
                ->get();

            $recommendations = $recommendations->merge($trending);
        }

        return $recommendations;
    }

    /**
     * LOGIC 2: Đề xuất cho Game đang xem
     */
    public function getRelatedGames(Game $currentGame, $limit = 4)
    {
        return Game::where('is_active', true)
            ->where('_id', '!=', $currentGame->id)
            ->whereIn('category_ids', $currentGame->category_ids ?? [])
            ->take($limit)
            ->get();
    }

    private function getTrendingGames($limit)
    {
        return Game::where('is_active', true)
            ->orderBy('sold_count', 'desc') //
            ->take($limit)
            ->get();
    }
}
