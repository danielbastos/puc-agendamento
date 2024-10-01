<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    posts: Array,
});

const ret = window.location.href
const formModel = {
    returnValue: ret
}

for (const i in props.posts) {
    formModel[props.posts[i].name] = props.posts[i].value
}

const form = useForm(formModel)
</script>

<template>
    <form @submit.prevent="form.post(href)">
        <input type="hidden" name="return" v-model='form.returnValue' />
        <input v-for="item in posts" :key="item.name" type="hidden" :name="form[item.name]" v-model='item.value' />
        <button type="submit" v-bind="$props">
            <slot />
        </button>
    </form>
</template>
