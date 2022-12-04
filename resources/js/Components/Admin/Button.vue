<script setup>

const props = defineProps({
    'primary': Boolean,
})

</script>

<template>
    <button class="btn" :class="{
        'primary': props.primary
    }">
        <slot></slot>
    </button>
</template>

<style>
    .btn {
        @apply px-3 py-1 rounded font-semibold text-[0.8rem]
    }
    .btn.primary {
        @apply bg-slate-900 text-white hover:bg-slate-700
    }
</style>
