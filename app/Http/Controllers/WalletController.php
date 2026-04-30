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
     * Test deposit (Quick deposit with test card - Available for all users)
     */
    public function testDeposit(Request $request)
    {
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
                'description' => 'Nạp tiền - Thẻ ngân hàng',
                'reference_id' => 'CARD_' . time() . '_' . $user->id,
                'payment_method' => 'test_card',
            ]);

            // Add balance
            $user->addBalance($amount);

            DB::commit();

            return redirect()->route('wallet.index')
                ->with('success', '✅ Nạp tiền thành công! Số dư mới: ' . number_format($user->balance, 0, ',', '.') . ' VNĐ');

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
