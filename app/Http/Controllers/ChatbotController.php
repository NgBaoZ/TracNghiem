<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function handleMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:255']);
        $userMessage = $request->input('message');

        $apiKey = config('app.gemini_api_key');
        if (!$apiKey) {
            return response()->json(['reply' => 'Lỗi: API Key chưa được cấu hình.'], 500);
        }

        // --- ĐÂY LÀ PHẦN QUAN TRỌNG NHẤT ---
        // Chúng ta "dạy" cho Bot biết vai trò và giới hạn của nó
        $prompt = "Bạn là một trợ lý ảo tên 'Bot An Toàn', chuyên gia về luật giao thông đường bộ của Việt Nam. " ;
                  

        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $reply = $response->json('candidates.0.content.parts.0.text', 'Xin lỗi, tôi chưa thể trả lời câu hỏi này.');
                return response()->json(['reply' => $reply]);
            } else {
                return response()->json(['reply' => 'Có lỗi xảy ra khi kết nối với trợ lý AI.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Lỗi hệ thống, không thể xử lý yêu cầu.'], 500);
        }
    }
}