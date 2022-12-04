<script setup>
</script>

<template>
    <ul class="admin-navigation">
        <slot></slot>
    </ul>
</template>

<style>
    .admin-navigation > * {
        @apply py-1 px-3 hover:bg-gray-100 cursor-pointer text-right block rounded
    }
    .admin-navigation > .active {
        @apply bg-slate-900 text-white
    }
</style>
