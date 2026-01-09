<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);

            $userMessage = $request->input('message');
            
            // 1. Lấy API Key an toàn
            // Ưu tiên lấy từ config, nếu không có mới lấy env (để tránh lỗi cache)
            $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
            
            if (empty($apiKey)) {
                Log::error('Chatbot Error: GEMINI_API_KEY chưa được cấu hình trong .env');
                return response()->json(['reply' => 'Hệ thống đang bảo trì chức năng chat (Thiếu API Key).'], 200); 
                // Trả về 200 để frontend không báo lỗi đỏ, nhưng báo nội dung bảo trì
            }

            // 2. Tải thủ công danh sách Thể loại (Map: ID => Tên)
            // Cách này tránh lỗi "with('categories')" nếu relationship bị sai cấu hình
            $allCategories = Category::all();
            $categoryMap = []; // Dùng để tra cứu tên thể loại theo ID
            $categoryNames = []; // Dùng để liệt kê cho Bot biết
            
            foreach ($allCategories as $cat) {
                $categoryMap[$cat->_id] = $cat->name; // _id là Mongo ID
                $categoryNames[] = $cat->name;
            }
            
            $categoryListString = empty($categoryNames) ? "Đa dạng" : implode(', ', $categoryNames);

            // 3. Tìm kiếm Category ID trùng với từ khóa khách hỏi
            $matchedCategoryIds = [];
            foreach ($allCategories as $cat) {
                if (stripos($cat->name, $userMessage) !== false) {
                    $matchedCategoryIds[] = $cat->_id; // Lưu lại ID thể loại khớp
                }
            }

            // 4. Tìm kiếm Game (Query đơn giản hóa)
            // Tìm theo Tên OR Mô tả OR thuộc Thể loại đã tìm thấy ở trên
            $query = Game::where('is_active', true);
            
            $query->where(function($q) use ($userMessage, $matchedCategoryIds) {
                // Tìm theo tên game
                $q->where('name', 'like', "%{$userMessage}%")
                  // Tìm theo mô tả
                  ->orWhere('description', 'like', "%{$userMessage}%");
                
                // Nếu tìm thấy thể loại khớp, tìm thêm các game có category_ids chứa ID đó
                if (!empty($matchedCategoryIds)) {
                     $q->orWhereIn('category_ids', $matchedCategoryIds);
                }
            });

            $games = $query->take(5)->get();

            // Nếu không có kết quả, lấy game mới nhất
            if ($games->isEmpty()) {
                $games = Game::where('is_active', true)->latest()->take(5)->get();
            }

            // 5. Chuẩn bị dữ liệu (Tra cứu tên thể loại thủ công)
            $gameDataText = "THÔNG TIN CỬA HÀNG:\n";
            $gameDataText .= "- Các thể loại hiện có: " . $categoryListString . ".\n\n";
            $gameDataText .= "DANH SÁCH GAME:\n";

            foreach ($games as $game) {
                $price = $game->price == 0 ? "Miễn phí" : number_format($game->price) . " VNĐ";
                
                // Xử lý tên thể loại (thủ công)
                $catName = "Chưa phân loại";
                if (!empty($game->category_ids) && is_array($game->category_ids)) {
                    // Lấy ID đầu tiên trong mảng category_ids của game
                    $firstCatId = $game->category_ids[0] ?? null;
                    if ($firstCatId && isset($categoryMap[$firstCatId])) {
                        $catName = $categoryMap[$firstCatId];
                    }
                }
                
                $shortDesc = Str::limit(strip_tags($game->description ?? ''), 120);
                
                $gameDataText .= "- Tên: {$game->name} | Thể loại: {$catName} | Giá: {$price}\n";
                $gameDataText .= "  Mô tả: {$shortDesc}\n";
            }

            // 6. Gửi sang Gemini
            $systemInstruction = "Bạn là Muki - Trợ lý ảo bán game.
            Nhiệm vụ: Trả lời ngắn gọn, vui vẻ, chốt đơn dựa trên DANH SÁCH GAME.
            Tuyệt đối không bịa ra game không có trong danh sách.
            Nếu khách hỏi về kỹ thuật/lỗi: Liên hệ Admin 0966846502.
            Mua game: Đăng nhập > Chọn > Thanh toán.
            
            DỮ LIỆU:";

            $finalPrompt = $systemInstruction . "\n\n" . $gameDataText . "\n\nKHÁCH HỎI: " . $userMessage;

            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [['parts' => [['text' => $finalPrompt]]]]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Muki đang suy nghĩ...';
                return response()->json(['reply' => $botReply]);
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['reply' => 'Muki đang hơi mệt, bạn hỏi lại sau nhé! (API Error)'], 200);
            }

        } catch (\Exception $e) {
            // Log lỗi chi tiết ra file storage/logs/laravel.log
            Log::error('Chatbot Controller Crash: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Trả về thông báo thân thiện thay vì lỗi 500 chết trang
            return response()->json(['reply' => 'Hệ thống gặp lỗi nhỏ, admin đang sửa. Bạn thử lại sau nhé!'], 200);
        }
    }
}