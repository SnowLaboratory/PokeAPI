<script setup>

import EvolvesFrom from "@/Components/EvolutionChain/EvolvesFrom.vue";
import EvolvesTo from "@/Components/EvolutionChain/EvolvesTo.vue";
import EvolutionLayout from "@/Components/EvolutionChain/EvolutionLayout.vue";


const props = defineProps({
    species: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="flex flex-wrap">
        <div class="flex flex-row-reverse">
            <EvolvesFrom :evolvesFrom="species.pokemon.evolvesFrom" />
        </div>

        <EvolutionLayout :variation="species.pokemon" class="bg-slate-200 rounded-full"/>
        <EvolvesTo :evolvesTo="species.pokemon.evolvesTo" />
    </div>
</template>
