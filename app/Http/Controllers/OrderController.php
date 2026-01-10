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
            ->whereHas('game')
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

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price_at_time * $item->quantity;
        });

        // Initialize discount variables
        $discountAmount = 0;
        $discountCode = null;
        $finalTotal = $subtotal;

        // Process discount code if provided
        if ($request->filled('discount_code')) {
            $discountCode = \App\Models\DiscountCode::where('code', strtoupper($request->discount_code))->first();

            if ($discountCode && $discountCode->isValid()) {
                $discountAmount = $discountCode->calculateDiscount($subtotal);
                $finalTotal = $subtotal - $discountAmount;
            } else {
                // Invalid discount code - show error but allow checkout without discount
                return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn. Vui lòng thử lại hoặc thanh toán không có mã giảm giá.');
            }
        }

        // Check if user already owns any games in cart
        foreach ($cartItems as $cartItem) {
            if ($user->ownsGame($cartItem->game_id)) {
                return back()->with('error', 'Bạn đã sở hữu game "' . $cartItem->game->name . '" rồi! Vui lòng xóa khỏi giỏ hàng.');
            }
        }

        // Check if user has sufficient balance (use final total after discount)
        if (!$user->hasBalance($finalTotal)) {
            return back()->with('error', 'Số dư không đủ! Vui lòng nạp thêm tiền vào ví.')
                ->with('required_amount', $finalTotal)
                ->with('current_balance', $user->balance);
        }

        try {
            // Start transaction
            DB::beginTransaction();

            // Deduct balance (use final total after discount)
            if (!$user->deductBalance($finalTotal)) {
                throw new \Exception('Không thể trừ số dư.');
            }

            // Create order with discount information
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $finalTotal, // Store final amount after discount
                'status' => 'completed',
                'payment_method' => 'wallet',
                'discount_code_id' => $discountCode?->_id,
                'discount_amount' => $discountAmount,
                'subtotal' => $subtotal
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
            $description = 'Mua game - Đơn hàng ' . $order->order_number;
            if ($discountAmount > 0) {
                $description .= ' (Đã giảm ' . number_format($discountAmount, 0, ',', '.') . ' VNĐ)';
            }

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => $finalTotal,
                'status' => 'completed',
                'description' => $description,
                'order_id' => $order->id,
                'reference_id' => $order->id,
                'payment_method' => 'wallet'
            ]);

            // Increment discount code usage count if applied
            if ($discountCode) {
                $discountCode->increment('used_count');
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            $successMessage = 'Đặt hàng thành công!';
            if ($discountAmount > 0) {
                $successMessage .= ' Bạn đã tiết kiệm được ' . number_format($discountAmount, 0, ',', '.') . ' VNĐ!';
            }

            return redirect()->route('orders.show', $order->id)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Validate discount code (AJAX)
     */
    public function validateDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric|min:0'
        ]);

        $discountCode = \App\Models\DiscountCode::where('code', strtoupper($request->code))->first();

        if (!$discountCode) {
            return response()->json([
                'valid' => false,
                'message' => 'Mã giảm giá không tồn tại!'
            ]);
        }

        if (!$discountCode->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Mã giảm giá đã hết hạn hoặc hết lượt sử dụng!'
            ]);
        }

        $discountAmount = $discountCode->calculateDiscount($request->total);
        $finalTotal = $request->total - $discountAmount;

        return response()->json([
            'valid' => true,
            'message' => 'Mã giảm giá hợp lệ!',
            'discount_amount' => $discountAmount,
            'final_total' => $finalTotal,
            'discount_type' => $discountCode->type,
            'discount_value' => $discountCode->value
        ]);
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
