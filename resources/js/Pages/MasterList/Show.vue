<template>
    <div class="container mx-auto px-4 py-6">
        <div class="bg-gray-100 shadow-lg rounded-lg p-6">
            <!-- Master List Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">{{ props.master_list.name }}</h1>
                <!-- Delete Master List Button -->
                <Link :href="`/events/${props.master_list.event_id}/master-lists/${props.master_list.id}`" as="button" method="delete"
                    class="text-red-500 hover:text-red-700">
                Delete Master List
                </Link>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4 border-b">First Name</th>
                            <th class="py-2 px-4 border-b">Last Name</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student in props.master_list_students" :key="student.id">
                            <td class="py-2 px-4 border-b">{{ student.user.fname }}</td>
                            <td class="py-2 px-4 border-b">{{ student.user.lname }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <Link class="text-red-500 hover:text-red-700"
                                    :href="`/master-list-students/${student.id}`" as="button" method="delete">
                                Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add New Student Form -->
            <div class="mt-6">
                <form @submit.prevent="addStudent">
                    <div class="flex flex-col md:flex-row items-center md:space-x-4 space-y-4 md:space-y-0">
                        <input type="text" v-model.trim="form.fname" placeholder="Enter Student First Name"
                            class="border border-gray-300 px-4 py-2 rounded-lg flex-1" required />
                        <input type="text" v-model.trim="form.lname" placeholder="Enter Student Last Name"
                            class="border border-gray-300 px-4 py-2 rounded-lg flex-1" required />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Add Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    master_list: Object,
    master_list_students: Array,
});

const form = useForm({
    lname: '',
    fname: '',
});

// Method to add a student to the master list
const addStudent = () => {
    form.post(`/master-list-students/${props.master_list.id}`, {
        lname: form.lname,
        fname: form.fname,
    });
};
</script>
