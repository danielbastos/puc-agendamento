<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    schedules: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-6 mx-auto max-w-7xl">
            <div v-for="(scheduleData, scheduleIdx) in schedules" :key="scheduleIdx">
                <h2 class="mt-6 text-xl font-semibold text-black dark:text-white">{{ scheduleIdx }}</h2>
                <div class="grid md:grid-cols-4 xs:grid-cols-1">
                    <div v-for="el in scheduleData" :key="el.id" class="w-full m-1">
                        <a href="#" class="block w-full-sm m-1 p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ el.name }}</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">{{ el.a_date }}</p>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                <span>{{ el.time_start }}</span>
                                <span> - </span>
                                <span>{{ el.time_end }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
