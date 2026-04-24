@extends('layouts.app')
@section('title', 'Lessor Dashboard')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@vite(['resources/css/lessor-dashboard.css', 'resources/js/lessor-dashboard.js'])
<script>
    window.chatConfig = {
        chatRoomId: "{{ $chatRoom ? $chatRoom->id : '' }}" || null,
        currentUserId: "{{ $user->id }}",
        currentUserName: "{{ $user->name }}",
        localOfferId: "{{ $currentLocalOffer ? $currentLocalOffer->id : '' }}" || null,
        csrfToken: "{{ csrf_token() }}",
        usersSearchUrl: "{{ route('users.search') }}",
        sendFriendshipUrl: "{{ route('friendships.send') }}",
        acceptFriendshipUrl: "{{ route('friendships.accept') }}",
        friendsSearchUrl: "{{ route('friends.accepted.search') }}",
        sendInviteUrl: "{{ route('invites.send') }}",
        @if($currentLocalOffer && $currentLocalOffer -> endTime) hasTimer: true,
        endTime: "{{ $currentLocalOffer->endTime }}",
        completeOfferUrl: "{{ route('offers.complete', $currentLocalOffer->id) }}"
        @else hasTimer: false @endif
    };
</script>
@endsection
@section('content')
<div class="dashboard-page">
    <div class="beams">
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
        <div class="beam"></div>
    </div>
    <div class="stripe-bg"></div>
    <div class="dashboard-inner">
        <div class="dash-header">
            <div class="hdr-line"></div>
            <div class="hdr-center"><span class="hdr-eyebrow">Smart Organizer</span>
                <div class="hdr-title">Lessor <span>Dashboard</span></div>
            </div>
            <div class="hdr-line r"></div>
        </div>
        <div class="action-bar"><button type="button" id="addFriendBtn" class="btn-gold">Add Friend</button><button type="button" id="friendRequest" class="btn-gold">Friend Requests</button></div>
        <div class="grid-layout">
            <div>
                @if($userCurrentParticipation && $currentLocalOffer)
                <div class="card">
                    @if($currentLocalOffer->local->image)
                    <img src="{{ str_starts_with($currentLocalOffer->local->image, 'http') ? $currentLocalOffer->local->image : asset('storage/' . $currentLocalOffer->local->image) }}" alt="{{ $currentLocalOffer->local->name }}" class="offer-img">
                    @else
                    <div style="width:100%;height:280px;background:var(--panel2);display:flex;align-items:center;justify-content:center;color:var(--muted);">No image available</div>
                    @endif
                    @if($currentLocalOffer->endTime)
                    <div class="offer-timer-bar"><span id="offerTimer" class="offer-timer">--:--:--</span></div>
                    @endif
                    <div class="offer-info">
                        <h2 class="offer-title">{{ $currentLocalOffer->local->name }}</h2>
                        <p class="offer-subtitle">{{ $currentLocalOffer->local->description ?? $currentLocalOffer->local->type . ' · ' . $currentLocalOffer->local->city }}</p>
                        <div class="offer-btns">
                            <button type="button" onclick="openModal('participantsModal')" class="btn-gold">{{ $participantsCount }} {{ $participantsCount === 1 ? 'person' : 'people' }} joined</button>
                            <button type="button" onclick="openModal('inviteModal')" class="btn-gold">Invite</button>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        <h2>Available Offers</h2><span class="card-badge">{{ $availableOffers->count() }} available</span>
                    </div>
                    <div class="card-body">
                        @forelse($availableOffers as $offer)
                        <div class="offer-item">
                            @if($offer->local->image)
                            <img src="{{ str_starts_with($offer->local->image, 'http') ? $offer->local->image : asset('storage/' . $offer->local->image) }}" alt="{{ $offer->local->name }}">
                            @else
                            <div style="width:100%;height:140px;background:var(--panel2);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:11px;">No image</div>
                            @endif
                            <div class="offer-item-body">
                                <span class="offer-name">{{ $offer->local->name }}</span>
                                <span class="offer-desc">{{ Str::limit($offer->local->description ?? $offer->local->type . ' · ' . $offer->local->city, 120) }}</span>
                                <div class="offer-actions">
                                    <a href="{{ route('offer.details', $offer) }}" class="btn-details">Details</a>
                                    <a href="{{ route('lessor.apply', $offer) }}" class="btn-apply">Apply</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:var(--muted);font-size:14px;text-align:center;padding:20px 0;grid-column:span 2;">No available offers at the moment.</p>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>
            <div class="card chat-card">
                <div class="card-header">
                    <h2>Group Chat</h2><button id="chat-toggle" onclick="toggleChat()" class="chat-toggle">−</button>
                </div>
                @if($chatRoom)
                <div id="chat-body">
                    <div id="chat-messages" class="chat-messages"></div>
                    <div class="chat-input-area">
                        <input type="text" id="message-input" class="chat-input" placeholder="Type a message...">
                        <button type="button" id="send-btn" class="btn-send">Send</button>
                    </div>
                </div>
                @else
                <div style="padding:40px;text-align:center;color:var(--muted);">Join a local offer to access the group chat.</div>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="participantsModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Participants ({{ $participantsCount }})</h3><button id="participantsModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($participants as $participant)
                @if($participant['id'] !== $user->id)
                <div style="display:flex;align-items:center;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);">
                    <div style="flex:1;">
                        <div style="font-size:14px;font-weight:700;color:var(--white);">{{ $participant['name'] }}</div>
                        <div style="font-size:12px;color:var(--muted);">{{ $participant['email'] }}</div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="inviteModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Invite Friends</h3><button id="inviteModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div id="inviteSearchResults" class="search-results"></div>
        </div>
    </div>
</div>
<div id="addFriendModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add Friend</h3><button id="addFriendmodalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <input type="text" id="friendSearchBar" class="search-input" placeholder="Search friends by name or email...">
            <div id="friendSearchResults" style="margin-top:16px;display:flex;flex-direction:column;gap:10px;"></div>
        </div>
    </div>
</div>
<div id="friendsRequestsModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Friend Requests</h3><button id="friendsRequestsModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            @if($pendingRequests->count() > 0)
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($pendingRequests as $request)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);">
                    <div style="flex:1;">
                        <div style="font-size:14px;font-weight:700;color:var(--white);">{{ $request->sender->name }}</div>
                        <div style="font-size:12px;color:var(--muted);">{{ $request->sender->email }}</div>
                    </div>
                    <button onclick="acceptFriendRequest('{{ $request->sender->id }}')" class="btn-gold" style="font-size:12px;padding:6px 12px;">Accept</button>
                </div>
                @endforeach
            </div>
            @else
            <p style="text-align:center;color:var(--muted);font-size:14px;margin:0;">No pending requests found.</p>
            @endif
        </div>
    </div>
</div>
@endsection