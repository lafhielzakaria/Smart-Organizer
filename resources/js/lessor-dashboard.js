let socket,isShow=1,messages=[],renderedMessageIds=new Set();

window.openModal=function(id){
const el=document.getElementById(id);
if(el){
el.style.display='flex';
if(id==='inviteModal'){
let resultsContainer=document.getElementById("inviteSearchResults");
if(resultsContainer&&resultsContainer.innerHTML===''){
$.ajax({
url:window.chatConfig.friendsSearchUrl,
type:"GET",
data:{query:''},
success:function(friends){
resultsContainer.innerHTML="";
if(friends.length===0){
resultsContainer.innerHTML='<p class="modal-empty-msg">No accepted friends found.</p>';
return;
}
friends.forEach(friend=>{
resultsContainer.innerHTML+=`<div class="modal-list-item-with-btn"><div class="modal-list-info"><div class="modal-list-name">${friend.name}</div><div class="modal-list-email">${friend.email}</div></div><button onclick="sendInvite(this, ${friend.id})" class="btn-gold btn-small">Invite</button></div>`;
});
},
error:function(){
resultsContainer.innerHTML='<p style="color:red;font-size:13px;">Error loading friends.</p>';
}
});
}
}
}
};

window.closeModal=function(id){
const el=document.getElementById(id);
if(el)el.style.display='none';
};

window.sendFriendRequest=function(userId){
$.ajax({
url:window.chatConfig.sendFriendshipUrl,
type:"POST",
data:{receiver_id:userId,_token:window.chatConfig.csrfToken},
success:function(response){location.reload();},
error:function(xhr){location.reload();}
});
};

window.acceptFriendRequest=function(senderId){
$.ajax({
url:window.chatConfig.acceptFriendshipUrl,
type:"POST",
data:{sender_id:senderId,_token:window.chatConfig.csrfToken},
success:function(response){location.reload();},
error:function(xhr){location.reload();}
});
};

window.sendInvite=function(button,friendId){
const{localOfferId,csrfToken}=window.chatConfig;
if(!localOfferId)return;
$.ajax({
url:window.chatConfig.sendInviteUrl,
type:"POST",
data:{receiver_id:friendId,local_offer_id:localOfferId,_token:csrfToken},
complete:function(response){
button.textContent='✓';
button.disabled=true;
button.classList.add('btn-disabled');
}
});
};

window.toggleChat=function(){
const body=document.getElementById('chat-body'),btn=document.getElementById('chat-toggle');
if(!body)return;
if(isShow===1){
body.style.display='none';
btn.textContent='+';
isShow=0;
}else{
body.style.display='block';
btn.textContent='−';
isShow=1;
}
};

function connectWebSocket(){
const{currentUserId,currentUserName,chatRoomId}=window.chatConfig,messagesDiv=document.getElementById('chat-messages');
if(!chatRoomId||!messagesDiv)return;
socket=new WebSocket('ws://localhost:8080');
socket.onopen=()=>{
socket.send(JSON.stringify({type:'join',chat_room_id:chatRoomId,sender_id:currentUserId,sender_name:currentUserName}));
};
socket.onmessage=event=>{
try{
const data=JSON.parse(event.data);
if(data.type==='history'){
messages=data.messages||[];
messagesDiv.innerHTML='';
renderedMessageIds.clear();
messages.forEach(msg=>{
if(msg.id&&!renderedMessageIds.has(msg.id)){
renderMessage(msg);
renderedMessageIds.add(msg.id);
}
});
messagesDiv.scrollTop=messagesDiv.scrollHeight;
}
if(data.type==='message'){
const msg=data.message;
if(!msg.id){
return;
}
const isMine=String(msg.sender_id)===String(window.chatConfig.currentUserId);
if(isMine){
return;
}
if(renderedMessageIds.has(msg.id)){
return;
}
messages.push(msg);
renderMessage(msg);
renderedMessageIds.add(msg.id);
messagesDiv.scrollTop=messagesDiv.scrollHeight;
}
}catch(e){
console.error('Error parsing message:',e);
}
};
socket.onclose=()=>{
setTimeout(connectWebSocket,3000);
};
socket.onerror=error=>{
console.error('WebSocket error:',error);
socket.close();
};
}

function renderMessage(msg){
const{currentUserId}=window.chatConfig,messagesDiv=document.getElementById('chat-messages');
if(!messagesDiv)return;
if(document.querySelector(`[data-msg-id="${msg.id}"]`)){
return;
}
const isMine=String(msg.sender_id)===String(currentUserId),name=isMine?'You':(msg.sender_name??'Unknown'),messageDate=new Date(msg.created_at),time=messageDate.toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}),bubble=document.createElement('div');
bubble.className=`msg-bubble-wrapper ${isMine?'msg-mine':'msg-theirs'}`;
bubble.setAttribute('data-msg-id',msg.id);
bubble.innerHTML=`<div class="msg-meta"><span class="msg-name">${name}</span><span class="msg-time">${time}</span></div><div class="msg-content">${msg.content}</div>`;
messagesDiv.appendChild(bubble);
}

