@extends('layouts.backend.admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="font-weight-bold text-dark mb-1" style="font-size: 24px;">
                    <i class="fal fa-comments text-primary mr-2"></i> Live Chat Inbox
                </h1>
                <p class="text-muted fs-sm mb-0">Manage customer conversations and live support messages</p>
            </div>
            <span class="badge badge-primary p-2 px-3 fs-sm shadow-sm" style="border-radius: 30px;">
                <i class="fal fa-circle text-success mr-1"></i> Live Active Sessions
            </span>
        </div>
    </div>

    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead>
                            <tr class="text-uppercase fs-nano text-muted bg-light">
                                <th class="border-top-0 py-3 pl-4">Customer Session</th>
                                <th class="border-top-0 py-3">Last Message Preview</th>
                                <th class="border-top-0 py-3">Timestamp</th>
                                <th class="border-top-0 py-3">Unread</th>
                                <th class="border-top-0 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sessions as $session)
                                <tr style="{{ $session->unread > 0 ? 'background: #f0f7ff;' : '' }}">
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary-light text-primary p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: 700;">
                                                <i class="fal fa-user"></i>
                                            </div>
                                            <div>
                                                <span class="font-weight-bold text-dark">Session #{{ substr($session->session_id, -8) }}</span>
                                                <div class="text-muted fs-xs">{{ substr($session->session_id, 0, 16) }}...</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($session->last_message)
                                            <span class="badge {{ $session->last_message->sender === 'admin' ? 'badge-primary' : 'badge-info' }} mr-1">
                                                {{ ucfirst($session->last_message->sender) }}
                                            </span>
                                            <span class="text-secondary font-weight-medium">{{ Str::limit($session->last_message->message, 55) }}</span>
                                        @else
                                            <span class="text-muted font-italic">No messages yet</span>
                                        @endif
                                    </td>
                                    <td><span class="text-muted fs-xs font-weight-bold">{{ $session->last_message_at ? $session->last_message_at->diffForHumans() : '-' }}</span></td>
                                    <td>
                                        @if($session->unread > 0)
                                            <span class="badge badge-danger px-2">{{ $session->unread }} New</span>
                                        @else
                                            <span class="badge badge-secondary px-2 opacity-60">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.chat.show', $session->session_id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm mr-1 font-weight-bold">
                                            <i class="fal fa-comment-alt-text mr-1"></i> Open Chat
                                        </a>
                                        <form action="{{ route('admin.chat.destroy', $session->session_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this conversation?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Delete Session">
                                                <i class="fal fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fal fa-comments fa-3x text-muted mb-2 d-block opacity-40"></i>
                                        No active chat conversations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
