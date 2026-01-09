<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->whereHas('game')
            ->with('game')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a game to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,_id' // Lưu ý: MongoDB dùng _id
        ]);

        $gameId = $request->game_id;
        $game = Game::findOrFail($gameId);

        // Kiểm tra sở hữu game
        if (Auth::user()->ownsGame($gameId)) {
            // [SỬA] Trả về JSON nếu là AJAX
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã sở hữu game này rồi!'], 409);
            }
            return back()->with('error', 'Bạn đã sở hữu game này rồi!');
        }

        // Kiểm tra đã có trong giỏ hàng
        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('game_id', $gameId)
            ->first();

        if ($existingCartItem) {
            // [SỬA] Trả về JSON nếu là AJAX
            if ($request->wantsJson()) {
                return response()->json(['status' => 'info', 'message' => 'Game này đã có trong giỏ hàng']);
            }
            return back()->with('info', 'Game này đã có trong giỏ hàng');
        }

        // Thêm vào giỏ
        Cart::create([
            'user_id' => Auth::id(),
            'game_id' => $gameId,
            'price_at_time' => $game->price,
            'quantity' => 1,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Đã thêm vào giỏ hàng thành công!']);
        }

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('_id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Đã xóa khỏi giỏ hàng!');
        }

        return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Get cart count for header
     */
    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
