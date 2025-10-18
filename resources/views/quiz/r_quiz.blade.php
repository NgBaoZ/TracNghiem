<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm Tra An Toàn Giao Thông</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Arial', sans-serif; }
        .custom-gradient {
            background: linear-gradient( #4f9cab 100%);
        }
    </style>
</head>
<body class="custom-gradient min-h-screen flex flex-col justify-start items-center p-5">
    <div class="quiz-container flex flex-col md:flex-row gap-5 w-full max-w-6xl">
        
        <form id="quiz-form" method="POST" action="{{ route('quiz.submit') }}" class="w-full md:w-4/5 bg-white p-5 border-2 border-black rounded-lg min-h-[600px] overflow-y-auto md:ml-[140px]">
            @csrf
            <div class="question-area">
                <h2 class="text-2xl font-bold mb-5 text-gray-800">Kiểm Tra An Toàn Giao Thông</h2>

                @foreach($questions as $index => $question)
                    <input type="hidden" name="question_ids[]" value="{{ $question->id }}">

                    <div id="question-{{ $index + 1 }}" class="question mb-8 relative pr-20 border-b-4 border-gray-300 pb-8" data-index="{{ $index + 1 }}">
                        <button type="button" class="flag-btn absolute top-[-10px] right-0 bg-black text-white px-2 py-1 rounded text-sm hover:bg-gray-700 transition z-10">Đánh dấu</button>
                        <div class="question-content">
                            
                           
                            <p class="font-semibold text-base mb-2">{{ $index + 1 }}. {{ $question->title }}</p>
                             {{-- Kiểm tra xem cột 'content' có chứa đường dẫn ảnh không --}}
                            @if($question->content)
                                <div class="my-4 flex justify-center">
                                    {{-- Dùng asset() để tạo đường dẫn đúng từ thư mục public --}}
                                    <img src="{{ asset($question->content) }}" alt="Hình ảnh câu hỏi {{ $index + 1 }}" class="rounded-lg max-w-sm border">
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
        </form>

        <div class="sidebar fixed right-5 top-5 w-[300px] flex flex-col gap-5 md:static md:w-1/5">
            <div class="sticky top-0 z-50 flex flex-col gap-4">
                <div class="timer bg-gray-400 p-4 border-2 border-black rounded-lg text-white text-center">
                    <span id="timer-text" class="block text-lg font-bold">Thời gian: 20:00</span>
                    <div class="progress-bar w-full h-2.5 bg-gray-300 rounded mt-2 overflow-hidden">
                        <div class="progress bg-green-500 h-full rounded transition-all duration-1000" id="progress-bar" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="question-list bg-blue-600 p-2 border-2 border-black rounded-lg overflow-x-auto grid gap-1.5" style="grid-template-columns: repeat(5, minmax(0, 32px));">
                    
                    @foreach($questions as $index => $question)
                        <button type="button" onclick="scrollToQuestion({{ $index + 1 }})" data-index="{{ $index + 1 }}" class="bg-white hover:scale-110 rounded w-8 h-8 flex items-center justify-center text-base transition-transform">{{ $index + 1 }}</button>
                    @endforeach
                    </div>
                 <button type="button" onclick="confirmSubmit()" class="submit-btn bg-red-600 text-white px-4 py-3 rounded-lg font-bold text-lg hover:bg-red-800 transition">
                    Nộp bài
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // --- Code JavaScript của bạn giữ nguyên, chỉ sửa lại hàm nộp bài ---
        const quizForm = document.getElementById('quiz-form');

        function confirmSubmit() {
            if (confirm('Bạn có chắc chắn muốn nộp bài không?')) {
                quizForm.submit();
            }
        }
        
        // --- Toàn bộ code JavaScript còn lại của bạn giữ nguyên ---
        let timeLeft = 1200; // 20 phút
        const timerText = document.getElementById('timer-text');
        const progressBar = document.getElementById('progress-bar');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerText.textContent = `Thời gian: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            const progressWidth = (timeLeft / 1200) * 100;
            progressBar.style.width = `${progressWidth}%`;
            if (timeLeft > 0) timeLeft--;
            else {
                clearInterval(timerInterval);
                alert('Hết thời gian!');
                quizForm.submit();
            }
        }
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();

        function scrollToQuestion(index) {
            const question = document.querySelector(`.question[data-index="${index}"]`);
            if (question) question.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        document.querySelectorAll('.flag-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const question = btn.closest('.question');
                const index = question.dataset.index;
                const listBtn = document.querySelector(`.question-list button[data-index="${index}"]`);
                btn.classList.toggle('bg-red-600');
                listBtn.classList.toggle('bg-red-600');
                listBtn.classList.toggle('text-white');
                if (btn.classList.contains('bg-red-600')) {
                    listBtn.classList.remove('bg-white', 'bg-green-600');
                } else {
                    listBtn.classList.add('bg-white');
                }
            });
        });

        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const question = this.closest('.question');
                const index = question.dataset.index;
                const listBtn = document.querySelector(`.question-list button[data-index="${index}"]`);
                if (this.checked) {
                    listBtn.classList.remove('bg-white', 'bg-red-600', 'text-white');
                    listBtn.classList.add('bg-green-600', 'text-white');
                }
            });
        });
    </script>
</body>
</html>