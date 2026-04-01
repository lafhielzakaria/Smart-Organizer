<?php

namespace App\Http\Controllers\lessor;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function getUserChatRoom()
    {
        $user = Auth::user();
        $participation = Participation::where('user_id', $user->id)->whereNull('leftAt')->first();

        if (!$participation) return null;

        return ChatRoom::firstOrCreate(['local_offer_id' => $participation->local_offer_id]);
    }

    public function index(Request $request)
    {
        $chatRoom = $this->getUserChatRoom();
        if (!$chatRoom) return response()->json([]);

        $query = Message::with('sender:id,name')
            ->where('chat_room_id', $chatRoom->id);

        if ($request->has('after')) {
            $query->where('id', '>', $request->after);
        }

        return response()->json($query->orderBy('id')->get(['id', 'content', 'sender_id', 'created_at']));
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $chatRoom = $this->getUserChatRoom();
        if (!$chatRoom) return response()->json(['error' => 'No active participation'], 403);

        $message = Message::create([
            'content'      => $request->content,
            'sender_id'    => Auth::id(),
            'chat_room_id' => $chatRoom->id,
        ]);

        return response()->json($message->load('sender:id,name'));
    }
}
