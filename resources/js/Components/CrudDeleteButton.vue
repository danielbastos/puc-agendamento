<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        default: 'Delete'
    }
});

const ret = window.location.href

const form = useForm({
    returnValue: window.location.href
})
</script>

<template>
    <form @submit.prevent="form.delete(href)">
        <input type="hidden" name="return" v-model='ret' />
        <button type="submit" v-bind="$props">
            <slot />
        </button>
    </form>
</template>
