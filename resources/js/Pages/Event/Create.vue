<template>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Create New Event</h2>

        <form @submit.prevent="submitForm">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input v-model="form.name" type="text" id="name" class="input" placeholder="" />
                <div class="input-error" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea v-model="form.description" id="description" class="input" rows="4"></textarea>
                <div class="input-error" v-if="form.errors.location">
                    {{ form.errors.location }}
                </div>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input v-model="form.location" type="text" id="location" class="input"
                    placeholder="City,Baranggay,Street" />
                <div class="input-error" v-if="form.errors.location">
                    {{ form.errors.location }}
                </div>
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input v-model="form.start_date" type="date" id="start_date" class="input" />
                <div class="input-error" v-if="form.errors.start_date">
                    {{ form.errors.start_date }}
                </div>
            </div>

            <!-- Profile Image -->
            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input @change="handleFileUpload" type="file" id="profile_image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <div class="input-error" v-if="form.errors.profile_image">
                    {{ form.errors.profile_image }}
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    type: "event",
    name: '',
    description: '',
    location: '',
    start_date: '',
    profile_image: null,
})

const submitForm = () => {
    form.post('/activities')
}

const handleFileUpload = (event) => {
    form.profile_image = event.target.files[0]
}
</script>
