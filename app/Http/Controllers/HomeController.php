<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\RecommendationService;

class HomeController extends Controller
{
    protected $recommendationService;

    // Inject Service vào Constructor
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index(Request $request)
    {
        // 1. Logic lọc game theo giá
        $query = Game::where('is_active', true);
        if ($request->has('category')) {
        }
        if ($request->has('min_price')) {
        }

        $games = $query->latest()->paginate(12);
        $categories = Category::all();
        $publishers = Game::where('is_active', true)->distinct('publisher')->pluck('publisher')->sort()->values();

        // 2. Lấy danh sách "Có thể bạn thích" cho Trang Chủ
        $recommendedGames = $this->recommendationService->getForHome(Auth::user(), 4); // Lấy 4 game

        return view('welcome', compact('games', 'categories', 'publishers', 'recommendedGames'));
    }

    public function show($id)
    {
        $game = Game::where('is_active', true)->findOrFail($id);

        // Logic đề xuất thông minh thay vì chỉ lấy mới nhất
        $relatedGames = $this->recommendationService->getRelatedGames($game, 4);

        return view('games.show', compact('game', 'relatedGames'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        // Search for games matching the query
        $games = Game::where('is_active', true)
            ->where('name', 'regex', "/{$query}/i")
            ->select('_id', 'name', 'image', 'price')
            ->limit(8)
            ->get();

        // Format response
        $suggestions = $games->map(function ($game) {
            return [
                'id' => $game->_id,
                'name' => $game->name,
                'image' => Str::startsWith($game->image, 'http') ? $game->image : asset('storage/' . $game->image),
                'price' => $game->price,
                'price_formatted' => $game->price == 0 ? 'Miễn phí' : number_format($game->price, 0, ',', '.') . ' đ',
            ];
        });

        return response()->json($suggestions);
    }
}
