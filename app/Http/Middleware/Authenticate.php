<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username'    => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if ($user->UserRole === 'admin') {
                    // Dùng route 'dashboard' hiện có
                    return redirect()->route('admin.dashboard');
                } else {
                    // Chưa có store thì tạo route tạm
                    return redirect()->route('store');
                }
            }
        }

        return back()->withErrors([
            'email' => 'Sai email hoặc mật khẩu.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}


?>