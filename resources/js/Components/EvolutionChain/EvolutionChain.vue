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
    <div>
        <div class="flex flex-col-reverse">
            <EvolvesFrom :evolvesFrom="species.pokemon.evolvesFrom" />
        </div>

        <EvolutionLayout :variation="species.pokemon" class="bg-slate-200 rounded-full"/>
        <EvolutionLayout :variation="variation" v-for="variation in species.variations" />
        <EvolvesTo :evolvesTo="species.pokemon.evolvesTo" />
    </div>
</template>
