<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Game;
use App\Models\Category;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        $games = Game::with('category')
            ->where('name', 'like', "%{$userMessage}%")
            ->orWhereHas('category', function ($q) use ($userMessage) {
                $q->where('name', 'like', "%{$userMessage}%");
            })
            ->take(5) // Lấy tối đa 5 game để không bị quá dài
            ->get();

        // Nếu không tìm thấy game nào cụ thể, lấy 5 game mới nhất để làm vốn từ
        if ($games->isEmpty()) {
            $games = Game::with('category')->latest()->take(5)->get();
        }

        // Tạo chuỗi văn bản chứa thông tin game để nạp cho Gemini
        $gameDataText = "DỮ LIỆU GAME HIỆN CÓ TẠI SHOP (Dùng để trả lời khách):\n";
        foreach ($games as $game) {
            $price = $game->price == 0 ? "Miễn phí" : number_format($game->price) . " VNĐ";
            $catName = $game->category ? $game->category->name : "Chưa phân loại";
            $gameDataText .= "- Tên: {$game->name} | Thể loại: {$catName} | Giá: {$price}\n";
        }

        // Định nghĩa vai trò cho Bot
        $systemInstruction = "Bạn là 'Trợ lý ảo Muki' 🤖 của Mirai Store - Cửa hàng game.
        
        PHONG CÁCH TRẢ LỜI:
        - Thân thiện, ngắn gọn, dùng emoji vui vẻ (😊, 🎮, 🔥).
        - Xưng hô: 'Muki' và 'bạn'.
        - Trả lời dựa trên thông tin DỮ LIỆU GAME được cung cấp bên dưới. Nếu khách hỏi game không có trong dữ liệu, hãy bảo là 'Hiện tại shop chưa có game này'.

        KIẾN THỨC CẦN NHỚ:
        1. CÁCH MUA GAME: 
           B1: Đăng nhập.
           B2: Chọn game > Thêm vào giỏ.
           B3: Thanh toán (VNPAY/Momo).
           B4: Tải game ngay tại mục 'Lịch sử đơn hàng'.
           
        2. QUÊN MẬT KHẨU:
           Bạn hãy liên hệ với số Zalo/Hotline của Admin này nhé: 0966846502.
           
        3. CHÍNH SÁCH BẢO HÀNH/HOÀN TIỀN:
           - Chỉ hoàn tiền trong 24h nếu lỗi do hệ thống.
           - KHÔNG hoàn tiền nếu máy khách yếu hoặc mua nhầm.

        KHÁCH HÀNG HỎI: ";
        $finalPrompt = $systemInstruction . "\n\n" . $gameDataText . "\n\nKHÁCH HÀNG HỎI: " . $userMessage;

        // ---------------------------------------------------------
        // BƯỚC 3: GỬI SANG GEMINI
        // ---------------------------------------------------------
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $finalPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Muki đang suy nghĩ...';
                return response()->json(['reply' => $botReply]);
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['reply' => 'Muki đang bị đau đầu, bạn hỏi lại sau nhé! 🤕'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['reply' => 'Lỗi kết nối đến Muki.'], 500);
        }
    }
}
