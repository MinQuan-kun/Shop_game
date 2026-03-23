<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'được mở khóa' : 'đã bị khóa';
        
        return redirect()->route('admin.users.index')->with('success', "Tài khoản {$user->name} đã $status thành công!");
    }
    
    public function destroy($id)
{
    $user = User::findOrFail($id);

    // CHẶN XÓA CHÍNH MÌNH
    if ($user->id == Auth::id()) {
        return redirect()->back()->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
    }

    if ($user->role === 'admin') {
        return redirect()->back()->with('error', 'Không thể xóa tài khoản có quyền Quản trị (Admin)!');
    }

    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công.');
}
}