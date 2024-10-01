<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


import { Head, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    model: Object,
    roles: Object,
    title: String,
    breadcrumbs: Array,
});

const props = usePage().props;
const url = usePage().url;
//const title = props.breadcrumbs[props.breadcrumbs.length-1].title

const form = useForm({
    id: props.model.id,
    name: props.model.name ?? '',
    email: props.model.email ?? '',
    password: '',
    password_confirmation: '',
    roles: props.model.roles ?? [],
});

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
                                <h2 class="text-lg font-medium text-gray-900">Dados básicos</h2>
                            </header>

                            <div class="mt-4">
                                <InputLabel for="name" value="Nome" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                    autofocus autocomplete="Nome" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                                    required autocomplete="username">
                                </TextInput>
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                        </section>

                        <section class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">Modificação de senha</h2>
                            </header>

                            <p class="mt-1 text-sm text-gray-600">
                                Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.
                            </p>

                            <div class="mt-4">
                                <InputLabel for="password" value="Senha" />
                                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete=false />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password_confirmation" value="Confirmação de senha" />
                                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" :required="!!form.password" autocomplete=false />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
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
