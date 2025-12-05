<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
// use App\Models\Game; // Bỏ comment dòng này khi bạn đã có Model Game

class GameController extends Controller
{
    // 1. Hiển thị form đăng bán
    public function create()
    {
        return view('games.create');
    }

    // 2. Xử lý lưu game và upload ảnh
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ], [
            'image.required' => 'Vui lòng chọn ảnh bìa cho game',
            'image.image' => 'File tải lên phải là hình ảnh',
            'image.max' => 'Ảnh không được quá 5MB để đảm bảo tốc độ',
        ]);

        try {
            $imageUrl = null;
            $publicId = null;

            if ($request->hasFile('image')) {
                // Upload lên Cloudinary
                // 'folder' => 'gaming_kai_products': Tên thư mục trên Cloud
                $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'gaming_kai_products',
                    'transformation' => [
                        'quality' => 'auto', // Tự động nén ảnh tối ưu
                        'fetch_format' => 'auto' // Tự động đổi đuôi sang webp/avif nếu trình duyệt hỗ trợ
                    ]
                ]);

                $imageUrl = $uploadedFile->getSecurePath(); // Lấy link https
                $publicId = $uploadedFile->getPublicId();   // Lấy ID để sau này xóa ảnh nếu cần
            }

            // Lưu vào Database (Giả lập - Bạn hãy dùng Model thật của bạn)
            /*
            Game::create([
                'name' => $request->name,
                'price' => $request->price,
                'image' => $imageUrl, // Lưu link: https://res.cloudinary.com/...
                'image_public_id' => $publicId, // Nên lưu thêm cái này để sau này xóa ảnh
                'description' => $request->description,
            ]);
            */

            // Tạm thời trả về kết quả để bạn test xem link ảnh hoạt động chưa
            return redirect()->back()->with('success', 'Đăng game thành công! Link ảnh: ' . $imageUrl);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi upload ảnh: ' . $e->getMessage());
        }
    }
}