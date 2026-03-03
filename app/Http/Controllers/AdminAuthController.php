<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /** Hiển thị form đăng nhập admin */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /** Xử lý đăng nhập admin*/
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = Account::where('UserName', $request->username)->first();

        if (!$user || md5($request->password) !== $user->UserPassword) {
            return back()->withErrors(['username' => 'Tài khoản hoặc mật khẩu không đúng']);
        }

        if ($user->UserRole !== 'admin') {
            return back()->withErrors(['username' => 'Bạn không có quyền đăng nhập vào trang admin']);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    /** Đăng xuất */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /** Hiển thị form đăng ký user (nếu cần) */
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    /** Xử lý đăng ký tài khoản user mới */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:accounts,UserName',
            'password' => 'required|min:6|confirmed',
        ]);

        // Tạo tài khoản user bình thường (UserRole mặc định = 'user')
        Account::create([
            'UserName' => $request->username,
            'UserPassword' => md5($request->password),
            'UserRole' => 'user',
        ]);



        return redirect()->route('admin.login')->with('success', 'Đăng ký thành công, hãy đăng nhập!');
    }
}
