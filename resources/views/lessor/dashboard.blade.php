@extends('layouts.app')

@section('title', 'Lessor Dashboard')

@section('head')
<script>
    window.chatConfig = {
        chatRoomId: {{ $chatRoom ? $chatRoom->id : 'null' }},
        currentUserId: {{ $user->id }},
        currentUserName: "{{ $user->name }}",
        csrfToken: "{{ csrf_token() }}"
    };
</script>
<style>
    .container { max-width: 1280px; margin: 0 auto; padding: 32px 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #111; margin-bottom: 24px; }
    .grid-layout { display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start; }
    .card { background: #fff; border-radius: 16px; border: 1.5px solid #E0E0E0; overflow: hidden; }
    .card-header { padding: 20px 24px; border-bottom: 1.5px solid #E0E0E0; display: flex; align-items: center; justify-content: space-between; }
    .card-header h2 { font-size: 15px; font-weight: 700; color: #111; }
    .card-body { padding: 24px; }
    .offer-item { display: flex; align-items: center; justify-content: space-between; padding: 16px; border: 1.5px solid #E0E0E0; border-radius: 12px; margin-bottom: 12px; transition: border-color .2s; }
    .offer-item:last-child { margin-bottom: 0; }
    .offer-item:hover { border-color: #111; }
    .offer-info { display: flex; flex-direction: column; gap: 4px; }
    .offer-id { font-size: 12px; color: #8892A4; font-weight: 500; }
    .offer-price { font-size: 16px; font-weight: 700; color: #111; }
    .offer-price span { font-size: 12px; font-weight: 500; color: #8892A4; }
    .btn-apply { padding: 8px 18px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; transition: opacity .2s; }
    .btn-apply:hover { opacity: .8; }
    .participation-card { background: #111; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
    .participation-label { font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
    .participation-offer { font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 4px; }
    .participation-sub { font-size: 13px; color: rgba(255,255,255,0.5); }
    .chat-messages { height: calc(100vh - 280px); overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px; background: #F5F5F5; }
    .chat-messages::-webkit-scrollbar { width: 4px; }
    .chat-messages::-webkit-scrollbar-thumb { background: #E0E0E0; border-radius: 4px; }
    .msg-row { display: flex; flex-direction: column; max-width: 75%; }
    .msg-row.mine { align-self: flex-end; align-items: flex-end; }
    .msg-row.theirs { align-self: flex-start; align-items: flex-start; }
    .msg-name { font-size: 11px; font-weight: 600; color: #8892A4; margin-bottom: 3px; }
    .msg-bubble { padding: 10px 14px; border-radius: 14px; font-size: 14px; line-height: 1.5; word-break: break-word; }
    .msg-row.mine .msg-bubble { background: #111; color: #fff; border-bottom-right-radius: 4px; }
    .msg-row.theirs .msg-bubble { background: #fff; color: #111; border: 1.5px solid #E0E0E0; border-bottom-left-radius: 4px; }
    .msg-time { font-size: 10px; color: #8892A4; margin-top: 3px; }
    .chat-input-area { padding: 16px; border-top: 1.5px solid #E0E0E0; display: flex; gap: 10px; }
    .chat-input { flex: 1; padding: 10px 14px; border: 1.5px solid #E0E0E0; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; outline: none; transition: border-color .2s; background: #F5F5F5; }
    .chat-input:focus { border-color: #111; background: #fff; }
    .btn-send { padding: 10px 18px; background: #111; color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .2s; }
    .btn-send:hover { opacity: .8; }
    .no-chat { padding: 40px 24px; text-align: center; color: #8892A4; font-size: 14px; }
    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-active { background: #e8f5e9; color: #2e7d32; }
    @media (max-width: 900px) { .grid-layout { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-title">Lessor Dashboard</div>

    <div class="grid-layout">
        <div>
            <div class="card">
                <div class="card-header">
                    <h2>Available Offers</h2>
                    <span class="badge badge-active">{{ $availableOffers->count() }} available</span>
                </div>
                <div class="card-body">
                    @forelse($availableOffers as $offer)
                    <div class="offer-item">
                        <div class="offer-info">
                            <span class="offer-id">Offer #{{ $offer->id }}</span>
                            <span class="offer-price">{{ $offer->totalPrice }} MAD <span>/ total</span></span>
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <a href="{{ route('offer.details', $offer) }}" style="padding:8px 14px;border:1.5px solid #E0E0E0;border-radius:8px;font-size:13px;font-weight:600;color:#111;text-decoration:none;">Details</a>
                            <a href="{{ route('lessor.apply', $offer) }}" class="btn-apply">Apply</a>
                        </div>
                    </div>
                    @empty
                    <p style="color:#8892A4;font-size:14px;text-align:center;padding:20px 0;">No available offers at the moment.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header">
                <h2>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:-2px;margin-right:6px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Group Chat
                </h2>
                @if($chatRoom)
                <span class="badge badge-active">● Live</span>
                @endif
            </div>

            @if($chatRoom)
            <div id="chat-messages" class="chat-messages"></div>
            <div class="chat-input-area">
                <input type="text" id="message-input" class="chat-input" placeholder="Type a message...">
                <button type="button" id="send-btn" class="btn-send">Send</button>
            </div>
            @else
            <div class="no-chat">
                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Join a local offer to access the group chat.
            </div>
            @endif
        </div>

    </div>
</div>
@vite(['resources/js/chat.js'])
@endsection
