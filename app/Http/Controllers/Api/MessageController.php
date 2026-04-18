<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Conversation $conversation): JsonResponse
    {
        abort_unless(
            $conversation->users()->whereKey(auth()->id())->exists(),
            403
        );

        $messages = $conversation
            ->messages()
            ->with('sender:id,name')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'data' => $messages,
        ]);
    }

    public function store(Request $request): JsonResponse
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

    public function destroy(Message $message): JsonResponse
    {
        $this->ensureAdmin();

        $message->delete();

        return response()->json(null, 204);
    }

    private function ensureAdmin(): void
    {
        abort_unless(
            auth()->user()?->roles()->where('name', 'admin')->exists(),
            403
        );
    }
}
