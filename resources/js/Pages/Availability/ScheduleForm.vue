<script setup>
import { onMounted, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

defineProps({
    model: Object,
    patients: Array,
    title: String,
    breadcrumbs: Array,
});

const props = usePage().props;
const url = usePage().url;

const form = useForm({
    id: props.model.id ?? '',
    patient_id: props.model.patient_id ?? '',
});

onMounted(() => {
})
</script>

<template>

    <Head :title="props.title" />

    <AuthenticatedLayout>
        <template #header>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li v-for="(breadcrumb, index) in breadcrumbs" class="inline-flex items-center">
                        <svg v-if="index > 0" class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a 
                            :href="breadcrumb.url"
                            class="inline-flex items-center"
                            :class="{ 'text-gray-800 hover:text-blue-600' : breadcrumb.url, 'text-gray-400' : !breadcrumb.url}"
                        >
                            <h2 class="font-semibold text-xl  leading-tight">{{ breadcrumb.title }}</h2>
                        </a>
                    </li>
                </ol>
            </nav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div>
                    <form @submit.prevent="form.post(url)" class="space-y-6">
                        <section class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">{{  model.doctor.name }}</h2>
                            </header>

                            <div class="flex mt-4">
                                <div class="aml-3">
                                    <span class="block font-medium text-sm text-gray-700"> Data </span>
                                    {{ model.a_date }}
                                </div>

                                <div class="ml-3">
                                    <span class="block font-medium text-sm text-gray-700"> Início </span>
                                    {{ model.time_start }}
                                </div>

                                <div class="ml-3">
                                    <span class="block font-medium text-sm text-gray-700"> Término </span>
                                    {{ model.time_end }}
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.horarios" />
                        </section>

                        <section  class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">Selecione o paciente</h2>
                            </header>

                            <div class="mt-4 mb-4">
                                <InputLabel for="doctor" value="Pacientes" />
                                <select v-model="form.patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Selecione um paciente</option>
                                    <option v-for="patient in patients" :key="patient.id" :value="patient.id">{{ patient.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.patient_id" />
                            </div>
                        </section>

                        <section class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>
                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                                </Transition>
                            </div>
                        </section>
                    </form>
                
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
