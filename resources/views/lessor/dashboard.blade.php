@extends('layouts.app')

@section('title', 'Lessor Dashboard')

@section('head')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    window.chatConfig = {
        chatRoomId: {{ $chatRoom ? $chatRoom->id : 'null' }},
        currentUserId: {{ $user->id }},
        currentUserName: "{{ $user->name }}",
        localOfferId: {{ $currentLocalOffer ? $currentLocalOffer->id : 'null' }},
        csrfToken: "{{ csrf_token() }}"
    };

    let socket;
    let isShow = 1;
    let messages = [];

    function connectWebSocket() {
        const {
            currentUserId,
            currentUserName,
            chatRoomId
        } = window.chatConfig;
        const messagesDiv = document.getElementById('chat-messages');

        if (!chatRoomId || !messagesDiv) return;

        socket = new WebSocket('ws://localhost:8080');

        socket.onopen = () => {
            socket.send(JSON.stringify({
                type: 'join',
                chat_room_id: chatRoomId,
                sender_id: currentUserId,
                sender_name: currentUserName,
            }));
        };

        socket.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                if (data.type === 'history') {
                    messages = data.messages || [];
                    messagesDiv.innerHTML = '';
                    messages.forEach(msg => renderMessage(msg));
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
                if (data.type === 'message') {
                    messages.push(data.message);
                    renderMessage(data.message);
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
            } catch (e) {
                console.error('Error parsing message:', e);
            }
        };

        socket.onclose = () => {
            setTimeout(connectWebSocket, 3000);
        };

        socket.onerror = (error) => {
            console.error('WebSocket error:', error);
            socket.close();
        };
    }

    function renderMessage(msg) {
        const {
            currentUserId
        } = window.chatConfig;
        const messagesDiv = document.getElementById('chat-messages');
        if (!messagesDiv) return;

        const isMine = Number(msg.sender_id) === Number(currentUserId);
        const name = isMine ? 'You' : (msg.sender_name ?? 'Unknown');
        const messageDate = new Date(msg.created_at);
        const time = messageDate.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        const bubble = document.createElement('div');
        bubble.className = `msg-bubble-wrapper ${isMine ? 'msg-mine' : 'msg-theirs'}`;
        bubble.innerHTML = `
            <div class="msg-meta">
                <span class="msg-name">${name}</span>
                <span class="msg-time">${time}</span>
            </div>
            <div class="msg-content">${msg.content}</div>
        `;
        messagesDiv.appendChild(bubble);
    }

    function sendMessage() {
        const {
            currentUserId,
            chatRoomId
        } = window.chatConfig;
        const input = document.getElementById('message-input');

        if (!socket || socket.readyState !== WebSocket.OPEN) {
            console.warn('WebSocket not connected');
            return;
        }

        const content = input.value.trim();
        if (!content) return;

        socket.send(JSON.stringify({
            type: 'message',
            chat_room_id: chatRoomId,
            content: content
        }));

        input.value = '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        connectWebSocket();

        const btn = document.getElementById('send-btn');
        const input = document.getElementById('message-input');

        if (btn) btn.addEventListener('click', sendMessage);
        if (input) input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
    });

    function toggleChat() {
        const body = document.getElementById('chat-body');
        const btn = document.getElementById('chat-toggle');
        if (!body) return;
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

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = 'flex';
            if (id === 'inviteModal') {
                let resultsContainer = document.getElementById("inviteSearchResults");
                if (resultsContainer && resultsContainer.innerHTML === '') {
                    $.ajax({
                        url: "{{ route('friends.accepted.search') }}",
                        type: "GET",
                        data: {
                            query: ''
                        },
                        success: function(friends) {
                            resultsContainer.innerHTML = "";
                            if (friends.length === 0) {
                                resultsContainer.innerHTML = '<p style="color:#8892A4;font-size:14px;text-align:center;">No accepted friends found.</p>';
                                return;
                            }
                            friends.forEach(friend => {
                                resultsContainer.innerHTML += `
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1.5px solid #E0E0E0;border-radius:10px;">
                                        <div>
                                            <div style="font-size:14px;font-weight:700;color:#111;">${friend.name}</div>
                                            <div style="font-size:12px;color:#8892A4;">${friend.email}</div>
                                        </div>
                                        <button onclick="sendInvite(this, ${friend.id})" class="btn-apply" style="font-size:12px;">Invite</button>
                                    </div>`;
                            });
                        },
                        error: function() {
                            resultsContainer.innerHTML = '<p style="color:red;font-size:13px;">Error loading friends.</p>';
                        }
                    });
                }
            }
        }
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }

    function sendFriendRequest(userId) {
        $.ajax({
            url: "{{ route('friendships.send')}}",
            type: "POST",
            data: {
                receiver_id: userId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                location.reload();
            }
        });
    }

    function acceptFriendRequest(senderId) {
        $.ajax({
            url: "{{ route('friendships.accept')}}",
            type: "POST",
            data: {
                sender_id: senderId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                location.reload();
            }
        });
    }

    function sendInvite(button, friendId) {
        const { localOfferId, csrfToken } = window.chatConfig;

        if (!localOfferId) {
            return;
        }

        $.ajax({
            url: "{{ route('invites.send') }}",
            type: "POST",
            data: {
                receiver_id: friendId,
                local_offer_id: localOfferId,
                _token: csrfToken
            },
            complete: function(response) {
                button.textContent = '✓';
                button.disabled = true;
                button.style.cursor = 'not-allowed';
                button.style.opacity = '0.8';
                button.style.backgroundColor = '#2e7d32';
                button.style.color = '#ffffff';
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        let addFriendBtn = document.getElementById("addFriendBtn");
        let friendReqBtn = document.getElementById("friendRequest");
        let closeAddFriend = document.getElementById("addFriendmodalClose");
        let closeReqFriend = document.getElementById("friendsRequestsModalClose");
        let inviteModalClose = document.getElementById("inviteModalClose");
        let participantsModalClose = document.getElementById("participantsModalClose");
        let friendSearchBar = document.getElementById("friendSearchBar");
        let inviteSearchBar = document.getElementById("inviteSearchBar");

        if (friendSearchBar) {
            friendSearchBar.addEventListener("input", (e) => {
                let userInput = friendSearchBar.value.trim();
                let resultsContainer = document.getElementById("friendSearchResults");

                if (userInput) {
                    $.ajax({
                        url: "{{ route('users.search') }}",
                        type: "GET",
                        data: {
                            query: userInput
                        },
                        success: function(users) {
                            resultsContainer.innerHTML = "";
                            if (users.length === 0) {
                                resultsContainer.innerHTML = '<p style="color:#8892A4;font-size:14px;text-align:center;">No users found.</p>';
                                return;
                            }
                            users.forEach(user => {
                                if (user.id === window.chatConfig.currentUserId) return;
                                let buttonHTML = '';
                                if (user.friendship_status === 'accepted') {
                                    buttonHTML = '<button class="btn-apply" style="font-size:12px;cursor:not-allowed;" disabled>👥</button>';
                                } else if (user.friendship_status === 'pending') {
                                    buttonHTML = '<button class="btn-apply" style="font-size:12px;cursor:not-allowed;" disabled>✓</button>';
                                } else if (user.friendship_status === 'rejected') {
                                    buttonHTML = '<button class="btn-apply" style="font-size:12px;cursor:not-allowed;" disabled>✕</button>';
                                } else {
                                    buttonHTML = '<button onclick="sendFriendRequest(' + user.id + ')" class="btn-apply" style="font-size:12px;">Add</button>';
                                }
                                resultsContainer.innerHTML += `
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1.5px solid #E0E0E0;border-radius:10px;">
                                        <div>
                                            <div style="font-size:14px;font-weight:700;color:#111;">${user.name}</div>
                                            <div style="font-size:12px;color:#8892A4;">${user.email}</div>
                                        </div>
                                        ${buttonHTML}
                                    </div>`;
                            });
                        },
                        error: function() {
                            resultsContainer.innerHTML = '<p style="color:red;font-size:13px;">Error searching users.</p>';
                        }
                    });
                } else {
                    resultsContainer.innerHTML = "";
                }
            });
        }

        if (inviteSearchBar) {
            inviteSearchBar.addEventListener("input", (e) => {
                let userInput = inviteSearchBar.value.trim();
                let resultsContainer = document.getElementById("inviteSearchResults");

                $.ajax({
                    url: "{{ route('friends.accepted.search') }}",
                    type: "GET",
                    data: {
                        query: userInput
                    },
                    success: function(friends) {
                        resultsContainer.innerHTML = "";
                        if (friends.length === 0) {
                            resultsContainer.innerHTML = '<p style="color:#8892A4;font-size:14px;text-align:center;">No accepted friends found.</p>';
                            return;
                        }
                        friends.forEach(friend => {
                            if (friend.id === window.chatConfig.currentUserId) return;
                            resultsContainer.innerHTML += `
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1.5px solid #E0E0E0;border-radius:10px;">
                                    <div>
                                        <div style="font-size:14px;font-weight:700;color:#111;">${friend.name}</div>
                                        <div style="font-size:12px;color:#8892A4;">${friend.email}</div>
                                    </div>
                                    <button onclick="sendInvite(this, ${friend.id})" class="btn-apply" style="font-size:12px;">Invite</button>
                                </div>`;
                        });
                    },
                    error: function() {
                        resultsContainer.innerHTML = '<p style="color:red;font-size:13px;">Error searching friends.</p>';
                    }
                });
            });
        }

        if (addFriendBtn) addFriendBtn.addEventListener("click", () => openModal('addFriendModal'));
        if (friendReqBtn) friendReqBtn.addEventListener("click", () => openModal('friendsRequestsModal'));
        if (closeAddFriend) closeAddFriend.addEventListener("click", () => closeModal('addFriendModal'));
        if (closeReqFriend) closeReqFriend.addEventListener("click", () => closeModal('friendsRequestsModal'));
        if (inviteModalClose) inviteModalClose.addEventListener("click", () => closeModal('inviteModal'));
        if (participantsModalClose) participantsModalClose.addEventListener("click", () => closeModal('participantsModal'));
        const timerElement = document.getElementById('offerTimer');
        @if($currentLocalOffer && $currentLocalOffer->endTime)
        const endTime = new Date("{{ $currentLocalOffer->endTime }}").getTime();
        
        function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;
            
            if (distance < 0) {
                timerElement.textContent = "Expired";
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timerElement.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }
        updateTimer();
        setInterval(updateTimer, 1000);
        @endif
    });
</script>

<style>
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 32px 24px;
        font-family: sans-serif;
    }

    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #111;
        margin-bottom: 24px;
    }

    .grid-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }

    .card {
        background: #fff;
        border-radius: 16px;
        border: 1.5px solid #E0E0E0;
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1.5px solid #E0E0E0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header h2 {
        font-size: 15px;
        font-weight: 700;
        color: #111;
        margin: 0;
    }

    .card-body {
        padding: 24px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .offer-item {
        display: flex;
        flex-direction: column;
        border: 1.5px solid #E0E0E0;
        border-radius: 12px;
        overflow: hidden;
    }

    .offer-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .offer-item-body {
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .offer-name {
        font-size: 14px;
        font-weight: 700;
        color: #111;
    }

    .offer-desc {
        font-size: 12px;
        color: #8892A4;
        line-height: 1.5;
    }

    .offer-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
        padding-top: 8px;
    }

    .btn-apply {
        padding: 8px 14px;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
    }

    .btn-details {
        padding: 8px 14px;
        border: 1.5px solid #E0E0E0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #111;
        text-decoration: none;
        text-align: center;
    }

    .chat-messages {
        height: calc(100vh - 340px);
        overflow-y: auto;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #F9F9F9;
    }

    .msg-bubble-wrapper {
        display: flex;
        flex-direction: column;
        margin-bottom: 4px;
    }

    .msg-bubble-wrapper.msg-mine {
        align-items: flex-end;
    }

    .msg-bubble-wrapper.msg-theirs {
        align-items: flex-start;
    }

    .msg-meta {
        display: flex;
        gap: 6px;
        align-items: center;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .msg-mine .msg-meta {
        flex-direction: row-reverse;
    }

    .msg-name {
        font-weight: 600;
        color: #555;
    }

    .msg-time {
        font-size: 10px;
        color: #9CA3AF;
    }

    .msg-content {
        padding: 8px 12px;
        border-radius: 10px;
        max-width: 90%;
        word-wrap: break-word;
        font-size: 13px;
        line-height: 1.4;
    }

    .msg-mine .msg-content {
        background: #111;
        color: #fff;
    }

    .msg-theirs .msg-content {
        background: #E0E0E0;
        color: #111;
    }

    .chat-input-area {
        padding: 12px;
        border-top: 1.5px solid #E0E0E0;
        display: flex;
        gap: 8px;
        background: #fff;
    }

    .chat-input {
        flex: 1;
        padding: 9px 12px;
        border: 1.5px solid #E0E0E0;
        border-radius: 8px;
        font-size: 13px;
        outline: none;
        resize: none;
        max-height: 60px;
    }

    .chat-input:focus {
        border-color: #111;
    }

    .btn-send {
        padding: 9px 16px;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-send:hover {
        background: #333;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        overflow: hidden;
    }

    .modal-header {
        padding: 20px 24px;
        border-bottom: 1.5px solid #E0E0E0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #8892A4;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #E0E0E0;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
        box-sizing: border-box;
    }

    @media (max-width: 900px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-title">Lessor Dashboard</div>
    <div style="display:flex;gap:10px;margin-bottom:24px;">
        <button type="button" id="addFriendBtn" class="btn-apply">Add Friend</button>
        <button type="button" id="friendRequest" class="btn-apply">Friend Requests</button>
    </div>

    <div class="grid-layout">
        <div>
            @if($userCurrentParticipation && $currentLocalOffer)
            <div class="card">
                <div style="position: relative; overflow: hidden;">
                    @if($currentLocalOffer->local->image)
                    <img src="{{ $currentLocalOffer->local->image }}" alt="{{ $currentLocalOffer->local->name }}" style="width: 100%; height: 280px; object-fit: cover;">
                    @else
                    <div style="width: 100%; height: 280px; background: #E0E0E0; display: flex; align-items: center; justify-content: center; color: #8892A4;">No image available</div>
                    @endif
                </div>
                @if($currentLocalOffer->endTime)
                <div style="padding: 16px 24px; background: #FFF3E0; border-bottom: 1.5px solid #E0E0E0; text-align: center;">
                    <span id="offerTimer" style="color: #FF4444; font-weight: 700; font-size: 20px;">--:--:--</span>
                </div>
                @endif
                <div style="padding: 28px 24px;">
                    <h2 style="font-size: 20px; font-weight: 800; color: #111; margin: 0 0 12px 0;">{{ $currentLocalOffer->local->name }}</h2>
                    <p style="color: #8892A4; font-size: 14px; line-height: 1.6; margin: 0 0 24px 0;">{{ $currentLocalOffer->local->description ?? $currentLocalOffer->local->type . ' · ' . $currentLocalOffer->local->city }}</p>
                    <div style="display: flex; gap: 12px;">
                        <button type="button" onclick="openModal('participantsModal')" class="btn-apply" style="flex: 1; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;">
                            <span>{{ $participantsCount }} {{ $participantsCount === 1 ? 'person' : 'people' }} joined</span>
                        </button>
                        <button type="button" onclick="openModal('inviteModal')" class="btn-apply" style="flex: 1; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <span>Invite</span>
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h2>Available Offers</h2>
                    <span style="color:#2e7d32;font-weight:600;font-size:11px;">{{ $availableOffers->count() }} available</span>
                </div>
                <div class="card-body">
                    @forelse($availableOffers as $offer)
                    <div class="offer-item">
                        @if($offer->local->image)
                        <img src="{{ $offer->local->image }}" alt="{{ $offer->local->name }}">
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
                    <p style="color:#8892A4;font-size:14px;text-align:center;padding:20px 0;grid-column:span 2;">No available offers at the moment.</p>
                    @endforelse
                </div>
            </div>
            @endif
        </div>

        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header">
                <h2>Group Chat</h2>
                <button id="chat-toggle" onclick="toggleChat()" style="width:28px;height:28px;border:1.5px solid #E0E0E0;border-radius:6px;background:#fff;font-size:16px;font-weight:700;cursor:pointer;">−</button>
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
            <div style="padding:40px;text-align:center;color:#8892A4;">Join a local offer to access the group chat.</div>
            @endif
        </div>
    </div>
</div>

<div id="participantsModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Participants ({{ $participantsCount }})</h3>
            <button id="participantsModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($participants as $participant)
                    @if($participant['id'] !== $user->id)
                    <div style="display: flex; align-items: center; padding: 12px 14px; border: 1.5px solid #E0E0E0; border-radius: 10px;">
                        <div style="flex: 1;">
                            <div style="font-size: 14px; font-weight: 700; color: #111;">{{ $participant['name'] }}</div>
                            <div style="font-size: 12px; color: #8892A4;">{{ $participant['email'] }}</div>
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
            <h3>Invite Friends</h3>
            <button id="inviteModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <input type="text" id="inviteSearchBar" class="search-input" placeholder="Search friends to invite...">
            <div id="inviteSearchResults" style="margin-top:16px;display:flex;flex-direction:column;gap:10px;"></div>
        </div>
    </div>
</div>

<div id="addFriendModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add Friend</h3>
            <button id="addFriendmodalClose" class="modal-close">&times;</button>
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
            <h3>Friend Requests</h3>
            <button id="friendsRequestsModalClose" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            @if($pendingRequests->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($pendingRequests as $request)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border: 1.5px solid #E0E0E0; border-radius: 10px;">
                    <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 700; color: #111;">{{ $request->sender->name }}</div>
                        <div style="font-size: 12px; color: #8892A4;">{{ $request->sender->email }}</div>
                    </div>
                    <button onclick="acceptFriendRequest({{ $request->sender->id }})" class="btn-apply" style="font-size: 12px;">Accept</button>
                </div>
                @endforeach
            </div>
            @else
            <p style="text-align: center; color: #8892A4; font-size: 14px; margin: 0;">No pending requests found.</p>
            @endif
        </div>
    </div>
</div>

@vite(['resources/js/chat.js'])
@endsection