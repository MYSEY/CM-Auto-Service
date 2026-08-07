@extends('layouts.backend.admin')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat Inbox</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Session</th>
                                <th>Last Message</th>
                                <th>Time</th>
                                <th>Unread</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                                <tr style="{{ $session->unread > 0 ? 'background: #f0f7ff;' : '' }}">
                                    <td>
                                        <strong>{{ substr($session->session_id, -8) }}</strong>
                                        <br><small class="text-muted">{{ substr($session->session_id, 0, 16) }}...</small>
                                    </td>
                                    <td>
                                        @if($session->last_message)
                                            <span class="badge {{ $session->last_message->sender === 'admin' ? 'badge-primary' : 'badge-info' }}">
                                                {{ $session->last_message->sender }}
                                            </span>
                                            {{ Str::limit($session->last_message->message, 50) }}
                                        @endif
                                    </td>
                                    <td><small>{{ $session->last_message_at->diffForHumans() }}</small></td>
                                    <td>
                                        @if($session->unread > 0)
                                            <span class="badge badge-danger">{{ $session->unread }}</span>
                                        @else
                                            <span class="badge badge-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.chat.show', $session->session_id) }}" class="btn btn-sm btn-primary">
                                            Open Chat
                                        </a>
                                        <form action="{{ route('admin.chat.destroy', $session->session_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this chat?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No chat conversations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
