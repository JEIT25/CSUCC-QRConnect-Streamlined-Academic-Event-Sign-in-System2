<template>
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link v-for="event in events" :key="event.id" :href="`/events/${event.id}`"
                class="bg-white shadow-md rounded-lg p-6 hover:bg-gray-300 transition-colors flex flex-col justify-center">
            <!-- <img :src="`/storage/${ event.profile_image }`" alt=""> incase profile image is to be displyed in index page -->
            <h3 class="text-xl font-bold mb-2">{{ event.name }}</h3>
            <p class="text-gray-700 mb-4">{{ truncateText(event.description, 100) }}</p>
            <p class="text-sm text-gray-600">
                <strong>Location:</strong> {{ event.location }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Date:</strong> {{ new Date(event.start_date).toLocaleDateString() }}
            </p>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    events: Array
});

// Method to truncate text
function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...';
    }
    return text;
}
</script>
