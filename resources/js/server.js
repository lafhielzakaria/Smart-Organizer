const socket = new WebSocket('ws://localhost:8080');
const messagesDiv = document.getElementById('chat-messages');
const input = document.getElementById('message-input');
const btn = document.getElementById('send-btn');
socket.onmessage = (event) => {
    let message = event.data;
    if (message.includes("Marhba bik")) {
        return;
    }
    if (message.includes("Safi wselni l-khbar:")) {
        message = message.replace("Safi wselni l-khbar:", "").trim();
    }
    const p = document.createElement('p');
    p.textContent = message;
    console.log(message);
    messagesDiv.appendChild(p);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
};
btn.onclick = () => {
    if (input.value) {
        socket.send(input.value);
        input.value = '';
    }
};