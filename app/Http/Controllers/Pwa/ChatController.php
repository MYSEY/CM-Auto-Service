<?php

namespace App\Http\Controllers\Pwa;

use App\Models\ChatMessage;
use App\Models\ChatBotResponse;
use App\Models\Company;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $messages = ChatMessage::where('session_id', $sessionId)->orderBy('created_at', 'asc')->get();
        $company = Company::first();
        $productType = ProductType::all();

        return view('pwa.chat', compact('messages', 'company', 'productType'));
    }

    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $message = ChatMessage::create([
            'session_id' => session()->getId(),
            'sender' => 'user',
            'message' => $request->message,
        ]);

        // Auto reply from database bot responses
        $this->botReply($message);

        return response()->json([
            'status' => 'success',
            'user_message' => $message,
        ]);
    }

    public function poll(Request $request)
    {
        $sessionId = session()->getId();
        $lastId = $request->input('last_id', 0);

        $messages = ChatMessage::where('session_id', $sessionId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ]);
    }

    private function botReply(ChatMessage $userMessage)
    {
        $text = strtolower($userMessage->message);

        // Get all active bot responses from database
        $botResponses = ChatBotResponse::where('is_active', true)->get();

        $matchedReply = null;

        foreach ($botResponses as $bot) {
            $keywords = array_map('trim', explode(',', strtolower($bot->keyword)));
            foreach ($keywords as $keyword) {
                if ($keyword && str_contains($text, $keyword)) {
                    $matchedReply = $bot->response;
                    break 2;
                }
            }
        }

        // If no match, use default reply
        if (!$matchedReply) {
            $matchedReply = setting('chat_default_reply', 'Thank you for your message. Our team will respond shortly. For urgent inquiries, call +855 031 486 6777.');
        }

        ChatMessage::create([
            'session_id' => $userMessage->session_id,
            'sender' => 'admin',
            'message' => $matchedReply,
        ]);
    }
}
