<script setup>

import EvolutionLayout from "@/Components/EvolutionChain/EvolutionLayout.vue";

const props = defineProps({
    species: {
        type: Object,
    },

    evolvesTo: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div>
        <EvolutionLayout :species="species" />
        <EvolvesTo v-for="evolution in evolvesTo" :species="evolution.species" :evolvesTo="evolution.evolvesTo" />
    </div>
</template>
