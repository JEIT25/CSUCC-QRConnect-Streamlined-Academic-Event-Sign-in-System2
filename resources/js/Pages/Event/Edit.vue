<template>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Event</h2>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input v-model.trim="form.name" type="text" id="name" class="input" placeholder="" />
                <div class="input-error" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea v-model.trim="form.description" id="description" class="input" rows="4"></textarea>
                <div class="input-error" v-if="form.errors.description">
                    {{ form.errors.description }}
                </div>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input v-model.trim="form.location" type="text" id="location" class="input"
                    placeholder="City, Barangay, Street" />
                <div class="input-error" v-if="form.errors.location">
                    {{ form.errors.location }}
                </div>
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input v-model.trim="form.start_date" type="date" id="start_date" class="input" />
                <div class="input-error" v-if="form.errors.start_date">
                    {{ form.errors.start_date }}
                </div>
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <input v-model.trim="form.subject" type="text" id="subject" class="input" />
                <div class="input-error" v-if="form.errors.subject">
                    {{ form.errors.subject }}
                </div>
            </div>

            <!-- Subject Code -->
            <div class="mb-4">
                <label for="subject_code" class="block text-sm font-medium text-gray-700">Subject Code</label>
                <input v-model.trim="form.subject_code" type="text" id="subject_code" class="input" />
                <div class="input-error" v-if="form.errors.subject_code">
                    {{ form.errors.subject_code }}
                </div>
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select v-model="form.type" id="type" class="input">
                    <option value="">Select Type</option>
                    <option value="class attendance">Class Attendance</option>
                    <option value="class orientation">Class Orientation</option>
                    <option value="exam">Exam</option>
                    <option value="other">Other</option>
                    <!-- Add more predefined types as needed -->
                </select>
                <div class="input-error" v-if="form.errors.type">
                    {{ form.errors.type }}
                </div>
            </div>

            <!-- Other Type -->
            <div class="mb-4" v-if="form.type === 'other'">
                <label for="other_type" class="block text-sm font-medium text-gray-700">Other Type</label>
                <input v-model.trim="form.other_type" type="text" id="other_type" class="input"
                    placeholder="Specify type" />
                <div class="input-error" v-if="form.errors.other_type">
                    {{ form.errors.other_type }}
                </div>
            </div>

            <!-- Profile Image -->
            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input @change="addFile" type="file" id="profile_image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <div class="input-error" v-if="form.errors.profile_image">
                    {{ form.errors.profile_image }}
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import debounce from 'lodash/debounce'

const props = defineProps({
    event: Object,
})

let form = useForm({
    subject: props.event.subject,
    subject_code: props.event.subject_code,
    name: props.event.name,
    description: props.event.description,
    location: props.event.location,
    start_date: props.event.start_date,
    type: props.event.type || '', // New type attribute
    other_type: props.event.other_type || '', // New other_type attribute
    profile_image: null,
    _method: 'PUT' // Set as PUT since HTML only accepts POST for file upload
})

const addFile = (event) => {
    form.profile_image = event.target.files[0]
}

const isSubmitting = ref(false)
// Debounce the submit handler
const debouncedSubmit = debounce(() => {
    isSubmitting.value = true
    try {
        form.post(`/events/${props.event.event_id}`) // Submit a POST request but when sent to backend it is turned into a PUT request
        console.log('Form submitted successfully.')
    } catch (error) {
        console.error('Error submitting form:', error)
    } finally {
        isSubmitting.value = false
    }
}, 1000) // Adjust the debounce time

const submitForm = () => {
    debouncedSubmit()
}
</script>
