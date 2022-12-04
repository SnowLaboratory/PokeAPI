<script setup>

import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    'primary': Boolean,
    'as': {
        type: String,
        default: 'buttton'
    },
})

</script>

<template>
    <Link :as="props.as" class="btn" :class="{
        'primary': props.primary
    }">
        <slot></slot>
    </Link>
</template>

<style>
    .btn {
        @apply px-3 py-1 rounded font-semibold text-[0.8rem] cursor-pointer
    }
    .btn.primary {
        @apply bg-slate-900 text-white hover:bg-slate-700
    }
</style>
