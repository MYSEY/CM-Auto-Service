<?php

namespace App\Http\Controllers\Backend;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminChatController extends Controller
{
    public function index()
    {
        // Get all unique sessions with last message and unread count
        $sessions = ChatMessage::select('session_id', DB::raw('MAX(id) as last_id'), DB::raw('MAX(created_at) as last_message_at'))
            ->groupBy('session_id')
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($session) {
                $lastMessage = ChatMessage::where('session_id', $session->session_id)->latest()->first();
                $unread = ChatMessage::where('session_id', $session->session_id)
                    ->where('sender', 'user')
                    ->where('is_read', false)
                    ->count();
                return (object) [
                    'session_id' => $session->session_id,
                    'last_message' => $lastMessage,
                    'unread' => $unread,
                    'last_message_at' => Carbon::parse($session->last_message_at),
                ];
            });

        return view('backends.chat.index', compact('sessions'));
    }

    public function show($sessionId)
    {
        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        ChatMessage::where('session_id', $sessionId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('backends.chat.show', compact('messages', 'sessionId'));
    }

    public function send(Request $request, $sessionId)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        ChatMessage::create([
            'session_id' => $sessionId,
            'sender' => 'admin',
            'message' => $request->message,
            'is_read' => true,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function poll($sessionId, Request $request)
    {
        $lastId = $request->input('last_id', 0);

        $messages = ChatMessage::where('session_id', $sessionId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark user messages as read
        ChatMessage::where('session_id', $sessionId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    public function destroy($sessionId)
    {
        ChatMessage::where('session_id', $sessionId)->delete();
        return redirect()->route('admin.chat.index')->with('success', 'Chat deleted!');
    }
}
