<template>
    <div class="container mx-auto px-4 py-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Attendees for {{ event.name }}</h1>

        <div v-if="attendee_records.length">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Check-in</th>
                            <th class="py-3 px-6 text-left">Check-out</th>
                            <th class="py-3 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm text-start">
                        <tr v-for="attendee_record in attendee_records" :key="attendee_record.attendee_record_id"
                            class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ attendee_record.master_list_member.full_name }}</td>
                            <td class="py-3 px-6">{{ attendee_record.check_in ? new
                                Date(attendee_record.check_in).toLocaleTimeString() :
                                'Not Checked-in' }}</td>
                            <td class="py-3 px-6">{{ attendee_record.check_out ? new
                                Date(attendee_record.check_out).toLocaleTimeString()
                                : 'Not Checked-out' }}</td>
                            <td class="py-3 px-6 text-center">
                                <Link :href="`/events/${event.event_id}/attendees/${attendee_record.attendee_record_id}`" method="delete" as="button"
                                    class="text-red-500 hover:text-red-700">
                                Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else class="mt-6">
            <p class="text-gray-500">No attendee_records found for this event.</p>
        </div>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
const props = defineProps({
    event: Object,
    attendee_records: Array,
});
</script>
