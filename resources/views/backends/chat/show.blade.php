@extends('layouts.backend.admin')

@section('content')
<div class="content-wrapper" style="height: 100vh; display: flex; flex-direction: column;">
    <div class="content-header" style="flex-shrink: 0;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('admin.chat.index') }}" class="btn btn-secondary btn-sm">&larr; Back</a>
                    <strong>Chat with User</strong>
                    <small class="text-muted">({{ substr($sessionId, -8) }})</small>
                </div>
            </div>
        </div>
    </div>

    <section class="content" style="flex: 1; overflow: hidden; display: flex; flex-direction: column;">
        <div class="container-fluid" style="flex: 1; display: flex; flex-direction: column; max-width: 800px;">
            <div class="card" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                <!-- Messages Area -->
                <div class="card-body" id="chatMessages" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; padding: 16px; background: #f4f6f9;">
                    @forelse($messages as $msg)
                        <div style="display: flex; justify-content: {{ $msg->sender === 'admin' ? 'flex-end' : 'flex-start' }};">
                            <div style="max-width: 70%; padding: 10px 14px; border-radius: 12px; font-size: 14px; line-height: 1.5;
                                @if($msg->sender === 'admin')
                                    background: #007bff; color: #fff; border-bottom-right-radius: 4px;
                                @else
                                    background: #fff; color: #333; border: 1px solid #dee2e6; border-bottom-left-radius: 4px;
                                @endif">
                                @if($msg->sender === 'admin')
                                    <small style="font-size:10px;opacity:0.7;display:block;">Admin</small>
                                @endif
                                {{ $msg->message }}
                                <div style="font-size:10px;opacity:0.6;margin-top:4px;text-align:right;">
                                    {{ $msg->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No messages yet.</div>
                    @endforelse
                </div>

                <!-- Input Area -->
                <div class="card-footer" style="flex-shrink: 0; display: flex; gap: 8px; padding: 12px; background: #fff; border-top: 1px solid #dee2e6;">
                    <input type="text" class="form-control" id="chatInput" placeholder="Type your reply..." autocomplete="off" style="border-radius: 20px;">
                    <button class="btn btn-primary" id="chatSend" style="border-radius: 20px; padding: 8px 20px;" disabled>
                        Send
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
const chatMessages = document.getElementById('chatMessages');
const chatInput = document.getElementById('chatInput');
const chatSend = document.getElementById('chatSend');
let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 0 }};

// Scroll to bottom
chatMessages.scrollTop = chatMessages.scrollHeight;

// Enable/disable send
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

    chatInput.value = '';
    chatSend.disabled = true;

    fetch('{{ route("admin.chat.send", $sessionId) }}', {
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
        if (res.status === 'success') {
            appendBubble('admin', text);
        }
    });
}

function appendBubble(sender, message) {
    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    const isAdmin = sender === 'admin';

    const wrapper = document.createElement('div');
    wrapper.style.display = 'flex';
    wrapper.style.justifyContent = isAdmin ? 'flex-end' : 'flex-start';

    const bubble = document.createElement('div');
    bubble.style.maxWidth = '70%';
    bubble.style.padding = '10px 14px';
    bubble.style.borderRadius = '12px';
    bubble.style.fontSize = '14px';
    bubble.style.lineHeight = '1.5';

    if (isAdmin) {
        bubble.style.background = '#007bff';
        bubble.style.color = '#fff';
        bubble.style.borderBottomRightRadius = '4px';
        bubble.innerHTML = '<small style="font-size:10px;opacity:0.7;display:block;">Admin</small>' + message;
    } else {
        bubble.style.background = '#fff';
        bubble.style.color = '#333';
        bubble.style.border = '1px solid #dee2e6';
        bubble.style.borderBottomLeftRadius = '4px';
    }

    bubble.innerHTML += '<div style="font-size:10px;opacity:0.6;margin-top:4px;text-align:right;">' + time + '</div>';

    wrapper.appendChild(bubble);
    chatMessages.appendChild(wrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Poll for new user messages every 3 seconds
setInterval(function() {
    fetch('{{ route("admin.chat.poll", $sessionId) }}?last_id=' + lastMessageId, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.messages && res.messages.length > 0) {
            res.messages.forEach(function(msg) {
                if (msg.sender === 'user') {
                    appendBubble(msg.sender, msg.message);
                }
                lastMessageId = msg.id;
            });
        }
    });
}, 3000);
</script>
@endsection
