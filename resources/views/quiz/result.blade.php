<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Bài Kiểm Tra</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-center mb-4">Kết Quả</h1>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <span class="block text-lg font-semibold">Số câu đúng / Tổng câu</span>
                    <span class="text-3xl font-bold">{{ $score }} / {{ $totalQuestions }}</span>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <span class="block text-lg font-semibold">Trạng thái</span>
                    @if($isPass)
                        <span class="text-3xl font-bold text-green-600">Đạt</span>
                    @else
                        <span class="text-3xl font-bold text-red-600">Không Đạt</span>
                    @endif
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg col-span-2 md:col-span-1">
                    <span class="block text-lg font-semibold">Gợi ý</span>
                    <span class="text-base">Xem lại các câu trả lời bên dưới.</span>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold mb-4">Xem lại chi tiết</h2>
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                <div class="p-4 border rounded-lg {{ isset($userAnswers[$question->id]) && strtoupper(trim($userAnswers[$question->id])) == strtoupper(trim($question->ansright)) ? 'border-green-400 bg-green-50' : 'border-red-400 bg-red-50' }}">
                    <p class="font-semibold mb-2">Câu {{ $index + 1 }}: {{ $question->title }}</p>
                    
                    @if($question->content)
                        <div class="my-4 flex justify-center">
                            <img src="{{ asset($question->content) }}" alt="Hình ảnh câu hỏi {{ $index + 1 }}" class="rounded-lg max-w-sm border">
                        </div>
                    @endif
                    
                    <div class="space-y-1 text-sm">
                        @php
                            $userAnswer = $userAnswers[$question->id] ?? null;
                            // Chuẩn hóa đáp án đúng để so sánh
                            $correctAnswer = strtoupper(trim($question->ansright));
                        @endphp
                        
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            @php
                                $ansColumn = 'ans' . strtolower($option);
                            @endphp
                            @if($question->$ansColumn)
                                <label class="p-2 rounded flex items-center @if($option == $correctAnswer) bg-green-200 @endif">
                                    <input type="radio" disabled @if($option == $userAnswer) checked @endif class="mr-2">
                                    <span class="@if($option == $userAnswer && $userAnswer != $correctAnswer) text-red-600 font-bold @endif">
                                        {{ $option }}. {{ $question->$ansColumn }}
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-6 space-x-4">
            <a href="{{ route('quiz.start') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Làm lại bài khác</a>
            <a href="{{ route('index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Về trang chủ</a>
        </div>
    </div>
</body>
</html>