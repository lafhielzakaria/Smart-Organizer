<?php
namespace App\Http\Controllers\lessor;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\LocalOffer;
use App\Models\Participation;
use App\Models\Friendship;
use App\Models\ViewsAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; 
class LessorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userCurrentParticipation = Participation::orderBy('id', 'desc')->where('user_id', $user->id)->whereNull('leftAt')->first();
        
        $currentLocalOffer = null;
        $participantsCount = 0;
        $participants = [];
        
        if ($userCurrentParticipation) {
            $currentLocalOffer = LocalOffer::with('local')->find($userCurrentParticipation->local_offer_id);
            $participantRecords = Participation::with('user')->where('local_offer_id', $userCurrentParticipation->local_offer_id)->whereNull('leftAt')->orderBy('created_at', 'asc')->get();
            $participantsCount = $participantRecords->count();
            $participants = $participantRecords->map(function($p) {
                return [
                    'id' => $p->user->id,
                    'name' => $p->user->name,
                    'email' => $p->user->email
                ];
            })->toArray();
        }
        
        $availableOffers = $userCurrentParticipation ? [] : LocalOffer::with('local')
            ->where('status', 'available')
            ->get()
            ->unique('local_id')
            ->values();
        
        $chatRoom = $userCurrentParticipation
            ? ChatRoom::firstOrCreate(['local_offer_id' => $userCurrentParticipation->local_offer_id])
            : null;
        
        $pendingRequests = Friendship::with('sender')->where('receiver_id', $user->id)->where('status', 'pending')->get();
        
        return view('lessor.dashboard', compact('availableOffers', 'userCurrentParticipation', 'user', 'chatRoom', 'participantsCount', 'currentLocalOffer', 'participants', 'pendingRequests'));
    }

    public function viewDetails(Request $request, LocalOffer $availableOffer)
    {
        if ($jobOfferViewDetails = ViewsAnalytics::where("local_offer_id", $availableOffer->id)) {
            $jobOfferViewDetails->increment('viewTime');
            return view('lessor.offerDetails', compact('availableOffer'));
        }
        ViewsAnalytics::create([
            'viewTime' => 1,
            'local_offer_id' => $availableOffer->id,
        ]);
        return view('lessor.offerDetails', compact('availableOffer'));
    }
    public function apply(Request $request, LocalOffer $availableOffer)
    {
        $user = Auth::user();
        
        $activeParticipation = Participation::where('user_id', $user->id)
            ->whereNull('leftAt')
            ->first();
        
        if ($activeParticipation) {
            session()->flash('participationError', 'You are already participating in another local offer. You can only join one offer at a time.');
            return Redirect('lessor/dashboard');
        }

        $currentParticipations = Participation::where(['local_offer_id' => $availableOffer->id])->count() + 1;
        $priceToJoin = $availableOffer->totalPrice / $currentParticipations;
        
        Participation::create([
            'sharePrice' => $priceToJoin,
            'local_offer_id' => $availableOffer->id,
            'user_id' => $user->id,
            'joinedAt' => now(),
        ]);
        return  Redirect('lessor/dashboard');
    }

}
