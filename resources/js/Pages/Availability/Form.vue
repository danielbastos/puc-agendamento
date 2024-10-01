<script setup>
import { onMounted, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import FlowbitDate from '@/Components/FlowbitDate.vue';

defineProps({
    model: Object,
    horarios: Array,
    doctors: Array,
    title: String,
    breadcrumbs: Array,
});

const props = usePage().props;
const url = usePage().url;

const horarios = [...props.horarios]
horarios.pop();

const data = ref(new Date(Date.now()).toLocaleString().split(',')[0])
const time_start = ref(horarios[0])
const time_end = ref(horarios[horarios.length-1])
const groupHorarios = ref('')
const doctorName = ref('')

if (props.model.doctor_id) {
    doctorName.value = props.doctors.find((el) => {return el.id == props.model.doctor_id}).name
}

const form = useForm({
    doctor_id: props.model.doctor_id ?? '',
    horarios: props.model.horarios ?? [],
});

const addHorarios = () => {
    const start = props.horarios.indexOf(time_start.value)
    const end = props.horarios.indexOf(time_end.value)

    for (let i = start; i <= end; i++) {
        const time_start = props.horarios[i]
        const time_end = props.horarios[i+1]
        form.horarios.push({
            a_date: data.value,
            time_start: time_start,
            time_end: time_end,
        })
    }
    makeGroupHorarios()
}

const makeGroupHorarios = () => {
    const res = {}
    for (const i in form.horarios) {
        const group = form.horarios[i].a_date
        if (!res[group]) res[group] = []
        res[group].push(form.horarios[i])
    }
    groupHorarios.value = res
}

onMounted(() => {
    //resetHorarios()
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
                                <h2 class="text-lg font-medium text-gray-900">Horário disponível</h2>
                            </header>

                            <div class="mt-4 mb-4" v-if="!props.model.doctor_id">
                                <InputLabel for="doctor" value="Médico" />
                                <select v-model="form.doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Selecione um médico</option>
                                    <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.doctor_id" />
                            </div>

                            <div class="mt-4 mb-4" v-if="props.model.doctor_id">
                                <input type="hidden" :value="form.doctor_id" />
                                <span>{{doctorName}}</span>
                            </div>

                            <div class="flex mt-4">
                                <div>
                                    <InputLabel for="data" value="Data" />
                                    <FlowbitDate id='data' v-model="data" />
                                </div>

                                <div class="ml-3">
                                    <InputLabel for="doctor" value="Início" />
                                    <select v-model="time_start" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="horario in horarios" :key="horario" :value="horario">{{ horario }}</option>
                                    </select>
                                </div>

                                <div class="ml-3">
                                    <InputLabel for="doctor" value="Término" />
                                    <select v-model="time_end" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="horario in horarios" :key="horario" :value="horario">{{ horario }}</option>
                                    </select>
                                </div>
                                <div class="ml-3 mt-5">
                                    <button @click="addHorarios" type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        Adicionar horários
                                    </button>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.horarios" />
                        </section>

                        <section v-for="(horarios, index) in groupHorarios" :key="index" class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">{{ index }}</h2>
                            </header>

                            <span v-for="(horario, index) in horarios" :key="index" id="badge-dismiss-dark" class="inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-gray-800 bg-gray-100 rounded dark:bg-gray-700 dark:text-gray-300">
                                {{ horario.time_start }} - {{ horario.time_end }}
                                <button type="button" class="inline-flex items-center p-1 ms-2 text-sm text-gray-400 bg-transparent rounded-sm hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-gray-300" data-dismiss-target="#badge-dismiss-dark" aria-label="Remove">
                                    <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Remove badge</span>
                                </button>
                            </span>
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
