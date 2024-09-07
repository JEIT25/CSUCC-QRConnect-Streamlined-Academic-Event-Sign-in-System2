<template>
    <div>
        <form v-on:submit.prevent="submitForm">
            <input type="text" v-model="form.name">
            <button type="submit">create</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ //define event data passed to this template from bckend
    event: Object
})
const form = useForm({
    name: ""
})

const submitForm = () => {
    form.post(`/events/${props.event.id}/master-list`)
}
</script>