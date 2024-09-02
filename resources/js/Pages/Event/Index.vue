<template>
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Loop through the events array and display each event in a box -->
            <div v-for="event in events" :key="event.id" class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold mb-2">{{ event.name }}</h3>
                <p class="text-gray-700 mb-4">{{ event.description }}</p>
                <p class="text-sm text-gray-500">
                    <strong>Location:</strong> {{ event.location }}
                </p>
                <p class="text-sm text-gray-500">
                    <strong>Date:</strong> {{ new Date(event.start_date).toLocaleDateString() }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    events: Array
})
</script>
