<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CrudEditButton from '@/Components/CrudEditButton.vue'
import CrudDeleteButton from '@/Components/CrudDeleteButton.vue'
import CrudFormButton from '@/Components/CrudFormButton.vue'

import SearchDoctorAvailability from '@/Components/SearchDoctorAvailability.vue'

defineProps({
    models: Array,
    doctors: Array,
    isDoctor: Boolean,
    isPatient: Boolean,
})
/*
const props = usePage().props
const addOptionsList = []

for (const key in props.roles) {
    if (Object.prototype.hasOwnProperty.call(object, key)) {
        const element = object[key];
        
    }
}

const addOptions = ref([
    {url: route('user.create'), title: 'Administrador'},
    {url: '/bbb', title: 'Atendente'},
    {url: '/ccc', title: 'Paciente'},
    {url: '/ddd', title: 'Médico'},
]);
*/
</script>

<template>
    <Head title="Disponibilidade de horários" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Disponibilidade de horários</h2>
        </template>
        
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-md">
                <div class="p-4 bg-white dark:bg-gray-900 flex">
                    <div class="grow pt-2">
                        <SearchDoctorAvailability :doctors="doctors" :isDoctor="isDoctor"/>
                    </div>
                    
                    <div class="flex-1 pt-4  text-right">
                        <a :href="route('availability.create')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Adicionar</a>
                    </div>
                </div>
                
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                Data
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Médico
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Início
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Término
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Agendamento
                            </th>
                            <th scope="col" class="px-6 py-4 crud-action-width">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="model in models" :key="model.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ model.a_date }}
                            </th>
                            <td class="px-6 py-4">
                                {{ model.doctor.name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ model.time_start }}
                            </td>
                            <td class="px-6 py-4">
                                {{ model.time_end }}
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="model.patient">
                                    {{ model.patient.name }}
                                </span>

                                <span v-else-if="!model.past">
                                    <CrudFormButton
                                        v-if="isPatient"
                                        :href="route('availability.schedule.store', model.id)"
                                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        :posts="[{name: 'id', value: model.id}, {name: 'patient_id', value: $page.props.auth.user.id}]"
                                    >
                                        Agendar neste horário
                                    </CrudFormButton>
                                    <a v-else :href="route('availability.schedule.index', model.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                        Agendar paciente
                                    </a>
                                </span>
                            </td>
                            <td class="flex items-center px-6 py-4">
                                <CrudDeleteButton v-if="!model.past && model.patient" :href="route('availability.schedule.cancel', model.id)" title="Cancelar" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    Cancelar
                                </CrudDeleteButton>
                                <CrudDeleteButton v-if="!isPatient && !model.past && !model.patient" :href="route('availability.delete', model.id)" title="Remover" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    Remover
                                </CrudDeleteButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>