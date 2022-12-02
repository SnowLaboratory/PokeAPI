<script setup>

import EvolutionLayout from "@/Components/EvolutionChain/EvolutionLayout.vue";


const props = defineProps({
    species: {
        type: Object,
    },

    evolvesFrom: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div>
        <EvolutionLayout :species="species" />
        <EvolvesFrom v-for="evolution in evolvesFrom" :species="evolution.species" :evolvesFrom="evolution.evolvesFrom" />
    </div>
</template>
