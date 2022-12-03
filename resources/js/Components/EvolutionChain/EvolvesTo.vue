<script setup>

import EvolutionLayout from "@/Components/EvolutionChain/EvolutionLayout.vue";

const props = defineProps({
    variation: {
        type: Object,
    },

    evolvesTo: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <EvolutionLayout :variation="variation" />
    <EvolvesTo v-for="variation in evolvesTo" :variation="variation" :evolvesTo="variation.evolvesTo" />
</template>
