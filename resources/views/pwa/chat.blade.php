<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0d1b3e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CM Auto">
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontends/assets/img/logo.png') }}">
    <title>Chat — CM Auto</title>
    <link rel="stylesheet" href="{{ asset('pwa/pwa.css') }}">
    <style>
        body { display: flex; flex-direction: column; height: 100vh; height: 100dvh; overflow: hidden; }
        .pwa-content { flex: 1; overflow-y: auto; padding: 12px 16px 80px; display: flex; flex-direction: column; gap: 8px; -webkit-overflow-scrolling: touch; }

        /* Chat bubbles */
        .chat-bubble { max-width: 80%; padding: 10px 14px; border-radius: 16px; font-size: 14px; line-height: 1.5; word-wrap: break-word; animation: bubbleIn 0.3s ease-out; }
        @keyframes bubbleIn { 0% { opacity: 0; transform: translateY(8px) scale(0.95); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        .chat-user { align-self: flex-end; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border-bottom-right-radius: 4px; }
        .chat-admin { align-self: flex-start; background: var(--card); color: var(--text); border: 1px solid var(--border); border-bottom-left-radius: 4px; }
        .chat-time { font-size: 10px; opacity: 0.6; margin-top: 4px; }
        .chat-user .chat-time { text-align: right; }

        /* Chat input */
        .chat-input-bar { position: fixed; bottom: 0; left: 0; right: 0; background: var(--card); border-top: 1px solid var(--border); padding: 8px 12px; display: flex; gap: 8px; align-items: center; padding-bottom: calc(8px + env(safe-area-inset-bottom, 0)); z-index: 100; }
        .chat-input { flex: 1; padding: 10px 14px; border: 1px solid var(--border); border-radius: 20px; font-size: 14px; outline: none; background: var(--bg); color: var(--text); resize: none; max-height: 80px; line-height: 1.4; }
        .chat-input:focus { border-color: var(--primary); background: var(--card); }
        .chat-send { width: 40px; height: 40px; border-radius: 50%; border: none; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.15s; }
        .chat-send:active { transform: scale(0.9); }
        .chat-send:disabled { opacity: 0.4; }

        /* Welcome */
        .chat-welcome { text-align: center; padding: 32px 16px; color: var(--text-light); }
        .chat-welcome-icon { font-size: 40px; margin-bottom: 8px; }
        .chat-welcome p { font-size: 13px; line-height: 1.5; }

        /* Typing */
        .chat-typing { align-self: flex-start; padding: 10px 14px; background: var(--card); border: 1px solid var(--border); border-radius: 16px; border-bottom-left-radius: 4px; display: none; }
        .chat-typing.show { display: block; }
        .chat-typing-dots { display: flex; gap: 4px; }
        .chat-typing-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--text-light); animation: typingBounce 1.4s ease-in-out infinite; }
        .chat-typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .chat-typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce { 0%, 80%, 100% { transform: scale(0.6); } 40% { transform: scale(1); } }

        /* Header override */
        .chat-header-title { flex: 1; text-align: center; font-size: 16px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="pwa-header">
        <a href="{{ route('pwa.home') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 12px;font-size:13px;color:#fff;font-weight:500;">&#8592;</a>
        <div class="chat-header-title">Chat with Us</div>
        <button type="button" class="pwa-refresh-btn" onclick="pwaTogglePanel()" id="floatThemeBtn" title="Theme">&#9881;</button>
    </div>

    <div class="pwa-content" id="chatMessages">
        @if($messages->isEmpty())
            <div class="chat-welcome">
                <div class="chat-welcome-icon">&#128172;</div>
                <p>Welcome to CM Auto Service!<br>How can we help you today?</p>
            </div>
        @else
            @foreach($messages as $msg)
                <div class="chat-bubble {{ $msg->sender === 'user' ? 'chat-user' : 'chat-admin' }}">
                    {{ $msg->message }}
                    <div class="chat-time">{{ $msg->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        @endif

        <div class="chat-typing" id="chatTyping">
            <div class="chat-typing-dots">
                <div class="chat-typing-dot"></div>
                <div class="chat-typing-dot"></div>
                <div class="chat-typing-dot"></div>
            </div>
        </div>
    </div>

    <div class="chat-input-bar">
        <input type="text" class="chat-input" id="chatInput" placeholder="Type a message..." autocomplete="off">
        <button class="chat-send" id="chatSend" disabled>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
        </button>
    </div>

    <!-- Theme Panel -->
    <div class="pwa-theme-panel" id="themePanel">
        <div class="pwa-panel-title">Appearance</div>
        <div class="pwa-panel-item" onclick="pwaToggleTheme()">
            <span class="pwa-panel-icon" id="panelThemeIcon">&#9790;</span>
            <span id="panelThemeLabel">Dark Mode</span>
        </div>
        <div class="pwa-panel-item" onclick="pwaToggleBlur()">
            <span class="pwa-panel-icon">&#128171;</span>
            <span id="panelBlurLabel">Blur On</span>
            <div class="pwa-panel-dot" id="panelBlurDot"></div>
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

        // Scroll to bottom
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        scrollToBottom();

        // Enable/disable send button
        chatInput.addEventListener('input', function() {
            chatSend.disabled = !this.value.trim();
        });

        // Send on Enter
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

            // Remove welcome message
            const welcome = chatMessages.querySelector('.chat-welcome');
            if (welcome) welcome.remove();

            // Add user bubble immediately
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            appendBubble('user', text, time);

            // Show typing
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
                // Poll for admin reply
                setTimeout(pollMessages, 800);
            })
            .catch(() => {
                chatTyping.classList.remove('show');
                if (typeof pwaHandleError === 'function') pwaHandleError('Failed to send message. Please try again.');
            });
        }

        function appendBubble(sender, message, time) {
            const div = document.createElement('div');
            div.className = 'chat-bubble ' + (sender === 'user' ? 'chat-user' : 'chat-admin');
            div.innerHTML = message + '<div class="chat-time">' + time + '</div>';
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

        // Poll every 3 seconds
        pollTimer = setInterval(pollMessages, 3000);
    </script>
</body>
</html>
