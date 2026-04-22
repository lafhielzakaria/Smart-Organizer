console.log("aa");
const socket = new WebSocket('ws://localhost:8080');
const messagesDiv = document.getElementById('chat-messages');
const input = document.getElementById('message-input');
const btn = document.getElementById('send-btn');
socket.onmessage = (event) => {
    const p = document.createElement('p');
    p.textContent = event.data;
    console.log(event.data);
    messagesDiv.appendChild(p);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
};
btn.onclick = () => {
    if (input.value) {
        socket.send(input.value);
        input.value = '';
    }
};