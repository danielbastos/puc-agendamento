<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CrudEditButton from '@/Components/CrudEditButton.vue'
import CrudDeleteButton from '@/Components/CrudDeleteButton.vue'
import CrudAddButton from '@/Components/CrudAddButton.vue'
import SearchInput from '@/Components/SearchInput.vue'

import FlowbiteDropdown from '@/Components/FlowbiteDropdown.vue'

defineProps({
    models: Array,
    addOptions: Array,
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
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuários</h2>
        </template>
        
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-md">
                <div class="p-4 bg-white dark:bg-gray-900 flex">
                    <div class="grow">
                        <SearchInput
                            title="Pesquisa de usuários"
                        />
                    </div>
                    
                    <div class="flex-none pt-2">
                        <FlowbiteDropdown title="Adicionar" :items="addOptions" />
                    </div>
                </div>
                
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-4">
                                E-Mail
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Papel
                            </th>
                            <th scope="col" class="px-6 py-4 crud-action-width">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="model in models" :key="model.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ model.name }}
                            </th>
                            <td class="px-6 py-4">
                                <a :href="'mailto:' + model.email">{{ model.email }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span v-for="role in model.roles" :key="role.id"
                                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400"
                                >
                                    {{ role.name }}
                                </span>
                                <span v-if="model.roles.length == 0 "> --- </span>
                            </td>
                            <td class="flex items-center px-6 py-4">
                                <CrudEditButton :href="route('user.edit', model.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" >
                                    Modificar
                                </CrudEditButton>
                                <CrudDeleteButton v-if="!model.patient" :href="route('user.delete', model.id)" title="Remover" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
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