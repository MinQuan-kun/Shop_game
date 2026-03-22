<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::where('is_active', true);

        // Filter by category if provided
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->whereIn('category_ids', [$category->_id]);
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price !== '') {
            $query->where('price', '>=', (int)$request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== '') {
            $query->where('price', '<=', (int)$request->max_price);
        }

        // Filter by platform
        if ($request->has('platform') && !empty($request->platform)) {
            $platforms = is_array($request->platform) ? $request->platform : [$request->platform];
            $query->where(function ($q) use ($platforms) {
                foreach ($platforms as $platform) {
                    $q->orWhere('platforms', 'regex', "/{$platform}/i");
                }
            });
        }

        // Filter by publisher
        if ($request->has('publisher') && !empty($request->publisher)) {
            $query->where('publisher', 'regex', "/" . $request->publisher . "/i");
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            // MongoDB regex search with proper delimiter (case-insensitive)
            $query->where(function ($q) use ($search) {
                $q->where('name', 'regex', "/{$search}/i")
                    ->orWhere('description', 'regex', "/{$search}/i");
            });
        }

        $games = $query->latest()->paginate(12);
        $categories = Category::all();
        
        // Get unique publishers for filter dropdown
        $publishers = Game::where('is_active', true)
            ->distinct('publisher')
            ->pluck('publisher')
            ->sort()
            ->values();

        return view('welcome', compact('games', 'categories', 'publishers'));
    }

    public function show($id)
    {
        // Find game by ID
        $game = Game::where('is_active', true)->findOrFail($id);

        // Get related games
        $relatedGames = Game::where('is_active', true)
            ->where('_id', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

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