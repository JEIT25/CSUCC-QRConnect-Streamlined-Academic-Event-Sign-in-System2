<template>
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left side: QR scanner -->
        <div class="md:w-1/2 flex justify-center items-center border-r-4 border-primary p-4">
            <div class="flex flex-col items-center">
                <h2 class="text-2xl font-bold mb-4">Attendance Check In</h2>
                <div id="reader" class="w-full max-w-md h-64"></div>
            </div>
        </div>

        <!-- Right side: Scan result and attendee info -->
        <div class="md:w-1/2 p-5 flex flex-col justify-center items-center">
            <div class="w-full max-w-md">
                <h1 class="text-2xl font-bold mb-4">SCAN RESULT</h1>
                <div v-if="scannedData" class="mt-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title text-lg font-semibold">Scanned QR Code Data</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Scanned Data:</strong> {{ scannedData }}</li>
                        </ul>
                    </div>
                </div>
                <div v-else>
                    <p class="text-lg">No data scanned yet.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio element for success sound -->
    <audio id="successSound">
        <source src="../../scanner/scan-sound.mp3" type="audio/mpeg">
    </audio>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Html5QrcodeScanner } from 'html5-qrcode';

// Reactive variables
const scannedData = ref(null);
const scannerEnabled = ref(true);

onMounted(() => {
    const onScanSuccess = (qrCodeMessage) => {
        if (!scannerEnabled.value) return;

        scannedData.value = qrCodeMessage;
        document.getElementById('successSound').play();

        // Disable scanner briefly to avoid duplicate scans
        scannerEnabled.value = false;
        setTimeout(() => {
            scannerEnabled.value = true;
        }, 1500);
    };

    const onScanError = (errorMessage) => {
        console.log(errorMessage);
    };

    const html5QrcodeScanner = new Html5QrcodeScanner('reader', {
        fps: 10,
        qrbox: 250,
    });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
});
</script>

<style scoped>
.card {
    background-color: #f8fafc;
    border-radius: 0.5rem;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.list-group-item {
    padding: 0.75rem 1.25rem;
    border: none;
}
</style>
