<template>
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left side: QR scanner -->
        <div class="md:w-1/2 flex justify-center items-center border-r-4 border-blue-500 p-4">
            <div class="flex flex-col items-center">
                <h2 class="text-2xl font-bold mb-4 text-center">Attendance Check In for Event {{ props.event.name }}
                </h2>
                <div id="reader" class="w-full max-w-md h-64 bg-gray-200"></div>
            </div>
        </div>

        <!-- Right side: Scan result and attendee info -->
        <div class="md:w-1/2 p-5 flex flex-col justify-center items-center">
            <div class="w-full max-w-md">
                <h1 class="text-2xl font-bold mb-4">SCAN RESULT</h1>

                <div v-if="attendee" class="mt-4 bg-white p-4 rounded-lg shadow-md">
                    <div class="text-center">
                        <h5 class="text-lg font-semibold mb-2">Attendee Information</h5>
                        <h1 class="bg-red-500" v-if="message">
                            {{ message }}
                        </h1>
                        <p><strong>Name:</strong> {{ attendee.fname }} {{ attendee.lname }}</p>
                        <p><strong>Course:</strong> {{ attendee.course }} {{ attendee.lname }}</p>
                        <p><strong>Email:</strong> {{ attendee.email }}</p>
                        <p v-if="attendee.checkin"><strong>Check-in Time:</strong> {{
                            convertToLocalDateTime(attendee.checkin) }}</p>
                        <p v-else="checkin"><strong>Check-in Time:</strong> {{
                            convertToLocalDateTime(checkin) }}</p>
                    </div>
                </div>

                <div v-else class="text-lg text-center">
                    <p>No attendee found yet.</p>
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
import axios from 'axios'; // Axios for handling HTTP requests
import { Html5QrcodeScanner } from 'html5-qrcode';

// Reactive variables
const scannedData = ref(null);
const scannerEnabled = ref(true);
const attendee = ref(null); // This will hold the attendee info
const message = ref(null)
const checkin = ref(null) //incase existing attendee this will be set with checkin datetime value of existing attendee
const props = defineProps({
    event: Object
})

function convertToLocalDateTime(isoDate) { //this function formats the datetime value of checkin
    // Replace the space between date and time with 'T' to make it ISO 8601 compliant
    const formattedDate = isoDate.replace(' ', 'T');
    const date = new Date(formattedDate);

    if (isNaN(date.getTime())) {
        return 'Invalid Date'; // Handle invalid date
    }

    return date.toLocaleString(); // Formats to local date and time
}

onMounted(() => {
    const onScanSuccess = (qrCodeMessage) => {
        if (!scannerEnabled.value) return;
        scannedData.value = qrCodeMessage;
        document.getElementById('successSound').play();

        // Send the scanned QR data to the backend
        axios.post(`/events/${props.event.id}/qrscanner/checkin`, {
            qrData: qrCodeMessage,
        })
            .then(response => {
                // Update the attendee information
                attendee.value = response.data.attendee;
                message.value = response.data.message
                checkin.value = response.data.check_in
            })
            .catch(error => {
                console.error('Error submitting QR code:', error);
            });

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
        fps: 50,
        qrbox: 250,
    });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
});
</script>
