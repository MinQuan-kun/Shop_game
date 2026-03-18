<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->latest()->paginate(12);
        return view('welcome', compact('games'));
    }

    public function show($id)
    {
        // 1. Tìm game theo ID, nếu không thấy thì báo lỗi 404
        $game = Game::where('is_active', true)->findOrFail($id);

        // 2. Lấy danh sách game liên quan 
        $relatedGames = Game::where('is_active', true)
                            ->where('id', '!=', $id)
                            ->latest()
                            ->take(4)
                            ->get();

        return view('games.show', compact('game', 'relatedGames'));
    }
}