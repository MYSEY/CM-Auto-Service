<?php

namespace App\Http\Controllers\Backend;

use App\Models\ChatBotResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ChatBotController extends Controller
{
    public function index()
    {
        $responses = ChatBotResponse::orderBy('id', 'asc')->get();
        $defaultReply = Cache::get('chat_default_reply', 'Thank you for your message. Our team will respond shortly. For urgent inquiries, call +855 031 486 6777.');
        return view('backends.chatbot.index', compact('responses', 'defaultReply'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:100',
            'response' => 'required|string|max:500',
        ]);

        ChatBotResponse::create([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.chatbot.index')->with('success', 'Bot response added!');
    }

    public function update(Request $request, $id)
    {
        $response = ChatBotResponse::findOrFail($id);

        $request->validate([
            'keyword' => 'required|string|max:100',
            'response' => 'required|string|max:500',
        ]);

        $response->update([
            'keyword' => $request->keyword,
            'response' => $request->response,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.chatbot.index')->with('success', 'Bot response updated!');
    }

    public function destroy($id)
    {
        ChatBotResponse::findOrFail($id)->delete();
        return redirect()->route('admin.chatbot.index')->with('success', 'Bot response deleted!');
    }

    public function toggle($id)
    {
        $response = ChatBotResponse::findOrFail($id);
        $response->update(['is_active' => !$response->is_active]);
        return redirect()->route('admin.chatbot.index')->with('success', 'Status updated!');
    }

    public function defaultReply(Request $request)
    {
        $request->validate(['default_reply' => 'required|string|max:500']);
        Cache::put('chat_default_reply', $request->default_reply, now()->addYears(1));
        return redirect()->route('admin.chatbot.index')->with('success', 'Default reply updated!');
    }
}
