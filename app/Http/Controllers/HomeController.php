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
        $query = Game::where('is_active', true);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_ids', $request->category);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', (int)$request->min_price);
        }
        // ------------------------------------------------------------

        $games = $query->latest()->paginate(12);
        $categories = Category::all();
        $publishers = Game::where('is_active', true)->distinct('publisher')->pluck('publisher')->sort()->values();

        $recommendedGames = $this->recommendationService->getForHome(Auth::user(), 4);

        return view('welcome', compact('games', 'categories', 'publishers', 'recommendedGames'));
    }

    public function show($id)
    {
        $game = Game::where('is_active', true)->findOrFail($id);
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
    public function shop(Request $request)
    {
        // 1. Khởi tạo query
        $query = Game::where('is_active', true);

        // 2. Xử lý Tìm kiếm (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Xử lý Lọc theo Thể loại (Category)
        if ($request->has('category') && $request->category != '') {
            $query->where('category_ids', $request->category);
        }

        // 4. Xử lý Lọc theo Giá
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', (int)$request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', (int)$request->max_price);
        }

        // 5. Xử lý Lọc theo Nhà phát hành (Publisher)
        if ($request->has('publisher') && $request->publisher != '') {
            $query->where('publisher', $request->publisher);
        }

        // 6. Xử lý Lọc theo Nền tảng (Platform)
        if ($request->has('platform') && $request->platform != '') {
            $query->where('platforms', $request->platform);
        }

        // 7. Xử lý sắp xếp (Sort)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 8. Lấy dữ liệu games
        $games = $query->paginate(12)->withQueryString();
        
        // Lấy chỉ những category có game
        $categoriesWithGames = Game::where('is_active', true)
            ->pluck('category_ids')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();
        $categories = Category::whereIn('_id', $categoriesWithGames)->get()->unique('_id');
        
        // 9. Lấy danh sách publishers từ TẤT CẢ games
        $allPublishers = Game::where('is_active', true)
            ->whereNotNull('publisher')
            ->where('publisher', '!=', '')
            ->pluck('publisher')
            ->unique()
            ->sort()
            ->values();
        
        // 10. Lấy danh sách platforms từ TẤT CẢ games
        $allPlatforms = Game::where('is_active', true)
            ->whereNotNull('platforms')
            ->get()
            ->flatMap(function ($game) {
                return $game->platforms ?? [];
            })
            ->unique()
            ->sort()
            ->values();
        
        // 11. Lấy count cho mỗi category (cho filter)
        $categoryCounts = Category::all()->mapWithKeys(function ($cat) {
            $count = Game::where('is_active', true)->where('category_ids', $cat->id)->count();
            return [$cat->id => $count];
        });

        // 12. Lấy count cho mỗi publisher
        $publisherCounts = $allPublishers->mapWithKeys(function ($pub) {
            $count = Game::where('is_active', true)->where('publisher', $pub)->count();
            return [$pub => $count];
        });

        // 13. Lấy count cho mỗi platform
        $platformCounts = $allPlatforms->mapWithKeys(function ($platform) {
            $count = Game::where('is_active', true)->where('platforms', $platform)->count();
            return [$platform => $count];
        });

        return view('shop.index', compact('games', 'categories', 'allPublishers', 'allPlatforms', 'categoryCounts', 'publisherCounts', 'platformCounts'));
    }
}
