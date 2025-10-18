<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Hệ Thống Thi Trắc Nghiệm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-gradient {
            background: linear-gradient(135deg, #072f68 0%, #4f9cab 100%);
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="custom-gradient flex flex-col min-h-screen p-5">
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full bg-white shadow-md py-4 px-6 flex justify-between items-center z-10">
        <div class="text-2xl font-bold text-gray-800">Hệ Thống Thi Trắc Nghiệm</div>
        <nav class="space-x-4">
            <!-- Add navigation links here if needed -->
        </nav>
        <div class="relative">
            <details class="group">
                <summary class="flex items-center cursor-pointer list-none">
                    
                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('img/test.jpg') }}" 
                        alt="Avatar" class="w-14 h-14 rounded-full mr-2 object-cover border-2 border-white">
                    
                    <span class="text-gray-800 font-medium">{{ Auth::user()->name }}</span>
                    
                </summary>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Thông Tin Người Dùng</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                            Đăng Xuất
                        </button>
                    </form>
                    
                </div>
            </details>
        </div>
    </header>

    <!-- Nội dung chính -->
    <main class="flex-grow flex items-center justify-center pt-24 pb-20">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Thi Trắc Nghiệm An Toàn Giao Thông</h1>
            <div class="space-y-4">
                <a href="{{ route('quiz.start') }}" class="block w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">Bắt Đầu Thi</a>
                <a href="{{ route('f_quiz') }}" class="block w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">Thi Thử</a>
                <a href="/lich-su" class="block w-full bg-yellow-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition">Lịch Sử</a>
                <!-- link 600 câu-->
                <a href="https://www.csgt.vn/upload/services/273963059_B%E1%BB%99%20600%20c%C3%A2u%20h%E1%BB%8Fi%20d%C3%B9ng%20cho%20s%C3%A1t%20h%E1%BA%A1ch%20l%C3%A1i%20xe%20c%C6%A1%20gi%E1%BB%9Bi%20%C4%91%C6%B0%E1%BB%9Dng%20b%E1%BB%99.pdf"
                 target="_blank" 
                 class="block w-full text-blue-600 underline hover:text-blue-800 transition">Xem 600 Câu Trắc Nghiệm</a>
            </div>
        </div>
    </main>

{{-- Chat bot --}}
<div id="chat-widget" class="fixed bottom-5 right-5 z-50">
    <button id="chat-open-btn" class="bg-blue-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg text-3xl hover:bg-blue-700 transition">
        <i class="far fa-comment-dots"></i>
    </button>

    <div id="chat-window" class="hidden absolute bottom-20 right-0 w-80 bg-white rounded-lg shadow-2xl flex flex-col" style="height: 500px;">
        <div class="bg-blue-600 text-white p-3 flex justify-between items-center rounded-t-lg">
            <h3 class="font-bold">Bot An Toàn</h3>
            <button id="chat-close-btn" class="text-xl">&times;</button>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-100">
            <div class="chat-bubble bot mb-2">
                <p class="bg-gray-300 text-gray-800 rounded-lg py-2 px-3 inline-block">Xin chào! Tôi có thể giúp gì cho bạn về luật giao thông?</p>
            </div>
        </div>

        <div class="p-3 border-t">
            <form id="chat-form" class="flex gap-2">
                <input id="chat-input" type="text" placeholder="Nhập câu hỏi..." class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700">&gt;</button>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

<footer class="fixed bottom-0 left-0 w-full bg-gray-800 text-white py-4 px-6 text-center z-40">
    <p class="text-sm">&copy; 2025 Hệ Thống Thi Trắc Nghiệm An Toàn Giao Thông. All rights reserved.</p>
    <p class="text-sm mt-2">Liên hệ: <a href="#" class="underline hover:text-gray-300 transition"></a></p>
</footer>



    <script>
    const chatOpenBtn = document.getElementById('chat-open-btn');
    const chatCloseBtn = document.getElementById('chat-close-btn');
    const chatWindow = document.getElementById('chat-window');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    // Mở/Đóng cửa sổ chat
    chatOpenBtn.addEventListener('click', () => {
        chatWindow.classList.remove('hidden');
        chatOpenBtn.classList.add('hidden');
    });
    chatCloseBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
        chatOpenBtn.classList.remove('hidden');
    });

    // Xử lý gửi tin nhắn
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        // Hiển thị tin nhắn của người dùng
        appendMessage(message, 'user');
        chatInput.value = '';
        showTypingIndicator();

        try {
            // Gửi tin nhắn đến backend
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            });

            if (!response.ok) {
                throw new Error('Lỗi từ server.');
            }

            const data = await response.json();
            
            // Hiển thị câu trả lời của bot
            removeTypingIndicator();
            appendMessage(data.reply, 'bot');

        } catch (error) {
            removeTypingIndicator();
            appendMessage('Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại.', 'bot');
        }
    });

    // Hàm để thêm tin nhắn vào giao diện
    function appendMessage(text, sender) {
        const messageDiv = document.createElement('div');
        const bubbleP = document.createElement('p');
        
        if (sender === 'user') {
            messageDiv.className = 'chat-bubble user text-right mb-2';
            bubbleP.className = 'bg-blue-500 text-white rounded-lg py-2 px-3 inline-block';
        } else {
            messageDiv.className = 'chat-bubble bot mb-2';
            bubbleP.className = 'bg-gray-300 text-gray-800 rounded-lg py-2 px-3 inline-block';
        }
        
        // Chuyển đổi markdown đơn giản thành HTML (cho xuống dòng)
        bubbleP.innerHTML = text.replace(/\n/g, '<br>');
        
        messageDiv.appendChild(bubbleP);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Tự cuộn xuống cuối
    }

    // Hiệu ứng "Bot đang gõ..."
    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'chat-bubble bot mb-2';
        typingDiv.innerHTML = `<p class="bg-gray-300 text-gray-800 rounded-lg py-2 px-3 inline-block">Đang trả lời...</p>`;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        if (indicator) {
            indicator.remove();
        }
    }
</script>
</body>
</html>