<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)
                     ->latest()
                     ->paginate(12);

        return view('welcome', compact('games'));
    }
}