function sendMessage(){
const{currentUserId,chatRoomId}=window.chatConfig,input=document.getElementById('message-input'),messagesDiv=document.getElementById('chat-messages');
if(!socket||socket.readyState!==WebSocket.OPEN){
console.warn('WebSocket not connected');
return;
}
const content=input.value.trim();
if(!content)return;
const tempMsg={id:'temp_'+Date.now(),content:content,sender_id:currentUserId,sender_name:window.chatConfig.currentUserName,created_at:new Date().toISOString()};
renderMessage(tempMsg);
renderedMessageIds.add(tempMsg.id);
messagesDiv.scrollTop=messagesDiv.scrollHeight;
socket.send(JSON.stringify({type:'message',chat_room_id:chatRoomId,sender_id:currentUserId,content:content}));
input.value='';
}

document.addEventListener('DOMContentLoaded',()=>{
connectWebSocket();
const btn=document.getElementById('send-btn'),input=document.getElementById('message-input');
if(btn)btn.addEventListener('click',sendMessage);
if(input)input.addEventListener('keydown',e=>{
if(e.key==='Enter'){
e.preventDefault();
sendMessage();
}
});

let addFriendBtn=document.getElementById("addFriendBtn"),
friendReqBtn=document.getElementById("friendRequest"),
closeAddFriend=document.getElementById("addFriendmodalClose"),
closeReqFriend=document.getElementById("friendsRequestsModalClose"),
inviteModalClose=document.getElementById("inviteModalClose"),
participantsModalClose=document.getElementById("participantsModalClose"),
friendSearchBar=document.getElementById("friendSearchBar");

if(friendSearchBar){
friendSearchBar.addEventListener("input",(e)=>{
let userInput=friendSearchBar.value.trim(),resultsContainer=document.getElementById("friendSearchResults");
if(userInput){
$.ajax({
url:window.chatConfig.usersSearchUrl,
type:"GET",
data:{query:userInput},
success:function(users){
resultsContainer.innerHTML="";
if(users.length===0){
resultsContainer.innerHTML='<p class="modal-empty-msg">No users found.</p>';
return;
}
users.forEach(user=>{
if(user.id===window.chatConfig.currentUserId)return;
let buttonHTML='';
if(user.friendship_status==='accepted'){
buttonHTML='<button class="btn-gold btn-small btn-disabled" disabled>👥</button>';
}else if(user.friendship_status==='pending'){
buttonHTML='<button class="btn-gold btn-small btn-disabled" disabled>✓</button>';
}else if(user.friendship_status==='rejected'){
buttonHTML='<button class="btn-gold btn-small btn-disabled" disabled>✕</button>';
}else{
buttonHTML='<button onclick="sendFriendRequest('+user.id+')" class="btn-gold btn-small">Add</button>';
}
resultsContainer.innerHTML+=`<div class="modal-list-item-with-btn"><div class="modal-list-info"><div class="modal-list-name">${user.name}</div><div class="modal-list-email">${user.email}</div></div>${buttonHTML}</div>`;
});
},
error:function(){
resultsContainer.innerHTML='<p style="color:red;font-size:13px;">Error searching users.</p>';
}
});
}else{
resultsContainer.innerHTML="";
}
});
}

if(addFriendBtn)addFriendBtn.addEventListener("click",()=>openModal('addFriendModal'));
if(friendReqBtn)friendReqBtn.addEventListener("click",()=>openModal('friendsRequestsModal'));
if(closeAddFriend)closeAddFriend.addEventListener("click",()=>{closeModal('addFriendModal')
    friendSearchBar.textContent = "";
});
if(closeReqFriend)closeReqFriend.addEventListener("click",()=>closeModal('friendsRequestsModal'));
if(inviteModalClose)inviteModalClose.addEventListener("click",()=>closeModal('inviteModal'));
if(participantsModalClose)participantsModalClose.addEventListener("click",()=>closeModal('participantsModal'));

if(window.chatConfig.hasTimer){
const endTime=new Date(window.chatConfig.endTime).getTime();
let isOfferCompleted=false;
function updateTimer(){
const now=new Date().getTime(),distance=endTime-now,timerElement=document.getElementById('offerTimer');
if(distance<=0){
timerElement.textContent="00:00:00";
if(!isOfferCompleted){
isOfferCompleted=true;
$.ajax({
url:window.chatConfig.completeOfferUrl,
type:"POST",
data:{_token:window.chatConfig.csrfToken},
success:function(response){
setTimeout(()=>location.reload(),1000);
},
error:function(xhr){
console.error('Error completing offer');
}
});
}
return;
}
const hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60)),
minutes=Math.floor((distance%(1000*60*60))/(1000*60)),
seconds=Math.floor((distance%(1000*60))/1000);
timerElement.textContent=`${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
}
setInterval(updateTimer,1000);
}
});
