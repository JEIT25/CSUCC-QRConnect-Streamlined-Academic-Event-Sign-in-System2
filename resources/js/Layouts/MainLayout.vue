<template>
    <div class="flex">
        <!-- Sidebar -->
        <aside v-if="page.props.user" class="w-64 bg-slate-950 p-4 h-screen shadow-lg shadow-yellow-500 hidden lg:block">
            <!-- Administrator Info Section -->
            <div class="flex flex-col items-center ml-2 mt-9 mb-7">
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#e59e24" stroke="#e59e24" width="70" height="70">
                    <g>
                        <path d="M10 9.25c-2.27 0-2.73-3.44-2.73-3.44C7 4.02 7.82 2 9.97 2c2.16 0 2.98 2.02 2.71 3.81 0 0-.41 3.44-2.68 3.44zm0 2.57L12.72 10c2.39 0 4.52 2.33 4.52 4.53v2.49s-3.65 1.13-7.24 1.13c-3.65 0-7.24-1.13-7.24-1.13v-2.49c0-2.25 1.94-4.48 4.47-4.48z"/>
                    </g>
                </svg>
                <div class="text-yellow-300 text-center">
                    <p class="font-semibold pt-2 text-white">{{ page.props.user.fname }} {{ page.props.user.lname }}</p>
                    <p class="text-xs uppercase">{{ page.props.user.type }}</p>
                </div>
            </div>

            <!-- Add spacing for modules -->
            <div class="mb-[20%]"></div>

            <ul class="flex flex-col w-full">
                <li class="flex items-center w-full hover:bg-slate-700 rounded transition duration-200 ease-in-out pl-4">
                    <svg fill="#bc7634" width="24" height="24" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" stroke="#bc7634">
                        <g>
                            <path d="M18.672 11H17v6c0 .445-.194 1-1 1h-4v-6H8v6H4c-.806 0-1-.555-1-1v-6H1.328c-.598 0-.47-.324-.06-.748L9.292 2.22c.195-.202.451-.302.708-.312.257.01.513.109.708.312l8.023 8.031c.411.425.539.749-.059.749z"></path>
                        </g>
                    </svg>
                    <Link class="text-yellow-300 hover:text-white pl-4 w-full" href="/module1">Dashboard</Link>
                </li>
                <!-- More navigation items here -->
                <li class="flex items-center w-full hover:bg-slate-700 rounded transition duration-200 ease-in-out pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 452.986 452.986" fill="#bc7634" width="24" height="24">
                        <path d="M404.344,0H48.642C21.894,0,0,21.873,0,48.664v355.681c0,26.726,21.894,48.642,48.642,48.642h355.702c26.726,0,48.642-21.916,48.642-48.642V48.664C452.986,21.873,431.07,0,404.344,0z M148.429,33.629h156.043v40.337H148.429V33.629z M410.902,406.372H42.041v-293.88h368.86V406.372z"></path>
                        <rect x="79.273" y="246.23" width="48.642" height="48.664"></rect>
                        <rect x="79.273" y="323.26" width="48.642" height="48.642"></rect>
                        <rect x="160.853" y="169.223" width="48.621" height="48.642"></rect>
                        <rect x="160.853" y="246.23" width="48.621" height="48.664"></rect>
                        <rect x="160.853" y="323.26" width="48.621" height="48.642"></rect>
                        <rect x="242.369" y="169.223" width="48.664" height="48.642"></rect>
                        <rect x="242.369" y="246.23" width="48.664" height="48.664"></rect>
                        <rect x="242.369" y="323.26" width="48.664" height="48.642"></rect>
                        <rect x="323.907" y="169.223" width="48.664" height="48.642"></rect>
                        <rect x="323.907" y="246.23" width="48.664" height="48.664"></rect>
                    </svg>
                    <Link class="text-yellow-300 hover:text-white w-full pl-4" href="/module2">My Events</Link>
                </li>

                <li class="flex items-center w-full hover:bg-slate-700 rounded transition duration-200 ease-in-out pl-4">
                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 7.063C16.5 10.258 14.57 13 12 13c-2.572 0-4.5-2.742-4.5-5.938C7.5 3.868 9.16 2 12 2s4.5 1.867 4.5 5.063zM4.102 20.142C4.487 20.6 6.145 22 12 22c5.855 0 7.512-1.4 7.898-1.857a.416.416 0 0 0 .09-.317C19.9 18.944 19.106 15 12 15s-7.9 3.944-7.989 4.826a.416.416 0 0 0 .091.317z" fill="#bc7634"></path>
                    </svg>
                    <Link class="text-yellow-300 hover:text-white w-full pl-4" href="/module3">My Account</Link>
                </li>
            </ul>
        </aside>

        <div class="flex-1">
        <!-- Image Section -->
        <!-- <div class="image-header h-screen/2 relative">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center background-image">
                <h1 class="text-white text-4xl font-bold">Welcome to CSUCC QRConnect</h1>
            </div>
        </div> -->

        <!-- Sticky Navigation Bar -->
        <header class="sticky top-0 z-50">
            <nav class="bg-slate-900">
                <div class="container mx-auto flex items-center justify-between p-4">
                    <!-- Left-aligned logo and brand name -->
                    <Link class="text-yellow-500 font-bold text-xl flex items-center" href="/">
                        <img :src="page.props.logoUrl" alt="Logo" width="30" height="24" class="mr-2">
                        CSUCC QRConnect
                    </Link>

                    <!-- Right-aligned navigation links -->
                    <div class="lg:flex items-center hidden space-x-8">
                        <ul class="flex space-x-8">
                            <!-- Show Logout only when the user is authenticated -->
                            <li v-if="page.props.user">
                                <Link class="text-yellow-400 hover:text-yellow-200" href="/logout" as="button" method="delete">Log out</Link>
                            </li>
                            <!-- Show Login only when the user is not authenticated -->
                            <li v-else>
                                <Link class="text-yellow-400 hover:text-yellow-200" href="/login">Login</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Hamburger menu button for small screens -->
                    <button class="lg:hidden text-yellow-200 focus:outline-none" @click="toggleMenu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile menu -->
                <div :class="{ 'hidden': !menuOpen, 'block': menuOpen }" class="lg:hidden">
                    <ul class="flex flex-col items-center space-y-4 py-4">
                        <!-- Show Logout only when the user is authenticated -->
                        <li v-if="page.props.user">
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/logout" as="button" method="delete">Log out</Link>
                        </li>
                        <!-- Show Login only when the user is not authenticated -->
                        <li v-else>
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/login">Guest</Link>
                        </li>
                        
                        <li v-if="!page.props.user">
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/students/login">Student</Link>
                        </li>
                        <li v-if="!page.props.user">
                            <Link class="text-yellow-400 hover:text-yellow-200" href="/facilitators/login">Facilitator</Link>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Main Content Section -->
        <main class="p-4">
            <div class="mb-4 border rounded-md shadow-md border-green-200 bg-green-100 p-2 text-center text-black-100 font-semibold" v-if="successMess">
                {{ successMess }}
            </div>
            <div class="mb-4 border rounded-md shadow-md border-red-200 bg-red-100 p-2 text-center text-black-100 font-semibold" v-if="failedMess">
                {{ failedMess }}
            </div>
            <slot></slot>
        </main>
    </div>

    </div>
</template>

<style scoped>
    .dark-blue { background-color: rgb(94, 118, 145) !important; }
</style>


<script>
export default {
  data() {
    return {
      backgroundStyle: {
        backgroundImage: 'url("/images/background.jpg")',
        backgroundSize: 'cover', // Adjust as needed
        backgroundPosition: 'center',
        height: '100vh', // Full viewport height
        width: '100%', // Full width
      },
    };
  },
};
</script>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const menuOpen = ref(false);
const successMess = computed(() => page.props.messages.success)
const failedMess = computed(() => page.props.messages.failed)
const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
};
</script>
