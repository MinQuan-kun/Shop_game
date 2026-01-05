<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

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

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $games = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('welcome', compact('games', 'categories'));
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
}