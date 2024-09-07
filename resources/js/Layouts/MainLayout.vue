<template>
    <div>
        <header>
            <nav class="dark-blue">
                <div class="container mx-auto flex items-center justify-between p-4">
                    <!-- Left-aligned logo and brand name -->
                    <Link class="text-yellow-500 font-bold text-xl flex items-center" href="/">
                    <img :src="page.props.logoUrl" alt="Logo" width="30" height="24" class="mr-2">
                    CSUCC QRConnect
                    </Link>
                    <!-- Right-aligned navigation links -->
                    <div class="lg:flex items-center hidden space-x-8">
                        <ul class="flex space-x-8">
                            <li>
                                <Link class="text-yellow-500 hover:text-yellow-200" aria-current="page"
                                    href="{{ route('attendees.create') }}">
                                Generate QR Code
                                </Link>
                            </li>
                            <li>
                                <Link class="text-yellow-400 hover:text-yellow-200" href="/events">
                                Events
                                </Link>
                            </li>

                            <li>
                                <Link class="text-yellow-400 hover:text-yellow-200" href="/events/create">
                                Create an event
                                </Link>
                            </li>
                            <li v-if="page.props.user">
                                <Link class="text-yellow-400 hover:text-yellow-200" href="#">
                                {{ page.props.user.type }}
                                {{ page.props.user.fname }}
                                {{ page.props.user.lname }}
                                </Link>
                            </li>
                            <li>
                                <Link v-if="!page.props.user" class="text-yellow-400 hover:text-yellow-200"
                                    href="/login">
                                Log in
                                </Link>
                                <Link v-else class="text-yellow-400 hover:text-yellow-200" href="/logout" as="button"
                                    method="delete">
                                Log out
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <!-- Hamburger menu button for small screens -->
                    <button class="lg:hidden text-yellow-200 focus:outline-none" @click="toggleMenu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <!-- Mobile menu -->
                <div :class="{ 'hidden': !menuOpen, 'block': menuOpen }" class="lg:hidden">
                    <ul class="flex flex-col items-center space-y-4 py-4">
                        <li>
                            <Link class="text-yellow-400 hover:text-yellow-200" aria-current="page"
                                href="{{ route('attendees.create') }}">
                            Generate QR Code
                            </Link>
                        </li>
                        <li>
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/events">
                            Events
                            </Link>
                        </li>
                        <li>
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/events/create">
                            Create an event
                            </Link>
                        </li>
                        <li>
                            <Link v-if="!page.props.user" class="text-yellow-400 hover:text-yellow-200" href="/login">
                            Log in
                            </Link>
                            <Link v-else class="text-yellow-400 hover:text-yellow-200" href="#">
                            {{ page.props.user.type }}
                            {{ page.props.user.fname }}
                            {{ page.props.user.lname }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <main>
            <div class="mb-4 border round-md shadow-md border-green-200 bg-green-100 p-2 text-center text-black-100 font-semibold"
                v-if="successMess">
                {{ successMess }}
            </div>
            <div class="mb-4 border round-md shadow-md border-red-200 bg-red-100 p-2 text-center text-black-100 font-semibold"
                v-if="failedMess">
                {{ failedMess }}
            </div>
            <slot></slot>
        </main>
    </div>

</template>
<style scoped>
    .dark-blue {background-color: rgb(94, 118, 145) !important;}
</style>
<script setup>
import { Link } from '@inertiajs/vue3'
import { ref,computed } from 'vue';
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const menuOpen = ref(false);
const successMess = computed(() => page.props.messages.success)
const failedMess = computed(() => page.props.messages.failed)
const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};
</script>