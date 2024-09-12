<template>
    <div class="container mx-auto px-4 py-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendees for {{ event.name }}</h1>

        <div v-if="attendees.length">
            <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-left">Check-in</th>
                        <th class="py-3 px-6 text-left">Check-out</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm text-start">
                    <tr v-for="attendee in attendees" :key="attendee.id"
                        class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ attendee.user.fname }} {{ attendee.user.lname }}</td>
                        <td class="py-3 px-6">{{ attendee.user.email }}</td>
                        <td class="py-3 px-6">{{ attendee.check_in ? new Date(attendee.check_in).toLocaleTimeString() :
                            'Not Checked-in' }}</td>
                        <td class="py-3 px-6">{{ attendee.check_out ? new Date(attendee.check_out).toLocaleTimeString()
                            : 'Not Checked-out' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="mt-6">
            <p class="text-gray-500">No attendees found for this event.</p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    event: Object,
    attendees: Array,
});
</script>
