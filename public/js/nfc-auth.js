document.addEventListener('DOMContentLoaded', function () {
    const rfidInput = document.getElementById('rfid_uid');
    const scannerStatus = document.getElementById('scanner-status') || createScannerStatusElement();

    // Force clear UID on page load (prevent auto-fill issues)
    rfidInput.value = '';

    const eventSource = new EventSource('http://localhost:3000/nfc-status'); // Updated to the new endpoint for scanner status

    eventSource.onopen = function () {
        console.log('✅ Connected to NFC server');
    };

    eventSource.onmessage = function (event) {
        const data = JSON.parse(event.data);
        console.log('✅ Received scanner status:', data.scannerStatus);
        console.log('✅ UID data:', data.uid);  // Check the UID data coming in

        if (data.uid) {
            console.log(`✅ UID received: ${data.uid}`);
            rfidInput.value = data.uid; // Update the input field with the UID
            scannerStatus.classList.add('d-none'); // Hide warning once UID is received
        } else {
            rfidInput.value = ''; // Clear input if no UID is received
        }

        updateScannerStatus(data.scannerStatus); // Use the server-provided status
    };

    eventSource.onerror = function () {
        console.error('❌ Error connecting to NFC server.');
        updateScannerStatus(false); // If there's an error, treat it as no scanner detected
    };

    function createScannerStatusElement() {
        const status = document.createElement('div');
        status.id = 'scanner-status'; // Unique ID
        rfidInput.parentNode.appendChild(status);
        return status;
    }

    function updateScannerStatus(isConnected) {
        if (isConnected) {
            scannerStatus.className = 'alert alert-success mt-2';
            scannerStatus.innerText = '✅ NFC scanner detected!';
            setTimeout(() => scannerStatus.classList.add('d-none'), 2000); // Hide message after 2 seconds
            scannerStatus.classList.remove('d-none'); // Ensure the message is visible
        } else {
            if (!rfidInput.value) { // Only show warning if input is empty
                scannerStatus.className = 'alert alert-warning mt-2';
                scannerStatus.innerText = '⚠️ Warning: NFC scanner not detected. Please plug it in.';
                setTimeout(() => scannerStatus.classList.add('d-none'), 2000); // Hide message after 2 seconds
                scannerStatus.classList.remove('d-none'); // Ensure the message is visible
            }
        }
    }
});
