<template>
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <Link v-for="event in events" :key="event.id" :href="`/activities/${event.id}`"
                class="bg-white shadow-md rounded-lg p-6 hover:bg-gray-300  transition-colors">
            <h3 class="text-xl font-bold mb-2">{{ event.name }}</h3>
            <p class="text-gray-700 mb-4">{{ event.description }}</p>
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
import { Link } from '@inertiajs/vue3'

defineProps({
    events: Array
})
</script>
