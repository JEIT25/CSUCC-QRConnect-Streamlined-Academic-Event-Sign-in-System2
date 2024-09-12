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
                    <div>
                        <label class="text-sm font-medium text-gray-500">Start Date</label>
                        <p class="text-sm text-gray-500">{{ new Date(event.start_date).toLocaleDateString() }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
                <Link :href="`/events/${event.id}/qrscanner/checkin/`" class="btn-primary" as="button" method="get">
                Check-In
                </Link>
                <Link :href="`/events/${event.id}/qrscanner/checkout`" class="btn-primary" as="button" method="get">
                Check-Out
                </Link>
                <Link :href="`/events/${event.id}/attendees`" class="btn-primary" as="button" method="get">
                View Attendance List
                </Link>
                <Link :href="`/events/${event.id}/export`" class="btn-primary" as="button" method="get">
                Export Attendance
                </Link>
                <Link v-if="props.master_list" :href="`/events/${event.id}/master-lists/${props.master_list.id}`"
                    class="btn-primary" as="button" method="get">
                Show MasterList
                </Link>
                <button v-else v-on:click="createMasterList" class="btn-primary">
                    Create MasterList
                </button>
                <Link :href="`/events/${event.id}/edit`" class="btn-primary" as="button" method="get">
                Edit
                </Link>
                <Link :href="`/events/${event.id}`" class="btn-primary" as="button" method="delete">
                Delete
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    event: Object,
    master_list: Object
});

const form = useForm({})

const createMasterList = () => { //this will submit to masterlist store post route and backend will auto create masterlist
    form.post(`/events/${props.event.id}/master-lists`)
};

</script>
