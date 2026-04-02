<?php
namespace App\Http\Controllers\lessor;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\LocalOffer;
use App\Models\Participation;
use App\Models\ViewsAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; 
class LessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        $availableOffers = LocalOffer::with('local')->where('status', 'available')->get();
        $userCurrentParticipation = Participation::orderBy('created_at', 'desc')->where('user_id', $user->id)->whereNull('leftAt')->first();
        $chatRoom = $userCurrentParticipation
            ? ChatRoom::firstOrCreate(['local_offer_id' => $userCurrentParticipation->local_offer_id])
            : null;
        $participantsCount = $userCurrentParticipation
            ? Participation::where('local_offer_id', $userCurrentParticipation->local_offer_id)->whereNull('leftAt')->count()
            : 0;
        return view('lessor.dashboard', compact('availableOffers', 'userCurrentParticipation', 'user', 'chatRoom', 'participantsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
        if ($userCurrentParticipation = Participation::orderBy('created_at', 'desc')->where(['user_id' => $user->id])->first()) {
            if ($userCurrentParticipation->localOffer->status == 'available') {
                session()->flash('participationError', 'Your participation is still in an available local.');
                return Redirect('lessor/dashboard');
            }
        }
        $currentParticipations = Participation::where(['local_offer_id' => $availableOffer->id])->count() + 1;
        $priceToJoin = $availableOffer->totalPrice / $currentParticipations;
        var_dump($priceToJoin);
        Participation::create([
            'sharePrice' => $priceToJoin,
            'local_offer_id' => $availableOffer->id,
            'user_id' => $user->id,
        ]);
        return  Redirect('lessor/dashboard');
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
