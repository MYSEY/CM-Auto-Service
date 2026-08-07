@extends('layouts.backend.admin')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat Bot Management</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <!-- Add New Response -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Bot Response</h3>
                        </div>
                        <form action="{{ route('admin.chatbot.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Keyword (trigger word)</label>
                                    <input type="text" name="keyword" class="form-control" placeholder="e.g. hello, price, ecu" required>
                                    <small class="text-muted">When user types this keyword, bot will reply</small>
                                </div>
                                <div class="form-group">
                                    <label>Bot Reply Message</label>
                                    <textarea name="response" class="form-control" rows="3" placeholder="Enter bot reply message..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" checked> Active
                                    </label>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Response</button>
                            </div>
                        </form>
                    </div>

                    <!-- Default Reply -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Default Reply</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">When no keyword matches, bot will reply with a default message. Edit below:</p>
                            <form action="{{ route('admin.chatbot.default') }}" method="POST">
                                @csrf
                                <textarea name="default_reply" class="form-control" rows="3">{{ $defaultReply ?? 'Thank you for your message. Our team will respond shortly.' }}</textarea>
                                <button type="submit" class="btn btn-secondary mt-2">Save Default Reply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Response List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bot Responses ({{ $responses->count() }})</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Keyword</th>
                                        <th>Response</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($responses as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><code>{{ $item->keyword }}</code></td>
                                            <td>{{ Str::limit($item->response, 80) }}</td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.chatbot.toggle', $item->id) }}" class="btn btn-sm btn-outline-info">
                                                    {{ $item->is_active ? 'Disable' : 'Enable' }}
                                                </a>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#editModal{{ $item->id }}">Edit</button>
                                                <form action="{{ route('admin.chatbot.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this response?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.chatbot.update', $item->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Bot Response</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Keyword</label>
                                                                <input type="text" name="keyword" class="form-control" value="{{ $item->keyword }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Bot Reply</label>
                                                                <textarea name="response" class="form-control" rows="3" required>{{ $item->response }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>
                                                                    <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}> Active
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No bot responses yet. Add one above.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
