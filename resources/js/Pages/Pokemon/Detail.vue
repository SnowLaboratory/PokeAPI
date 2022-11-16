<script setup>
import { usePage } from '@inertiajs/inertia-vue3';

const species = usePage().props.value.species;
console.log(species)
</script>

<template>
    <h1>Hello <span class="font-bold">{{ species.name }}</span></h1>
</template>
