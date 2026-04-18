<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display wallet balance and transaction history
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get transactions with pagination
        $query = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by type if provided
        if ($request->has('filter') && $request->filter !== 'all') {
            $query->where('type', $request->filter);
        }

        $transactions = $query->paginate(15);

        return view('wallet.index', compact('user', 'transactions'));
    }

    /**
     * Show deposit form
     */
    public function showDepositForm()
    {
        return view('wallet.deposit');
    }

    /**
     * Test deposit (Development only - bypasses MoMo/PayPal)
     */
    public function testDeposit(Request $request)
    {
        // Allow in development OR for admin users (for testing on production)
        $user = Auth::user();
        if (!app()->environment('local') && !config('app.debug') && $user->role !== 'admin') {
            abort(403, 'This route is only available in development or for admin users');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        try {
            DB::beginTransaction();

            // Create transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $amount,
                'status' => 'completed',
                'description' => 'Test deposit - Thẻ ngân hàng (Development)',
                'reference_id' => 'TEST_CARD_' . time(),
                'payment_method' => 'test_card',
            ]);

            // Add balance
            $user->addBalance($amount);

            DB::commit();

            return redirect()->route('wallet.index')
                ->with('success', '✅ Test deposit thành công! Số dư mới: ' . number_format($user->balance, 0, ',', '.') . ' VNĐ');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a pending transaction
     */
    public function cancelTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Only allow canceling own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Only allow canceling pending transactions
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy giao dịch đang xử lý');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy giao dịch');
    }
}
