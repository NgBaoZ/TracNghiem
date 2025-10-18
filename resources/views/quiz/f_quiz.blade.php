<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thi Thử An Toàn Giao Thông</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Arial', sans-serif; }
        .correct-answer { background-color: #d1fae5 !important; border: 2px solid #10b981; }
        .incorrect-choice { background-color: #fee2e2 !important; border: 2px solid #ef4444; text-decoration: line-through; }
        .custom-gradient {
            background: linear-gradient( #4f9cab 100%);
        }
    </style>
</head>
<body class="custom-gradient min-h-screen flex flex-col justify-start items-center p-5">
    <div class="quiz-container flex flex-col md:flex-row gap-5 w-full max-w-6xl">
        
        <div id="quiz-form" class="w-full md:w-4/5 bg-white p-5 border-2 border-black rounded-lg min-h-[600px] overflow-y-auto md:ml-[140px]">
            <div class="question-area">
                <h2 class="text-2xl font-bold mb-5 text-gray-800">Thi Thử An Toàn Giao Thông</h2>

                @foreach($questions as $index => $question)
                    <div id="question-{{ $index + 1 }}" class="question mb-8 relative pr-20 border-b-2 border-black pb-8" data-index="{{ $index + 1 }}" data-correct-answer="{{ $question->ansright }}">
                        <button type="button" class="flag-btn absolute top-[-10px] right-0 bg-black text-white px-2 py-1 rounded text-sm hover:bg-gray-700 transition z-10">Đánh dấu</button>
                        <div class="question-content">
                            <p class="font-semibold text-base mb-2">{{ $index + 1 }}. {{ $question->title }}</p>
                            @if($question->content)
                                <div class="my-4 flex justify-center">
                                    <img src="{{ asset($question->content) }}" alt="Hình ảnh câu hỏi" class="rounded-lg max-w-sm border">
                                </div>
                            @endif
                            <div class="options flex flex-col gap-2">
                                <label class="p-2 bg-gray-100 rounded cursor-pointer flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="A" class="mr-2">
                                    1. {{ $question->ansa }}
                                </label>
                                <label class="p-2 bg-gray-100 rounded cursor-pointer flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="B" class="mr-2">
                                    2. {{ $question->ansb }}
                                </label>
                                @if($question->ansc)
                                <label class="p-2 bg-gray-100 rounded cursor-pointer flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="C" class="mr-2">
                                    3. {{ $question->ansc }}
                                </label>
                                @endif
                                @if($question->ansd)
                                <label class="p-2 bg-gray-100 rounded cursor-pointer flex items-center">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="D" class="mr-2">
                                    4. {{ $question->ansd }}
                                </label>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="sidebar fixed right-5 top-5 w-[300px] flex flex-col gap-5 md:static md:w-1/5">
            <div class="sticky top-0 z-50 flex flex-col gap-4">
                <div class="timer bg-gray-400 p-4 border-2 border-black rounded-lg text-white text-center">
                    <span class="block text-lg font-bold">Thi Thử (Không tính giờ)</span>
                </div>
                <div class="question-list bg-blue-600 p-2 border-2 border-black rounded-lg overflow-x-auto grid gap-1.5" style="grid-template-columns: repeat(5, minmax(0, 32px));">
                    @foreach($questions as $index => $question)
                        <button type="button" onclick="scrollToQuestion({{ $index + 1 }})" data-index="{{ $index + 1 }}" class="bg-white hover:scale-110 rounded w-8 h-8 flex items-center justify-center text-base transition-transform">{{ $index + 1 }}</button>
                    @endforeach
                </div>
                
                <button id="check-answers-btn" type="button" onclick="checkAnswers()" class="submit-btn bg-green-600 text-white px-4 py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition">
                    Xem kết quả
                </button>
                <div id="result-info" class="text-center p-2 bg-red-100 border border-red-400 rounded-lg hidden">
                    <span class="font-bold text-red-700">Số câu sai: <span id="incorrect-count">0</span></span>
                </div>
                <a id="back-to-home-btn" href="{{ route('index') }}" class="bg-gray-500 text-white text-center px-4 py-3 rounded-lg font-bold text-lg hover:bg-gray-600">
                    Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // --- Code JavaScript cũ giữ nguyên ---
        function scrollToQuestion(index) { const question = document.querySelector(`.question[data-index="${index}"]`); if (question) question.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        document.querySelectorAll('.flag-btn').forEach(btn => { btn.addEventListener('click', () => { const question = btn.closest('.question'); const index = question.dataset.index; const listBtn = document.querySelector(`.question-list button[data-index="${index}"]`); btn.classList.toggle('bg-red-600'); listBtn.classList.toggle('bg-red-600'); listBtn.classList.toggle('text-white'); if (btn.classList.contains('bg-red-600')) { listBtn.classList.remove('bg-white', 'bg-green-600'); } else { listBtn.classList.add('bg-white'); } }); });
        document.querySelectorAll('input[type="radio"]').forEach(radio => { radio.addEventListener('change', function() { const question = this.closest('.question'); const index = question.dataset.index; const listBtn = document.querySelector(`.question-list button[data-index="${index}"]`); if (this.checked) { listBtn.classList.remove('bg-white', 'bg-red-600', 'text-white'); listBtn.classList.add('bg-green-600', 'text-white'); } }); });

        // --- HÀM JAVASCRIPT ĐÃ ĐƯỢC NÂNG CẤP ---
        function checkAnswers() {
            let incorrectCount = 0;
            const allQuestions = document.querySelectorAll('.question');

            allQuestions.forEach(questionDiv => {
                // Chuẩn hóa đáp án đúng: Xóa khoảng trắng và chuyển thành chữ IN HOA
                const correctAnswer = questionDiv.dataset.correctAnswer.trim().toUpperCase();
                
                const questionId = questionDiv.querySelector('input[type="radio"]').name.match(/\[(\d+)\]/)[1];
                const selectedRadio = document.querySelector(`input[name="answers[${questionId}]"]:checked`);
                
                let userAnswer = null;
                if (selectedRadio) {
                    // Chuẩn hóa câu trả lời của người dùng
                    userAnswer = selectedRadio.value.trim().toUpperCase();
                }

                questionDiv.querySelectorAll('input[type="radio"]').forEach(radio => radio.disabled = true);

                if (userAnswer !== correctAnswer) {
                    incorrectCount++;
                    const index = questionDiv.dataset.index;
                    const listBtn = document.querySelector(`.question-list button[data-index="${index}"]`);
                    if(listBtn) {
                        listBtn.classList.remove('bg-green-600');
                        listBtn.classList.add('bg-red-600', 'text-white');
                    }
                }

                questionDiv.querySelectorAll('.options label').forEach(label => {
                    const radio = label.querySelector('input');
                    // So sánh với đáp án đã được chuẩn hóa
                    if (radio.value === correctAnswer) {
                        label.classList.add('correct-answer');
                    }
                    if (radio.checked && radio.value !== correctAnswer) {
                        label.classList.add('incorrect-choice');
                    }
                });
            });

            document.getElementById('incorrect-count').textContent = incorrectCount;
            document.getElementById('result-info').classList.remove('hidden');
            document.getElementById('check-answers-btn').classList.add('hidden');
            document.getElementById('back-to-home-btn').classList.remove('hidden');
        }
    </script>
</body>
</html>