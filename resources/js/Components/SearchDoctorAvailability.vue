<script setup>
import { ref, onMounted } from 'vue';
import FlowbitDate from '@/Components/FlowbitDate.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    doctors: Array,
    isDoctor: Boolean,
})

let urlParams = new URLSearchParams(window.location.search);
const url = usePage().url;
const form = useForm({
    doctor_id: urlParams.get('doctor_id') ?? '',
    date: urlParams.get('date') ?? new Date().toLocaleDateString().padStart(10, '0'),
})

</script>

<template>
    <form @submit.prevent="form.get(url)" class="max-w">
        <div class='flex'>
            <div class="flex-3">
                <FlowbitDate v-model="form.date" />
            </div>
            <div v-if='!isDoctor' class="flex-3 ml-1">
                <select v-model="form.doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Selecione um médico</option>
                    <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
                </select>
            </div>
            <div class="flex-1 ml-1">
                <button 
                    type="submit"
                    class="p-2.5 text-white end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-4  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Pesquisar
                </button>
            </div>
        </div>
        
    </form>
</template>
