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

    let isShow = 1;

    document.addEventListener("DOMContentLoaded", () => {
        const friendSearchInput = document.getElementById("friend-search-input");
        friendSearchInput
            friendSearchInput.addEventListener("keydown", (e) => {
                             
        });
    });
  
    function toggleChat() {
        const body = document.getElementById('chat-body');
        const btn = document.getElementById('chat-toggle');
        if (!body || !btn) return;

        if (isShow === 1) {
            body.style.display = 'none';
            btn.textContent = '+';
            isShow = 0;
        } else {
            body.style.display = 'block';
            btn.textContent = '−';
            isShow = 1;
        }
    }
</script>
<style>
    .container { max-width: 1280px; margin: 0 auto; padding: 32px 24px; }
    .page-title { font-size: 22px; font-weight: 800; color: #111; margin-bottom: 24px; }
    .grid-layout { display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start; }
    .card { background: #fff; border-radius: 16px; border: 1.5px solid #E0E0E0; overflow: hidden; }
    .card-header { padding: 20px 24px; border-bottom: 1.5px solid #E0E0E0; display: flex; align-items: center; justify-content: space-between; }
    .card-header h2 { font-size: 15px; font-weight: 700; color: #111; }
    .card-body { padding: 24px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .offer-item { display: flex; flex-direction: column; border: 1.5px solid #E0E0E0; border-radius: 12px; overflow: hidden; transition: border-color .2s; }
    .offer-item:hover { border-color: #111; }
    .offer-item img { width: 100%; height: 150px; object-fit: cover; display: block; }
    .offer-item-body { padding: 14px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    .offer-name { font-size: 14px; font-weight: 700; color: #111; }
    .offer-desc { font-size: 12px; color: #8892A4; line-height: 1.5; }
    .offer-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 8px; }
    .btn-apply { padding: 8px 14px; background: #111; color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; }
    .btn-details { padding: 8px 14px; border: 1.5px solid #E0E0E0; border-radius: 8px; font-size: 12px; font-weight: 600; color: #111; text-decoration: none; }
    .chat-messages { height: calc(100vh - 280px); overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px; background: #F5F5F5; }
    .chat-input-area { padding: 16px; border-top: 1.5px solid #E0E0E0; display: flex; gap: 10px; }
    .chat-input { flex: 1; padding: 10px 14px; border: 1.5px solid #E0E0E0; border-radius: 10px; outline: none; background: #F5F5F5; }
    .btn-send { padding: 10px 18px; background: #111; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-active { color: #2e7d32; }
    @media (max-width: 900px) { .grid-layout { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-title">Lessor Dashboard</div>

    <div style="display:flex;gap:10px;margin-bottom:24px;">
        <a href="#" onclick="document.getElementById('add-friend-modal').style.display='flex';return false;" style="padding:10px 20px;background:#111;color:#fff;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:8px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Add Friend
        </a>
    </div>

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
                        @if($offer->local->image)
                        <img src="{{ $offer->local->image }}" alt="{{ $offer->local->name }}">
                        @endif
                        <div class="offer-item-body">
                            <span class="offer-name">{{ $offer->local->name }}</span>
                            <span class="offer-desc">{{ Str::limit($offer->local->description ?? $offer->local->type, 120) }}</span>
                            <div class="offer-actions">
                                <a href="{{ route('offer.details', $offer) }}" class="btn-details">Details</a>
                                <a href="{{ route('lessor.apply', $offer) }}" class="btn-apply">Apply</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="color:#8892A4;font-size:14px;text-align:center;padding:20px 0;">No available offers.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header">
                <h2>Group Chat</h2>
                <button id="chat-toggle" onclick="toggleChat()" style="width:28px;height:28px;border:1.5px solid #E0E0E0;border-radius:6px;background:#fff;cursor:pointer;">−</button>
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
            <div class="no-chat" style="padding:40px; text-align:center; color:#8892A4;">
                Join a local offer to access the group chat.
            </div>
            @endif
        </div>
    </div>
</div>

@vite(['resources/js/chat.js'])

<div id="add-friend-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:200;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:480px;overflow:hidden;">
        <div style="padding:20px 24px;border-bottom:1.5px solid #E0E0E0;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:15px;font-weight:700;">Add Friend</span>
            <button onclick="document.getElementById('add-friend-modal').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:20px;">&times;</button>
        </div>
        <div style="padding:20px 24px;">
            <input id="friend-search-input" type="text" placeholder="Search by name..." style="width:100%; padding:10px; border:1.5px solid #E0E0E0; border-radius:10px; outline:none;">
            <div id="friend-search-results" style="margin-top:16px;min-height:100px;"></div>
        </div>
    </div>
</div>
@endsection