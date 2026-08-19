<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0d1b3e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CM Auto">
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/logo.png') }}">
    <title>Chat — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('build/pwa.css') }}?v={{ filemtime(public_path('build/pwa.css')) }}">
    <style>
        @keyframes bubbleIn { 0% { opacity: 0; transform: translateY(8px) scale(0.95); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes typingBounce { 0%, 80%, 100% { transform: scale(0.6); } 40% { transform: scale(1); } }
        .chat-bubble { animation: bubbleIn 0.3s ease-out; }
        .chat-typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .chat-typing-dot:nth-child(3) { animation-delay: 0.4s; }
        .chat-typing-dot { animation: typingBounce 1.4s ease-in-out infinite; }

        .ios-header {
            background: rgba(255,255,255,0.92);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .ios-header { background: rgba(15,17,35,0.92); }

        .nav-pill { position: relative; }
        .nav-pill.active::before {
            content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 20px; height: 2px; border-radius: 1px; background: #0d1b3e;
        }
        .dark .nav-pill.active::before { background: #60a5fa; }

        .chat-input-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
        }
        .dark .chat-input-glass { background: rgba(28,30,45,0.85); }
    </style>
</head>
<body class="flex flex-col h-screen overflow-hidden bg-[#f2f2f7] dark:bg-[#0f1123]">

    <header class="ios-header sticky top-0 z-50 px-4 pt-3 pb-2 border-b border-gray-200/60 dark:border-[#2a2d3e]/60" style="padding-top: calc(12px + env(safe-area-inset-top, 0));">
        <div class="flex items-center justify-between">
            <a href="{{ route('pwa.home') }}" class="w-9 h-9 rounded-full flex items-center justify-center text-gray-800 dark:text-gray-200 active:bg-gray-200/60 dark:active:bg-white/10 transition-colors duration-150">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <h1 class="text-[17px] font-semibold text-gray-900 dark:text-white tracking-tight">Chat with Us</h1>
            <button type="button" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme" class="w-9 h-9 rounded-full flex items-center justify-center text-gray-800 dark:text-gray-200 active:bg-gray-200/60 dark:active:bg-white/10 transition-colors duration-150">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto px-4 pt-3 pb-24 flex flex-col gap-2.5 [overflow-scrolling:touch]" id="chatMessages">
        @if($messages->isEmpty())
            <div class="text-center py-12 px-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-200/80 dark:bg-white/10 flex items-center justify-center">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <p class="text-[14px] text-gray-500 dark:text-gray-400 leading-relaxed">Welcome to CM Auto Service!<br>How can we help you today?</p>
            </div>
        @else
            @foreach($messages as $msg)
                <div class="chat-bubble max-w-[80%] px-4 py-2.5 rounded-2xl text-[14px] leading-relaxed break-words {{ $msg->sender === 'user' ? 'self-end bg-gradient-to-br from-primary to-primary-light text-white rounded-br-md shadow-sm' : 'self-start bg-white dark:bg-[#1c1e2d] text-gray-900 dark:text-gray-200 border border-gray-200 dark:border-[#2a2d3e] rounded-bl-md shadow-sm shadow-black/[0.04] dark:shadow-black/20' }}">
                    {{ $msg->message }}
                    <div class="text-[10px] opacity-55 mt-1 {{ $msg->sender === 'user' ? 'text-right' : '' }}">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        @endif

        <div class="chat-typing self-start px-4 py-2.5 bg-white dark:bg-[#1c1e2d] border border-gray-200 dark:border-[#2a2d3e] rounded-2xl rounded-bl-md hidden shadow-sm shadow-black/[0.04] dark:shadow-black/20" id="chatTyping">
            <div class="flex gap-1.5 items-center">
                <div class="chat-typing-dot w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-500"></div>
                <div class="chat-typing-dot w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-500"></div>
                <div class="chat-typing-dot w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-500"></div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 z-50" style="padding-bottom: calc(8px + env(safe-area-inset-bottom, 0));">
        <div class="chat-input-glass border-t border-gray-200/60 dark:border-[#2a2d3e]/60 px-3 py-2 flex gap-2 items-center">
            <input type="text" class="flex-1 py-2.5 px-4 border border-gray-200 dark:border-[#2a2d3e] rounded-full text-[15px] outline-none bg-gray-100/80 dark:bg-white/5 text-gray-900 dark:text-gray-200 resize-none max-h-20 leading-normal focus:border-primary focus:bg-white dark:focus:bg-[#1c1e2d] transition-colors duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500" id="chatInput" placeholder="Message..." autocomplete="off">
            <button class="chat-send w-10 h-10 rounded-full border-none bg-gradient-to-br from-primary to-primary-light text-white cursor-pointer flex items-center justify-center flex-shrink-0 active:scale-90 transition-transform duration-150 disabled:opacity-40 shadow-sm" id="chatSend" disabled>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
            </button>
        </div>
    </div>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel fixed top-[60px] right-3 bg-white dark:bg-[#1c1e2d] rounded-2xl shadow-2xl shadow-black/20 py-2 z-[199] min-w-[180px] opacity-0 -translate-y-2.5 scale-95 pointer-events-none transition-all duration-300 ease-out border border-gray-200/60 dark:border-[#2a2d3e]/60" id="themePanel">
        <div class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider px-4 pt-2 pb-1">Appearance</div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-[14px] font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleTheme()">
            <span class="text-lg w-6 text-center" id="panelThemeIcon">&#9790;</span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="flex items-center gap-2.5 px-4 py-3 text-[14px] font-medium cursor-pointer active:bg-gray-100 dark:active:bg-white/5 transition-colors duration-200 rounded-lg mx-1" onclick="pwaToggleBlur()">
            <span class="text-lg w-6 text-center">&#128171;</span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="ml-auto w-9 h-5 rounded-full bg-gray-400 relative transition-colors duration-300" id="panelBlurDot">
                <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform duration-300"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('pwa/error-handler.js') }}"></script>
    <script src="{{ asset('pwa/pwa-connectivity.js') }}"></script>
    <script src="{{ asset('pwa/pwa-theme.js') }}"></script>
    <script src="{{ asset('pwa/pwa.js') }}"></script>
    <script>
        const chatMessages = document.getElementById('chatMessages');
        const chatInput = document.getElementById('chatInput');
        const chatSend = document.getElementById('chatSend');
        const chatTyping = document.getElementById('chatTyping');
        let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 0 }};
        let pollTimer = null;

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        scrollToBottom();

        chatInput.addEventListener('input', function() {
            chatSend.disabled = !this.value.trim();
        });

        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        chatSend.addEventListener('click', sendMessage);

        function sendMessage() {
            const text = chatInput.value.trim();
            if (!text) return;

            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) {
                if (typeof pwaHandleError === 'function') pwaHandleError('You are offline. Please check your connection.');
                return;
            }

            chatInput.value = '';
            chatSend.disabled = true;

            const welcome = chatMessages.querySelector('.chat-welcome');
            if (welcome) welcome.remove();

            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            appendBubble('user', text, time);

            chatTyping.classList.add('show');
            scrollToBottom();

            fetch('{{ route("pwa.chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'message=' + encodeURIComponent(text)
            })
            .then(r => r.json())
            .then(res => {
                chatTyping.classList.remove('show');
                if (res.user_message) {
                    lastMessageId = res.user_message.id;
                }
                setTimeout(pollMessages, 800);
            })
            .catch(() => {
                chatTyping.classList.remove('show');
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to send message. Please try again.');
            });
        }

        function appendBubble(sender, message, time) {
            const div = document.createElement('div');
            div.className = 'chat-bubble max-w-[80%] px-4 py-2.5 rounded-2xl text-[14px] leading-relaxed break-words ' + (sender === 'user' ? 'self-end bg-gradient-to-br from-primary to-primary-light text-white rounded-br-md shadow-sm' : 'self-start bg-white dark:bg-[#1c1e2d] text-gray-900 dark:text-gray-200 border border-gray-200 dark:border-[#2a2d3e] rounded-bl-md shadow-sm shadow-black/[0.04] dark:shadow-black/20');
            div.innerHTML = message + '<div class="text-[10px] opacity-55 mt-1 ' + (sender === 'user' ? 'text-right' : '') + '">' + time + '</div>';
            chatMessages.insertBefore(div, chatTyping);
            scrollToBottom();
        }

        function pollMessages() {
            if (typeof pwaIsOffline === 'function' && pwaIsOffline()) return;
            fetch('{{ route("pwa.chat.poll") }}?last_id=' + lastMessageId, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.messages && res.messages.length > 0) {
                    res.messages.forEach(function(msg) {
                        if (msg.sender !== 'user') {
                            const time = new Date(msg.created_at).getHours().toString().padStart(2, '0') + ':' + new Date(msg.created_at).getMinutes().toString().padStart(2, '0');
                            appendBubble(msg.sender, msg.message, time);
                        }
                        lastMessageId = msg.id;
                    });
                }
            })
            .catch(() => {});
        }

        pollTimer = setInterval(pollMessages, 3000);
    </script>
</body>
</html>