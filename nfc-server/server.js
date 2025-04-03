import { NFC } from 'nfc-pcsc';
import express from 'express';
import cors from 'cors';

const app = express();
const port = 3000;
const nfc = new NFC();

let latestUid = '';
let readers = {}; // Store active readers
let clients = []; // To track connected EventSource clients

app.use(cors());
app.use(express.json());

// Setup the EventSource endpoint for scanner status updates
app.get('/nfc-status', (req, res) => {
    res.setHeader('Content-Type', 'text/event-stream');
    res.setHeader('Cache-Control', 'no-cache');
    res.setHeader('Connection', 'keep-alive');

    // Add this client to the list of connected clients
    clients.push(res);

    // Send initial scanner status and UID
    sendScannerStatus(res);

    // When the connection is closed, remove it from the list of clients
    req.on('close', () => {
        clients = clients.filter(client => client !== res);
    });
});

// Send the scanner status to the client
function sendScannerStatus(client) {
    const statusMessage = JSON.stringify({ 
        scannerStatus: Object.keys(readers).length > 0, 
        uid: latestUid 
    });
    client.write(`data: ${statusMessage}\n\n`);
}

// Notify all clients about the current scanner status and UID
function sendUid() {
    const message = JSON.stringify({ uid: latestUid });
    clients.forEach(client => {
        client.write(`data: ${message}\n\n`);
    });
}

// Send scanner status on initial connection and when the reader is connected/disconnected
nfc.on('reader', reader => {
    console.log(`✅ NFC Reader Connected: ${reader.reader.name}`);
    readers[reader.reader.name] = reader;

    // Notify client that scanner is connected
    sendScannerStatusToAll();

    reader.on('card', card => {
        console.log(`🎫 Card detected: UID = ${card.uid}`);
        latestUid = card.uid;

        // Send the updated UID to all connected clients
        sendUid();
    });

    reader.on('error', err => {
        console.error(`❌ Reader Error (${reader.reader.name}): ${err}`);
    });

    reader.on('end', () => {
        console.log(`⚠️ NFC Reader Disconnected: ${reader.reader.name}`);
        delete readers[reader.reader.name];
        latestUid = '';

        // Notify client that scanner is disconnected
        sendScannerStatusToAll();
    });
});

// Notify all clients when scanner status changes
function sendScannerStatusToAll() {
    const statusMessage = JSON.stringify({ 
        scannerStatus: Object.keys(readers).length > 0, 
        uid: latestUid 
    });
    clients.forEach(client => {
        client.write(`data: ${statusMessage}\n\n`);
    });
}

nfc.on('error', err => {
    console.error(`❌ NFC error: ${err}`);
    console.log('🔄 Restarting NFC Service...');
});

app.listen(port, () => {
    console.log(`🚀 NFC Server running at http://localhost:${port}`);
});
