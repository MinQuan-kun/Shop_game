<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'được mở khóa' : 'đã bị khóa';
        
        return redirect()->back()->with('status', "Tài khoản {$user->name} đã $status thành công!");
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('status', 'Đã xóa tài khoản thành công!');
    }
}