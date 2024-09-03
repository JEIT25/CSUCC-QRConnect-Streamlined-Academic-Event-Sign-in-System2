<template>
    <div class="container mx-auto px-4 py-6 flex justify-center items-center min-h-screen">
        <div class="bg-gray-100 shadow-2xl rounded-lg p-6 w-full max-w-2xl">
            <!-- Profile Image -->
            <div class="flex flex-col items-center mb-4">
                <label class="text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                <img :src="event.profile_image" alt="Profile Image" class="w-50 h-50 rounded-lg shadow-md object-cover">
            </div>

            <!-- Activity Details -->
            <div class="flex flex-col items-center md:items-start mb-6">
                <div class="mb-4 text-center md:text-left">
                    <label class="text-sm font-medium text-gray-500">Event Name</label>
                    <h3 class="text-2xl font-bold">{{ event.name }}</h3>
                </div>
                <div class="mb-4 text-center md:text-left">
                    <label class="text-sm font-medium text-gray-500">Description</label>
                    <p class="text-gray-700">{{ event.description }}</p>
                </div>
                <div class="text-center md:text-left">
                    <label class="text-sm font-medium text-gray-500">Start Date</label>
                    <p class="text-sm text-gray-500">{{ new Date(event.start_date).toLocaleDateString() }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-4 w-full">
                <Link :href="`/activities/${event.id}/check-in`"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-md text-center"
                    as="button" method="get">
                Check-In
                </Link>
                <Link :href="`/activities/${event.id}/check-out`"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-md text-center"
                    as="button" method="get">
                Check-Out
                </Link>
                <Link :href="`/activities/${event.id}/attendance`"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-md text-center"
                    as="button" method="get">
                View Attendance List
                </Link>
                <Link :href="`/activities/${event.id}/export`"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded-md text-center"
                    as="button" method="get">
                Export Attendance
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    event: Object
});
</script>
