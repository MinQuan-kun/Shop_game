<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('category')->latest()->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.games.create', compact('categories'));
    }

    // --- HÀM STORE  ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,_id',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:2048',
            'download_link' => 'nullable',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('category_ids');
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_active'] = $request->has('is_active');
        $data['category_ids'] = $request->category_ids;

        if ($request->hasFile('image')) {
            Configuration::instance(env('CLOUDINARY_URL'));
            $upload = new UploadApi();
            $result = $upload->upload($request->file('image')->getRealPath(), [
                'folder' => 'Shop_Game/games',
                'public_id' => 'game_' . $data['slug'],
                'overwrite' => true,
            ]);
            $data['image'] = $result['secure_url'];
        }

        Game::create($data);
        return redirect()->route('admin.games.index')->with('success', 'Thêm game thành công!');
    }

    public function edit(Game $game)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.games.edit', compact('game', 'categories'));
    }

    // --- HÀM UPDATE (CẬP NHẬT) ---
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,_id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'download_link' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // XỬ LÝ UPLOAD ẢNH KHI SỬA
        if ($request->hasFile('image')) {
            Configuration::instance(env('CLOUDINARY_URL'));
            $upload = new UploadApi();


            $result = $upload->upload($request->file('image')->getRealPath(), [
                'folder' => 'Shop_Game/games', // Thư mục con
                'public_id' => 'game_' . $data['slug'] . '_' . time(),
                'overwrite' => true,
            ]);

            $data['image'] = $result['secure_url'];
        }

        $game->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Cập nhật game thành công!');
    }

    public function destroy(Game $game)
    {

        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Đã xóa game thành công!');
    }
}
