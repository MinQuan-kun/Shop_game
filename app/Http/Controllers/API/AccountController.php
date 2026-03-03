<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Lấy tất cả account
    public function index() {
        return response()->json(Account::all());
    }

    // Lấy 1 account theo ID
    public function show($id) {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($account);
    }

    // Tạo account mới
    public function store(Request $request) {
        $validated = $request->validate([
            'UserName' => 'required|string|max:255',
            'UserEmail' => 'required|email|unique:Accounts,UserEmail',
            'UserPassword' => 'required|string|min:6',
            'UserRole' => 'nullable|string|max:50',
        ]);

        $validated['UserPassword'] = bcrypt($validated['UserPassword']);

        $account = Account::create($validated);
        return response()->json($account, 201);
    }

    // Cập nhật account
    public function update(Request $request, $id) {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $data = $request->only(['UserName', 'UserEmail', 'UserPassword', 'UserRole', 'UserAvatar']);
        if (isset($data['UserPassword'])) {
            $data['UserPassword'] = bcrypt($data['UserPassword']);
        }

        $account->update($data);
        return response()->json($account);
    }

    // Xóa account
    public function destroy($id) {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $account->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
