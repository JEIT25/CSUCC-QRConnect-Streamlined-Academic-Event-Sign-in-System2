<template>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-gray-100 shadow-lg rounded-lg p-6">
            <!-- Master List Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">{{ props.master_list.name }}</h1>
                <!-- Delete Master List Button -->
                <Link :href="`/events/${props.master_list.event_id}/master-lists/${props.master_list.master_list_id}`"
                    as="button" method="delete" class="text-red-500 hover:text-red-700">
                Delete Master List
                </Link>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Unique ID</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="member in props.master_list_members" :key="member.master_list_member_id">
                            <td class="py-2 px-4 border-b text-center">{{ member.full_name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ member.unique_id }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <Link class="bg-red-500 text-white hover:bg-red-600 px-2 py-1 rounded"
                                    :href="`/master-list-members/${member.master_list_member_id}`" as="button"
                                    method="delete">
                                Delete
                                </Link>
                                <button @click="showQRCode(member.unique_id,member.full_name)"
                                    class="bg-blue-500 text-white hover:bg-blue-600 px-2 py-1 rounded ml-2">
                                    QR Code
                                </button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add Student Buttons (aligned to the right) -->
            <div class="flex justify-end space-x-4 mb-4">
                <button @click="toggleIndividualForm"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Add Individually
                </button>
                <button @click="toggleBulkForm" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Add by Bulk
                </button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600"
                    @click="downloadAllQRCodesAsPDF">Download All QR Codes as PDF</button>
            </div>

            <!-- Add New Student Form (Individual) -->
            <div v-if="showIndividualForm" class="mt-6">
                <form @submit.prevent="addStudent">
                    <div class="flex flex-col md:flex-row items-center md:space-x-4 space-y-4 md:space-y-0">
                        <input type="text" v-model.trim="formOne.full_name" placeholder="Enter Full Name"
                            class="border border-gray-300 px-4 py-2 rounded-lg flex-1" required />
                        <input type="text" v-model.trim="formOne.unique_id" placeholder="Enter Unique ID"
                            class="border border-gray-300 px-4 py-2 rounded-lg flex-1" required />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Add Student
                        </button>
                    </div>
                </form>
            </div>

            <!-- Add Students by Bulk -->
            <div v-if="showBulkForm" class="mt-6">
                <form @submit.prevent="addStudentsBulk">
                    <textarea v-model="bulkInput" placeholder="Paste here one member per line
Format: Full Name,UniqueId(student id, etc.)
Example: Josh M. Ghad, 2022-7890
                    " class="border border-gray-300 w-full h-32 p-4 rounded-lg mb-4" required></textarea>

                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Add Students by Bulk
                    </button>
                </form>
            </div>

            <!-- QR Code Pop-up -->
            <div v-if="showQRCodeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg relative w-full max-w-md flex flex-col">
                    <button @click="closeQRCode" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                        Close
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-center">QR Code for {{ selectedMember }}</h3>
                    <div class="flex justify-center mb-4">
                        <qrcode-vue :value="selectedUniqueId" :size="200" :bgColor="'#ffffff'" :fgColor="'#000000'" />
                    </div>
                    <button @click="downloadQRCode"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg mt-4 hover:bg-green-600">
                        Download QR Code
                    </button>
                </div>
            </div>

            <div class="hidden">
                <div v-for="member in master_list_members" :key="member.unique_id">
                    <p id="names">{{ member.full_name }}</p>
                    <qrcode-vue id="qrCode" :value="member.unique_id" :size="200" />
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import QrcodeVue from 'qrcode.vue';
import jsPDF from 'jspdf';
import QRCode from 'qrcode';
import html2canvas from 'html2canvas';

const props = defineProps({
    master_list: Object,
    master_list_members: Array,
});

const formOne = useForm({
    type: "individual",
    full_name: '',
    unique_id: '',
});

const formMany = useForm({
    type: "bulk",
    members: [],
});

const bulkInput = ref('');
const showIndividualForm = ref(false);
const showBulkForm = ref(false);
const showQRCodeModal = ref(false);
const selectedUniqueId = ref('');
const selectedMember = ref('');

// Toggle Individual Form
const toggleIndividualForm = () => {
    showIndividualForm.value = !showIndividualForm.value;
    showBulkForm.value = false;
};

// Toggle Bulk Form
const toggleBulkForm = () => {
    showBulkForm.value = !showBulkForm.value;
    showIndividualForm.value = false;
};

// Show QR Code modal
const showQRCode = (uniqueId,fullName) => {
    selectedUniqueId.value = uniqueId;
    selectedMember.value = fullName;
    showQRCodeModal.value = true;
};

// Close QR Code modal
const closeQRCode = () => {
    showQRCodeModal.value = false;
};

// Download QR Code
const downloadQRCode = () => {
    const canvas = document.querySelector('canvas');
    if (canvas) {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = `qrcode-${selectedUniqueId.value}.png`;
        link.click();
    }
};

// Watch the bulkInput and update formMany.members in real-time
watch(bulkInput, (newValue) => {
    const lines = newValue.split('\n'); // Split input by newlines
    formMany.members = []; // Clear current members array
    for (let i = 0; i < lines.length; i++) {
        const line = lines[i].split(','); // Split each line by comma
        if (line.length === 2 && line[0].trim() !== "" && line[1].trim() !== "") { // Ensure both full_name and unique_id are present
            const full_name = line[0].trim();
            const unique_id = line[1].trim();
            // Check if the member with the same unique_id already exists in the formMany.members array
            const exists = formMany.members.some(member => member.unique_id === unique_id);

            // Add parsed member to formMany.members array if it doesn't already exist
            if (!exists) {
                formMany.members.push({ full_name, unique_id });
            }
        }
    }
});

// Method to add a member to the master list (individual)
const addStudent = () => {
    formOne.post(`/master-list-members/${props.master_list.master_list_id}`, {
        full_name: formOne.full_name,
        unique_id: formOne.unique_id,
    });
};

// Method to add members by bulk
const addStudentsBulk = () => {
    formMany.post(`/master-list-members/${props.master_list.master_list_id}`, {
        members: formMany.members,
    });
};


// Download all QR codes as PDF
const downloadAllQRCodesAsPDF = async () => {
    const pdf = new jsPDF();
    const members = props.master_list_members; // Assuming this is the data structure you are using

    for (let i = 0; i < members.length; i++) {
        const member = members[i];

        // Generate QR code image data
        const imgData = await QRCode.toDataURL(member.unique_id, {
            width: 200, // Set size of the QR code
            margin: 1,  // Adjust margin as needed
        });

        // Add image to PDF
        pdf.addImage(imgData, 'PNG', 10, 10 + (i * 70), 50, 50); // Adjust positioning as needed

        // Add text below the QR code
        pdf.text(member.full_name, 10, 70 + (i * 70)); // Adjust positioning as needed
    }

    // Save the PDF
    pdf.save(`${props.master_list.name}-QRCodes.pdf`);
};
</script>