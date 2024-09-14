<template>
    <div>
        <form v-on:submit.prevent="submitForm">
            <input type="text" placeholder="email" v-model.trim="form.email">
            <p v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</p>
            <input type="password" placeholder="password" v-model.trim="form.password">
            <p v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</p>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { forIn } from 'lodash';

const form = useForm({
    email: "",
    password: "",
})

const submitForm = () => {
    form.post('login')
}
</script>