<template>
    <div>
        <h1>Master List Name: {{ props.master_list.name }}</h1>
        <ul>
            <li v-for="student in props.master_list_students" :key="student.id">
                {{ student.user.fname }} {{ student.user.lname }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import {computed} from 'vue'
const props = defineProps({
    master_list: Object,
    master_list_students: Array
})

// const hasStudents = computed(() => {
//     props.master_list_students.length
// })

</script>