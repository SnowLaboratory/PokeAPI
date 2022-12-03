<script setup>

import EvolutionLayout from "@/Components/EvolutionChain/EvolutionLayout.vue";


const props = defineProps({
    variation: {
        type: Object,
    },

    evolvesFrom: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <EvolutionLayout :variation="variation" />
    <EvolvesFrom v-for="variation in evolvesFrom" :variation="variation" :evolvesFrom="variation.evolvesFrom" />
</template>
