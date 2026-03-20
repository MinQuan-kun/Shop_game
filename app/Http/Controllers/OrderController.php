<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });

        $user = Auth::user();

        return view('orders.checkout', compact('cartItems', 'total', 'user'));
    }

    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)
            ->with('game')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });

        // Check if user already owns any games in cart
        foreach ($cartItems as $cartItem) {
            if ($user->ownsGame($cartItem->game_id)) {
                return back()->with('error', 'Bạn đã sở hữu game "' . $cartItem->game->name . '" rồi! Vui lòng xóa khỏi giỏ hàng.');
            }
        }

        // Check if user has sufficient balance
        if (!$user->hasBalance($total)) {
            return back()->with('error', 'Số dư không đủ! Vui lòng nạp thêm tiền vào ví.')
                ->with('required_amount', $total)
                ->with('current_balance', $user->balance);
        }

        try {
            // Start transaction
            DB::beginTransaction();

            // Deduct balance
            if (!$user->deductBalance($total)) {
                throw new \Exception('Không thể trừ số dư.');
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => 'wallet'
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $cartItem->game_id,
                    'price' => $cartItem->price_at_time,
                    'quantity' => $cartItem->quantity
                ]);
            }

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => $total,
                'status' => 'completed',
                'description' => 'Mua game - Đơn hàng ' . $order->order_number,
                'order_id' => $order->id,
                'reference_id' => $order->id,
                'payment_method' => 'wallet'
            ]);

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display user's order history
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('_id', $id)
            ->with('items.game')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * Check if user owns a game
     */
    public function ownsGame($gameId)
    {
        $owns = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('status', 'completed');
        })->where('game_id', $gameId)->exists();

        return response()->json(['owns' => $owns]);
    }
}
