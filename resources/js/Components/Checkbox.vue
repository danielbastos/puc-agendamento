<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
    label: {
        default: null,
    },
});

const componentId = 'checkbox_'+Math.floor(Math.random() * 100000);

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        :id="componentId"
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="p-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" 
    />
    <label v.if='label' :for="componentId" aclass="ms-2 text-sm text-gray-600" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        <span>{{ label }}</span>
    </label>
</template>
