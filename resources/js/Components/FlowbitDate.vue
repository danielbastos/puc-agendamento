<script setup>
import { nextTick, onMounted, ref } from 'vue';
import { initFlowbite } from 'flowbite'

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const focusout = (ev) => {
    console.log('focusout', ev, ev.target.value)
    model.value = ev.target.value
};

const evtest = (ev) => {
    console.log(ev.type, ev, ev.target.value)
    setTimeout(() => {model.value = ev.target.value}, 1);
};


onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    initFlowbite();
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative max-w-sm">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
        </div>
        <input @focusout="focusout" @focusin="evtest" ref="input" datepicker-format="dd/mm/yyyy" v-model="model" datepicker datepicker-autohide class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Selecione uma data" />
    </div>
</template>
