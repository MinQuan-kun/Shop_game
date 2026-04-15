<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('game')
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a game to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,_id'
        ]);

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('game_id', $request->game_id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Game đã có trong danh sách yêu thích!');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    /**
     * Remove a game from wishlist
     */
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
        }

        return back()->with('error', 'Không tìm thấy!');
    }

    /**
     * Toggle wishlist status (AJAX)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,_id'
        ]);

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('game_id', $request->game_id)
            ->first();

        $action = '';
        $message = '';

        if ($wishlistItem) {
            // Đã có -> Xóa
            $wishlistItem->delete();
            $action = 'removed'; // Đánh dấu là đã xóa
            $message = 'Đã xóa khỏi danh sách yêu thích!';
        } else {
            // Chưa có -> Thêm
            Wishlist::create([
                'user_id' => Auth::id(),
                'game_id' => $request->game_id
            ]);
            $action = 'added'; // Đánh dấu là đã thêm
            $message = 'Đã thêm vào danh sách yêu thích!';
        }

        // Nếu request là AJAX (muốn JSON)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'action' => $action,
                'message' => $message
            ]);
        }

        // Fallback cho request thường
        return back()->with('success', $message);
    }

    /**
     * Check if game is in wishlist (AJAX)
     */
    public function check($gameId)
    {
        $inWishlist = Wishlist::where('user_id', Auth::id())
            ->where('game_id', $gameId)
            ->exists();

        return response()->json(['in_wishlist' => $inWishlist]);
    }
}
