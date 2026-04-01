const { WebSocketServer } = require('ws');
const mysql = require('mysql2/promise');

const db = mysql.createPool({
    host: '127.0.0.1',
    port: 3306,
    user: 'root',
    password: '',
    database: 'smart_organizer',
});

const wss = new WebSocketServer({ port: 8080 });
const rooms = {};

wss.on('connection', (ws) => {
    ws.chatRoomId = null;

    ws.on('message', async (raw) => {
        let data;
        try { data = JSON.parse(raw); } catch { return; }

        if (data.type === 'join') {
            const [rows] = await db.query(
                `SELECT p.id FROM participations p
                 JOIN chat_rooms cr ON cr.local_offer_id = p.local_offer_id
                 WHERE p.user_id = ? AND cr.id = ? AND p.leftAt IS NULL LIMIT 1`,
                [data.sender_id, data.chat_room_id]
            ).catch(() => [[]]);

            if (!rows.length) { ws.close(); return; }

            ws.chatRoomId = String(data.chat_room_id);
            ws.senderId   = data.sender_id;
            ws.senderName = data.sender_name;

            if (!rooms[ws.chatRoomId]) rooms[ws.chatRoomId] = new Set();
            rooms[ws.chatRoomId].add(ws);

            const [messages] = await db.query(
                `SELECT m.id, m.content, m.sender_id, m.created_at, u.name as sender_name
                 FROM messages m JOIN users u ON u.id = m.sender_id
                 WHERE m.chat_room_id = ? ORDER BY m.id ASC`,
                [ws.chatRoomId]
            );
            ws.send(JSON.stringify({ type: 'history', messages }));
        }

        if (data.type === 'message' && ws.chatRoomId) {
            const now = new Date().toISOString().slice(0, 19).replace('T', ' ');
            const [result] = await db.query(
                `INSERT INTO messages (content, sender_id, chat_room_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)`,
                [data.content, ws.senderId, ws.chatRoomId, now, now]
            );

            const saved = {
                id: result.insertId,
                content: data.content,
                sender_id: ws.senderId,
                sender_name: ws.senderName,
                created_at: now,
            };

            rooms[ws.chatRoomId].forEach(client => {
                if (client.readyState === 1) {
                    client.send(JSON.stringify({ type: 'message', message: saved }));
                }
            });
        }
    });

    ws.on('close', () => {
        if (ws.chatRoomId && rooms[ws.chatRoomId]) {
            rooms[ws.chatRoomId].delete(ws);
        }
    });
});

console.log('WebSocket server running on ws://localhost:8080');
