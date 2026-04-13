<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',

            'content' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,

            'sender_id' => auth()->id(),

            'content' => $request->content,
        ]);

        // 🔥 Broadcast message
        broadcast(
            new MessageSent($message)
        )->toOthers();

        return response()->json($message);
    }
}
