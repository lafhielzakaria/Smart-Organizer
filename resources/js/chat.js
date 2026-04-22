document.addEventListener('DOMContentLoaded', () => {
    const { currentUserId, currentUserName, chatRoomId } = window.chatConfig;
    const messagesDiv = document.getElementById('chat-messages');
    const input = document.getElementById('message-input');
    const btn = document.getElementById('send-btn');
    if (!chatRoomId || !messagesDiv) return;
    let socket;
    function connect() {
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
            const data = JSON.parse(event.data);
            if (data.type === 'history') data.messages.forEach(appendMessage);
            if (data.type === 'message') appendMessage(data.message);
        };

        socket.onclose = () => setTimeout(connect, 3000);
        socket.onerror = () => socket.close();
    }
    connect();
    function appendMessage(msg) {
        const isMine = Number(msg.sender_id) === Number(currentUserId);
        const name = isMine ? 'You' : (msg.sender_name ?? 'Unknown');
        const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const row = document.createElement('div');
        row.className = `msg-row ${isMine ? 'mine' : 'theirs'}`;
        row.innerHTML = `
            <span class="msg-name">${name}</span>
            <div class="msg-bubble">${msg.content}</div>
            <span class="msg-time">${time}</span>
        `;
        messagesDiv.appendChild(row);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    function sendMessage() {
        const content = input.value.trim();
        if (!content || socket.readyState !== WebSocket.OPEN) return;
        input.value = '';
        socket.send(JSON.stringify({ type: 'message', chat_room_id: chatRoomId, content }));
    }
    btn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });
});
