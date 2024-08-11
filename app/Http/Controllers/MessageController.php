<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendMessage;

class MessageController extends Controller
{
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->validated());

        $receiver = User::find($request->user_id);
        $sender = User::find($request->from);

        // broadcast(new MessageSent($receiver, $sender, $request->message));


        return new MessageResource($message);
    }

    public function show(Message $message)
    {
        return new MessageResource($message);
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->validated());
        return new MessageResource($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->noContent();
    }


    //
    public function getUnreadMessages()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)->whereNull('read')->get();
        return MessageResource::collection($messages);
    }

    public function readAllMessages($sender)
    {
        $user = Auth()->user();
        Message::where('from', $sender)
            ->where('user_id', $user->id)
            ->whereNull('read')
            ->update(['read' => true]);

        return true;
    }

    public function getConversations()
    {
        $user = Auth::user();
        $conversations = Message::select('id', 'from', 'user_id', 'message', 'read', 'created_at')
            ->where('from', $user->id)
            ->orWhere('user_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->from === $user->id ? $message->user_id : $message->from;
            })
            ->map(function ($messages) {
                return $messages->first();
            })
            ->sortBy(function ($message) {
                return $message->read;
            })
            ->sortByDesc(function ($message) {
                return $message->created_at;
            });

        return MessageResource::collection($conversations->values());
    }

    public function getConversationWithUser($userId)
    {
        $user = Auth::user();
        $messages = Message::where(function ($query) use ($user, $userId) {
            $query->where('from', $user->id)
                ->where('user_id', $userId);
        })->orWhere(function ($query) use ($user, $userId) {
            $query->where('from', $userId)
                ->where('user_id', $user->id);
        })->get();

        return MessageResource::collection($messages);
    }
}
