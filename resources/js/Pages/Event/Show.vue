<template>
    <div class="container mx-auto px-4 py-6 flex justify-center items-center min-h-screen">
        <div class="bg-gray-100 shadow-2xl rounded-lg p-6 w-full max-w-4xl">
            <!-- Profile Image -->
            <div class="flex flex-col md:flex-row items-center mb-6 md:space-x-6">
                <div class="flex-shrink-0">
                    <label class="text-md font-medium text-gray-700 mb-2 block text-center md:text-left">Event Profile
                        Image</label>
                    <img :src="event.profile_image" alt="Profile Image"
                        class="w-40 h-40 md:w-full md:h-48 rounded-lg shadow-md object-cover">
                </div>

                <!-- Activity Details -->
                <div class="mt-4 md:mt-0 flex-1">
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-500">Event Name</label>
                        <h3 class="text-2xl font-bold">{{ event.name }}</h3>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-700">{{ event.description }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-500">Start Date</label>
                        <p class="text-sm text-gray-500">{{ new Date(event.start_date).toLocaleDateString() }}</p>
                    </div>
                    <div class="mb-4" v-if="event.subject">
                        <label class="text-sm font-medium text-gray-500">Subject</label>
                        <p class="text-sm text-gray-500">{{ event.subject }}</p>
                    </div>
                    <div class="mb-4" v-if="event.subject_code">
                        <label class="text-sm font-medium text-gray-500">Subject Code</label>
                        <p class="text-sm text-gray-500">{{ event.subject_code }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="text-sm font-medium text-gray-500">Type</label>
                        <p class="text-sm text-gray-500">{{ event.type }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div v-if="props.user.type == 'facilitator'"
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
                <Link :href="`/events/${event.event_id}/qrscanner/checkin/`" class="btn-primary" as="button"
                    method="get">
                Check-In
                </Link>
                <Link :href="`/events/${event.event_id}/qrscanner/checkout`" class="btn-primary" as="button"
                    method="get">
                Check-Out
                </Link>
                <Link :href="`/events/${event.event_id}/attendees`" class="btn-primary" as="button" method="get">
                View Attendance List
                </Link>

                <!-- Button to trigger the export modal -->
                <button @click="showExportModal = true" class="btn-primary">
                    Export Attendance
                </button>

                <Link v-if="props.master_list"
                    :href="`/events/${event.event_id}/master-lists/${props.master_list.master_list_id}`"
                    class="btn-primary" as="button" method="get">
                Show MasterList
                </Link>
                <button v-else v-on:click="createMasterList" class="btn-primary">
                    Create MasterList
                </button>
                <Link :href="`/events/${event.event_id}/edit`" class="btn-primary" as="button" method="get">
                Edit
                </Link>
                <Link :href="`/events/${event.event_id}`" class="btn-primary" as="button" method="delete">
                Delete
                </Link>
            </div>

            <!-- Export Modal (Overlay) -->
            <div v-if="showExportModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4">Select Export Template</h3>
                    <form @submit.prevent="exportAttendance">
                        <div class="mb-4">
                            <label for="template" class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                            <select v-model="selectedTemplate" id="template" class="w-full p-2 border rounded-md">
                                <option value="" disabled>Select a template</option>
                                <option value="class-orientation">Class Orientation</option>
                                <option value="class-attendance">Class Attendance</option>
                                <!-- Add more templates as needed -->
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="showExportModal = false" class="btn-secondary mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary">
                                Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    event: Object,
    master_list: Object,
    user: Object
});

const form = useForm({});
const showExportModal = ref(false); // State for showing/hiding the export modal
const selectedTemplate = ref(''); // State to hold selected template

const createMasterList = () => {
    form.post(`/events/${props.event.event_id}/master-lists`);
};

const exportAttendance = () => {
    if (selectedTemplate.value) {
        // Redirect to export route with the selected template as a query parameter
        window.location.href = `/events/${props.event.event_id}/export?template=${selectedTemplate.value}`;
        showExportModal.value = false; // Close the modal after submission
    } 
};
</script>
