<?php

namespace App\Http\Controllers\lessor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Friendship;
use App\Models\LocalOffer;
use App\Models\Participation;
use App\Notifications\InviteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendShipsController extends Controller
{
    public function searchUsers(Request $request)
    {
        $searchTerm = $request->query('query');
        $authId = Auth::id();

        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $users = User::where('role_id', 3)
            ->where('id', '!=', $authId)
            ->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(name) LIKE ?', [strtolower($searchTerm) . '%'])
                    ->orWhereRaw('LOWER(email) LIKE ?', [strtolower($searchTerm) . '%']);
            })
            ->get(['id', 'name', 'email']);

        $users = $users->map(function($user) use ($authId) {
            $friendship = Friendship::where(function($query) use ($authId, $user) {
                $query->where('sender_id', $authId)
                      ->where('receiver_id', $user->id);
            })->orWhere(function($query) use ($authId, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $authId);
            })->first();

            $user->friendship_status = $friendship ? $friendship->status : null;
            return $user;
        });

        return response()->json($users, 200);
    }

    public function sendFriendRequest(Request $request)
    {
        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');

        if (!$receiverId || $senderId == $receiverId) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $existingRequest = Friendship::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Request already sent'], 400);
        }

        Friendship::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Friend request sent'], 200);
    }

    public function searchAcceptedFriends(Request $request)
    {
        $searchTerm = $request->query('query');
        $authId = Auth::id();

        $query = Friendship::where('sender_id', $authId)
            ->where('status', 'accepted')
            ->with('receiver');

        if (!empty($searchTerm)) {
            $query->whereHas('receiver', function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $friendships = $query->get();

        $friends = $friendships->map(function($friendship) {
            return [
                'id' => $friendship->receiver->id,
                'name' => $friendship->receiver->name,
                'email' => $friendship->receiver->email
            ];
        });

        return response()->json($friends, 200);
    }

    public function acceptFriendRequest(Request $request)
    {
        $senderId = $request->input('sender_id');
        $receiverId = Auth::id();

        $friendship = Friendship::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('status', 'pending')
            ->first();

        if (!$friendship) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $friendship->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted'], 200);
    }

    public function sendInvite(Request $request)
    {
        try {
            $senderId = Auth::id();
            $receiverId = $request->input('receiver_id');
            $localOfferId = $request->input('local_offer_id');

            if (!$receiverId || !$localOfferId) {
                return response()->json(['message' => 'Invalid request'], 400);
            }

            $sender = Auth::user();
            $receiver = User::find($receiverId);
            $localOffer = LocalOffer::find($localOfferId);

            if (!$receiver || !$localOffer) {
                return response()->json(['message' => 'User or offer not found'], 404);
            }

            $activeParticipation = Participation::where('user_id', $receiverId)
                ->whereNull('leftAt')
                ->first();
            
            if ($activeParticipation) {
                return response()->json(['message' => 'This user is already participating in another local offer'], 400);
            }

            $receiver->notify(new InviteNotification($sender, $localOffer));
            return response()->json(['message' => 'Invite sent successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Invite send error: ' . $e->getMessage());
            return response()->json(['message' => 'Error sending invite', 'error' => $e->getMessage()], 500);
        }
    }

    public function acceptInvite(Request $request, $localOfferId, $userId)
    {
        if (!$request->hasValidSignature()) {
            return redirect('/lessor/dashboard')->with('error', 'Invalid or expired invitation link');
        }

        $activeParticipation = Participation::where('user_id', $userId)
            ->whereNull('leftAt')
            ->first();
        
        if ($activeParticipation) {
            return redirect('/lessor/dashboard')->with('error', 'You are already participating in another local offer. You can only join one offer at a time.');
        }

        $localOffer = LocalOffer::find($localOfferId);
        if (!$localOffer) {
            return redirect('/lessor/dashboard')->with('error', 'Offer not found');
        }

        $currentParticipations = Participation::where('local_offer_id', $localOfferId)->count() + 1;
        $priceToJoin = $localOffer->totalPrice / $currentParticipations;
        Participation::create([
            'sharePrice' => $priceToJoin,
            'local_offer_id' => $localOfferId,
            'user_id' => $userId,
            'joinedAt' => now(),
        ]);

        return redirect('/lessor/dashboard')->with('success', 'You have successfully accepted the invitation!');
    }
}
