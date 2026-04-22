@extends('layouts.app')
@section('title', 'Lessor Dashboard')
@section('head')
<link href="https://fonts.bunny.net/css?family=antonio:400,500,600,700&family=barlow-condensed:400,500,600,700,800,900&family=barlow:400,500,600" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.chatConfig={chatRoomId:"{{ $chatRoom ? $chatRoom->id : '' }}"||null,currentUserId:"{{ $user->id }}",currentUserName:"{{ $user->name }}",localOfferId:"{{ $currentLocalOffer ? $currentLocalOffer->id : '' }}"||null,csrfToken:"{{ csrf_token() }}"};let socket,isShow=1,messages=[];function connectWebSocket(){const{currentUserId,currentUserName,chatRoomId}=window.chatConfig,messagesDiv=document.getElementById('chat-messages');if(!chatRoomId||!messagesDiv)return;socket=new WebSocket('ws://localhost:8080');socket.onopen=()=>{socket.send(JSON.stringify({type:'join',chat_room_id:chatRoomId,sender_id:currentUserId,sender_name:currentUserName}))};socket.onmessage=event=>{try{const data=JSON.parse(event.data);if(data.type==='history'){messages=data.messages||[];messagesDiv.innerHTML='';messages.forEach(msg=>renderMessage(msg));messagesDiv.scrollTop=messagesDiv.scrollHeight}if(data.type==='message'){messages.push(data.message);renderMessage(data.message);messagesDiv.scrollTop=messagesDiv.scrollHeight}}catch(e){console.error('Error parsing message:',e)}};socket.onclose=()=>{setTimeout(connectWebSocket,3000)};socket.onerror=error=>{console.error('WebSocket error:',error);socket.close()}}function renderMessage(msg){const{currentUserId}=window.chatConfig,messagesDiv=document.getElementById('chat-messages');if(!messagesDiv)return;const isMine=Number(msg.sender_id)===Number(currentUserId),name=isMine?'You':(msg.sender_name??'Unknown'),messageDate=new Date(msg.created_at),time=messageDate.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}),bubble=document.createElement('div');bubble.className=`msg-bubble-wrapper ${isMine?'msg-mine':'msg-theirs'}`;bubble.innerHTML=`<div class="msg-meta"><span class="msg-name">${name}</span><span class="msg-time">${time}</span></div><div class="msg-content">${msg.content}</div>`;messagesDiv.appendChild(bubble)}function sendMessage(){const{currentUserId,chatRoomId}=window.chatConfig,input=document.getElementById('message-input');if(!socket||socket.readyState!==WebSocket.OPEN){console.warn('WebSocket not connected');return}const content=input.value.trim();if(!content)return;socket.send(JSON.stringify({type:'message',chat_room_id:chatRoomId,content:content}));input.value=''}function toggleChat(){const body=document.getElementById('chat-body'),btn=document.getElementById('chat-toggle');if(!body)return;if(isShow===1){body.style.display='none';btn.textContent='+';isShow=0}else{body.style.display='block';btn.textContent='−';isShow=1}}function openModal(id){const el=document.getElementById(id);if(el){el.style.display='flex';if(id==='inviteModal'){let resultsContainer=document.getElementById("inviteSearchResults");if(resultsContainer&&resultsContainer.innerHTML===''){$.ajax({url:"{{ route('friends.accepted.search') }}",type:"GET",data:{query:''},success:function(friends){resultsContainer.innerHTML="";if(friends.length===0){resultsContainer.innerHTML='<p style="color:var(--muted);font-size:14px;text-align:center;">No accepted friends found.</p>';return}friends.forEach(friend=>{resultsContainer.innerHTML+=`<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);"><div><div style="font-size:14px;font-weight:700;color:var(--white);">${friend.name}</div><div style="font-size:12px;color:var(--muted);">${friend.email}</div></div><button onclick="sendInvite(this, ${friend.id})" class="btn-gold" style="font-size:12px;padding:6px 12px;">Invite</button></div>`})},error:function(){resultsContainer.innerHTML='<p style="color:red;font-size:13px;">Error loading friends.</p>'}})}}}}function closeModal(id){const el=document.getElementById(id);if(el)el.style.display='none'}function sendFriendRequest(userId){$.ajax({url:"{{ route('friendships.send')}}",type:"POST",data:{receiver_id:userId,_token:"{{ csrf_token() }}"},success:function(response){location.reload()},error:function(xhr){location.reload()}})}function acceptFriendRequest(senderId){$.ajax({url:"{{ route('friendships.accept')}}",type:"POST",data:{sender_id:senderId,_token:"{{ csrf_token() }}"},success:function(response){location.reload()},error:function(xhr){location.reload()}})}function sendInvite(button,friendId){const{localOfferId,csrfToken}=window.chatConfig;if(!localOfferId)return;$.ajax({url:"{{ route('invites.send') }}",type:"POST",data:{receiver_id:friendId,local_offer_id:localOfferId,_token:csrfToken},complete:function(response){button.textContent='✓';button.disabled=true;button.style.cursor='not-allowed';button.style.opacity='0.6'}})}document.addEventListener('DOMContentLoaded',()=>{connectWebSocket();const btn=document.getElementById('send-btn'),input=document.getElementById('message-input');if(btn)btn.addEventListener('click',sendMessage);if(input)input.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();sendMessage()}});let addFriendBtn=document.getElementById("addFriendBtn"),friendReqBtn=document.getElementById("friendRequest"),closeAddFriend=document.getElementById("addFriendmodalClose"),closeReqFriend=document.getElementById("friendsRequestsModalClose"),inviteModalClose=document.getElementById("inviteModalClose"),participantsModalClose=document.getElementById("participantsModalClose"),friendSearchBar=document.getElementById("friendSearchBar"),inviteSearchBar=document.getElementById("inviteSearchBar");if(friendSearchBar){friendSearchBar.addEventListener("input",(e)=>{let userInput=friendSearchBar.value.trim(),resultsContainer=document.getElementById("friendSearchResults");if(userInput){$.ajax({url:"{{ route('users.search') }}",type:"GET",data:{query:userInput},success:function(users){resultsContainer.innerHTML="";if(users.length===0){resultsContainer.innerHTML='<p style="color:var(--muted);font-size:14px;text-align:center;">No users found.</p>';return}users.forEach(user=>{if(user.id===window.chatConfig.currentUserId)return;let buttonHTML='';if(user.friendship_status==='accepted'){buttonHTML='<button class="btn-gold" style="font-size:12px;padding:6px 12px;cursor:not-allowed;opacity:0.5;" disabled>👥</button>'}else if(user.friendship_status==='pending'){buttonHTML='<button class="btn-gold" style="font-size:12px;padding:6px 12px;cursor:not-allowed;opacity:0.5;" disabled>✓</button>'}else if(user.friendship_status==='rejected'){buttonHTML='<button class="btn-gold" style="font-size:12px;padding:6px 12px;cursor:not-allowed;opacity:0.5;" disabled>✕</button>'}else{buttonHTML='<button onclick="sendFriendRequest('+user.id+')" class="btn-gold" style="font-size:12px;padding:6px 12px;">Add</button>'}resultsContainer.innerHTML+=`<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);"><div><div style="font-size:14px;font-weight:700;color:var(--white);">${user.name}</div><div style="font-size:12px;color:var(--muted);">${user.email}</div></div>${buttonHTML}</div>`})},error:function(){resultsContainer.innerHTML='<p style="color:red;font-size:13px;">Error searching users.</p>'}})}else{resultsContainer.innerHTML=""}})}if(inviteSearchBar){inviteSearchBar.addEventListener("input",(e)=>{let userInput=inviteSearchBar.value.trim(),resultsContainer=document.getElementById("inviteSearchResults");$.ajax({url:"{{ route('friends.accepted.search') }}",type:"GET",data:{query:userInput},success:function(friends){resultsContainer.innerHTML="";if(friends.length===0){resultsContainer.innerHTML='<p style="color:var(--muted);font-size:14px;text-align:center;">No accepted friends found.</p>';return}friends.forEach(friend=>{if(friend.id===window.chatConfig.currentUserId)return;resultsContainer.innerHTML+=`<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);"><div><div style="font-size:14px;font-weight:700;color:var(--white);">${friend.name}</div><div style="font-size:12px;color:var(--muted);">${friend.email}</div></div><button onclick="sendInvite(this, ${friend.id})" class="btn-gold" style="font-size:12px;padding:6px 12px;">Invite</button></div>`})},error:function(){resultsContainer.innerHTML='<p style="color:red;font-size:13px;">Error searching friends.</p>'}})})}if(addFriendBtn)addFriendBtn.addEventListener("click",()=>openModal('addFriendModal'));if(friendReqBtn)friendReqBtn.addEventListener("click",()=>openModal('friendsRequestsModal'));if(closeAddFriend)closeAddFriend.addEventListener("click",()=>closeModal('addFriendModal'));if(closeReqFriend)closeReqFriend.addEventListener("click",()=>closeModal('friendsRequestsModal'));if(inviteModalClose)inviteModalClose.addEventListener("click",()=>closeModal('inviteModal'));if(participantsModalClose)participantsModalClose.addEventListener("click",()=>closeModal('participantsModal'));@if($currentLocalOffer && $currentLocalOffer->endTime)const endTimeStr="{{ $currentLocalOffer->endTime }}",endTime=new Date(endTimeStr).getTime();let isOfferCompleted=false;function updateTimer(){const now=new Date().getTime(),distance=endTime-now,timerElement=document.getElementById('offerTimer');if(distance<=0){timerElement.textContent="00:00:00";if(!isOfferCompleted){isOfferCompleted=true;$.ajax({url:"{{ route('offers.complete', $currentLocalOffer->id) }}",type:"POST",data:{_token:"{{ csrf_token() }}"},success:function(response){setTimeout(()=>location.reload(),1000)},error:function(xhr){console.error('Error completing offer')}})}return}const hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60)),minutes=Math.floor((distance%(1000*60*60))/(1000*60)),seconds=Math.floor((distance%(1000*60))/1000);timerElement.textContent=`${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`}setInterval(updateTimer,1000);@endif});
</script>
<style>
:root{--gold:#C9A84C;--gold-bright:#F0C040;--gold-dim:rgba(201,168,76,0.12);--gold-line:rgba(201,168,76,0.35);--black:#060608;--dark:#0D0D10;--panel:#12121A;--panel2:#1A1A26;--white:#FFFFFF;--muted:rgba(255,255,255,0.38);--green:#00C853}*{box-sizing:border-box;margin:0;padding:0}body{background:var(--black)}.dashboard-page{min-height:calc(100vh - 65px);background:var(--black);font-family:'Barlow Condensed',sans-serif;position:relative;overflow:hidden}.beams{position:fixed;top:-10%;left:50%;transform:translateX(-50%);width:120%;height:80vh;pointer-events:none;z-index:0}.beam{position:absolute;top:0;transform-origin:top center;opacity:0;animation:beamSweep 8s infinite ease-in-out}.beam::after{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:200px;height:70vh;background:linear-gradient(180deg,rgba(201,168,76,0.18) 0%,transparent 75%);clip-path:polygon(50% 0%,100% 100%,0% 100%)}.beam:nth-child(1){left:18%;animation-delay:0s;animation-duration:7s}.beam:nth-child(2){left:33%;animation-delay:1.5s;animation-duration:9s}.beam:nth-child(3){left:50%;animation-delay:0.8s;animation-duration:8s}.beam:nth-child(4){left:67%;animation-delay:2.2s;animation-duration:7.5s}.beam:nth-child(5){left:82%;animation-delay:0.4s;animation-duration:10s}@keyframes beamSweep{0%{opacity:0;transform:rotate(-18deg)}20%{opacity:1}50%{opacity:0.55;transform:rotate(18deg)}80%{opacity:1}100%{opacity:0;transform:rotate(-18deg)}}.stripe-bg{position:fixed;inset:0;background-image:repeating-linear-gradient(-55deg,transparent,transparent 40px,rgba(201,168,76,0.018) 40px,rgba(201,168,76,0.018) 41px);pointer-events:none;z-index:0}.dashboard-inner{position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:52px 28px 100px}.dash-header{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;margin-bottom:40px;animation:revealUp 0.7s ease both}.hdr-line{height:1px;background:linear-gradient(90deg,transparent,var(--gold-line))}.hdr-line.r{background:linear-gradient(90deg,var(--gold-line),transparent)}.hdr-center{text-align:center;padding:0 36px}.hdr-eyebrow{display:block;font-size:10px;font-weight:700;letter-spacing:5px;text-transform:uppercase;color:var(--gold);margin-bottom:8px}.hdr-title{font-family:'Antonio',sans-serif;font-size:clamp(28px,5vw,48px);font-weight:700;color:var(--white);text-transform:uppercase;letter-spacing:-1px;line-height:1}.hdr-title span{color:var(--gold-bright)}.action-bar{display:flex;gap:10px;margin-bottom:32px;animation:revealUp 0.7s 0.1s ease both}.btn-gold{padding:10px 18px;background:var(--gold);color:#000;border:none;border-radius:3px;font-family:'Barlow Condensed',sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:all 0.25s}.btn-gold:hover{background:var(--gold-bright);box-shadow:0 4px 20px rgba(201,168,76,0.3)}.grid-layout{display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start}.card{background:var(--panel);border:1px solid rgba(255,255,255,0.07);border-radius:3px;overflow:hidden;animation:revealUp 0.6s 0.2s ease both;transition:border-color 0.3s}.card:hover{border-color:var(--gold-line)}.card-header{padding:18px 20px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between}.card-header h2{font-family:'Antonio',sans-serif;font-size:13px;font-weight:600;letter-spacing:3px;text-transform:uppercase;color:var(--white);margin:0}.card-badge{font-size:10px;font-weight:700;letter-spacing:2px;color:var(--gold)}.card-body{padding:20px;display:grid;grid-template-columns:repeat(2,1fr);gap:14px}.offer-item{display:flex;flex-direction:column;border:1px solid rgba(255,255,255,0.07);border-radius:3px;overflow:hidden;transition:all 0.25s;cursor:pointer}.offer-item:hover{border-color:var(--gold);transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,0.5)}.offer-item img{width:100%;height:140px;object-fit:cover}.offer-item-body{padding:14px;display:flex;flex-direction:column;gap:8px;flex:1;background:var(--panel2)}.offer-name{font-size:13px;font-weight:700;letter-spacing:1px;color:var(--white)}.offer-desc{font-size:11px;color:var(--muted);line-height:1.5}.offer-actions{display:flex;gap:8px;margin-top:auto;padding-top:8px}.btn-details{padding:7px 12px;border:1px solid rgba(255,255,255,0.14);border-radius:2px;font-size:10px;font-weight:700;letter-spacing:1px;color:var(--muted);text-decoration:none;text-align:center;transition:all 0.2s;text-transform:uppercase}.btn-details:hover{border-color:var(--gold);color:var(--gold);background:var(--gold-dim)}.btn-apply{padding:7px 12px;background:var(--gold);color:#000;border:none;border-radius:2px;font-size:10px;font-weight:700;letter-spacing:1px;cursor:pointer;text-decoration:none;text-align:center;transition:all 0.2s;text-transform:uppercase}.btn-apply:hover{background:var(--gold-bright)}.offer-img{width:100%;height:280px;object-fit:cover}.offer-timer-bar{padding:16px 24px;background:linear-gradient(135deg,rgba(201,168,76,0.15),rgba(201,168,76,0.05));border-bottom:1px solid var(--gold-line);text-align:center}.offer-timer{font-family:'Antonio',sans-serif;color:var(--gold-bright);font-weight:700;font-size:24px;letter-spacing:2px;text-shadow:0 0 15px rgba(240,192,64,0.4)}.offer-info{padding:24px}.offer-title{font-family:'Antonio',sans-serif;font-size:22px;font-weight:700;color:var(--white);margin:0 0 12px 0;letter-spacing:-0.5px}.offer-subtitle{color:var(--muted);font-size:13px;line-height:1.6;margin:0 0 20px 0}.offer-btns{display:flex;gap:10px}.offer-btns .btn-gold{flex:1;font-size:11px}.chat-card{position:sticky;top:80px;animation:revealUp 0.6s 0.3s ease both}.chat-toggle{width:28px;height:28px;border:1px solid rgba(255,255,255,0.14);border-radius:3px;background:var(--panel2);color:var(--white);font-size:16px;font-weight:700;cursor:pointer;transition:all 0.2s}.chat-toggle:hover{border-color:var(--gold);background:var(--gold-dim)}.chat-messages{height:calc(100vh - 340px);overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:8px;background:var(--dark)}.msg-bubble-wrapper{display:flex;flex-direction:column;margin-bottom:4px;animation:msgPop 0.3s ease}@keyframes msgPop{from{opacity:0;transform:scale(0.9)}to{opacity:1;transform:scale(1)}}.msg-bubble-wrapper.msg-mine{align-items:flex-end}.msg-bubble-wrapper.msg-theirs{align-items:flex-start}.msg-meta{display:flex;gap:6px;align-items:center;font-size:10px;margin-bottom:4px}.msg-mine .msg-meta{flex-direction:row-reverse}.msg-name{font-weight:600;color:var(--gold)}.msg-time{font-size:9px;color:var(--muted)}.msg-content{padding:9px 13px;border-radius:3px;max-width:90%;word-wrap:break-word;font-size:13px;line-height:1.4}.msg-mine .msg-content{background:var(--gold);color:#000}.msg-theirs .msg-content{background:var(--panel2);color:var(--white);border:1px solid rgba(255,255,255,0.07)}.chat-input-area{padding:12px;border-top:1px solid rgba(255,255,255,0.05);display:flex;gap:8px;background:var(--panel)}.chat-input{flex:1;padding:10px 12px;border:1px solid rgba(255,255,255,0.14);border-radius:3px;font-size:12px;outline:none;background:var(--panel2);color:var(--white);font-family:'Barlow Condensed',sans-serif}.chat-input:focus{border-color:var(--gold)}.btn-send{padding:10px 16px;background:var(--gold);color:#000;border:none;border-radius:3px;font-size:11px;font-weight:700;cursor:pointer;white-space:nowrap;letter-spacing:1px;text-transform:uppercase;transition:all 0.2s}.btn-send:hover{background:var(--gold-bright)}.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.75);display:none;align-items:center;justify-content:center;z-index:1000;backdrop-filter:blur(4px)}.modal-content{background:var(--panel);border:1px solid var(--gold-line);border-radius:3px;width:90%;max-width:500px;overflow:hidden;animation:modalPop 0.3s ease}@keyframes modalPop{from{opacity:0;transform:scale(0.9)}to{opacity:1;transform:scale(1)}}.modal-header{padding:18px 20px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between}.modal-header h3{font-family:'Antonio',sans-serif;font-size:13px;font-weight:600;letter-spacing:3px;text-transform:uppercase;color:var(--white);margin:0}.modal-body{padding:20px}.modal-close{background:none;border:none;font-size:24px;cursor:pointer;color:var(--muted);transition:color 0.2s}.modal-close:hover{color:var(--gold)}.search-input{width:100%;padding:12px 16px;border:1px solid rgba(255,255,255,0.14);border-radius:3px;outline:none;font-size:13px;box-sizing:border-box;background:var(--panel2);color:var(--white);font-family:'Barlow Condensed',sans-serif}.search-input:focus{border-color:var(--gold)}.search-input::placeholder{color:var(--muted)}@keyframes revealUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}@media (max-width:900px){.grid-layout{grid-template-columns:1fr}.dash-header{grid-template-columns:1fr}.hdr-line{display:none}.card-body{grid-template-columns:1fr}}
</style>
@endsection
@section('content')
<div class="dashboard-page">
<div class="beams"><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div><div class="beam"></div></div>
<div class="stripe-bg"></div>
<div class="dashboard-inner">
<div class="dash-header"><div class="hdr-line"></div><div class="hdr-center"><span class="hdr-eyebrow">Smart Organizer</span><div class="hdr-title">Lessor <span>Dashboard</span></div></div><div class="hdr-line r"></div></div>
<div class="action-bar"><button type="button" id="addFriendBtn" class="btn-gold">Add Friend</button><button type="button" id="friendRequest" class="btn-gold">Friend Requests</button></div>
<div class="grid-layout">
<div>
@if($userCurrentParticipation && $currentLocalOffer)
<div class="card">
@if($currentLocalOffer->local->image)
<img src="{{ $currentLocalOffer->local->image }}" alt="{{ $currentLocalOffer->local->name }}" class="offer-img">
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
<div class="card-header"><h2>Available Offers</h2><span class="card-badge">{{ $availableOffers->count() }} available</span></div>
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
<p style="color:var(--muted);font-size:14px;text-align:center;padding:20px 0;grid-column:span 2;">No available offers at the moment.</p>
@endforelse
</div>
</div>
@endif
</div>
<div class="card chat-card">
<div class="card-header"><h2>Group Chat</h2><button id="chat-toggle" onclick="toggleChat()" class="chat-toggle">−</button></div>
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
<div class="modal-header"><h3>Participants ({{ $participantsCount }})</h3><button id="participantsModalClose" class="modal-close">&times;</button></div>
<div class="modal-body">
<div style="display:flex;flex-direction:column;gap:12px;">
@foreach($participants as $participant)
@if($participant['id'] !== $user->id)
<div style="display:flex;align-items:center;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);">
<div style="flex:1;"><div style="font-size:14px;font-weight:700;color:var(--white);">{{ $participant['name'] }}</div><div style="font-size:12px;color:var(--muted);">{{ $participant['email'] }}</div></div>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
<div id="inviteModal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header"><h3>Invite Friends</h3><button id="inviteModalClose" class="modal-close">&times;</button></div>
<div class="modal-body">
<input type="text" id="inviteSearchBar" class="search-input" placeholder="Search friends to invite...">
<div id="inviteSearchResults" style="margin-top:16px;display:flex;flex-direction:column;gap:10px;"></div>
</div>
</div>
</div>
<div id="addFriendModal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header"><h3>Add Friend</h3><button id="addFriendmodalClose" class="modal-close">&times;</button></div>
<div class="modal-body">
<input type="text" id="friendSearchBar" class="search-input" placeholder="Search friends by name or email...">
<div id="friendSearchResults" style="margin-top:16px;display:flex;flex-direction:column;gap:10px;"></div>
</div>
</div>
</div>
<div id="friendsRequestsModal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header"><h3>Friend Requests</h3><button id="friendsRequestsModalClose" class="modal-close">&times;</button></div>
<div class="modal-body">
@if($pendingRequests->count() > 0)
<div style="display:flex;flex-direction:column;gap:12px;">
@foreach($pendingRequests as $request)
<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border:1px solid var(--gold-line);border-radius:3px;background:var(--panel2);">
<div style="flex:1;"><div style="font-size:14px;font-weight:700;color:var(--white);">{{ $request->sender->name }}</div><div style="font-size:12px;color:var(--muted);">{{ $request->sender->email }}</div></div>
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
@vite(['resources/js/chat.js'])
@endsection
