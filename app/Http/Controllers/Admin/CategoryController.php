<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 1. Danh sách
    public function index()
    {
        // Sử dụng 'with' để eager load games, tránh lỗi N+1 query
        // Lưu ý: với MongoDB đôi khi count() quan hệ phức tạp, ta đếm ở view
        $categories = Category::with('games')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Form thêm mới
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Lưu dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', 
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        // Tạo slug từ tên
        $data['slug'] = Str::slug($request->name);
        // Checkbox trả về "on" hoặc null, cần xử lý thành boolean
        $data['is_active'] = $request->has('is_active');

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    // 4. Form sửa
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Cập nhật
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // 6. Xóa
    public function destroy(Category $category)
    {
        // Kiểm tra xem có game nào thuộc danh mục này không trước khi xóa
        if ($category->games->count() > 0) {
             return redirect()->back()->with('error', 'Không thể xóa! Danh mục này đang chứa game.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục!');
    }
}