<script setup>
import { computed } from "vue";
import Card from "@/Components/Card.vue";
import Container from "@/Components/Container.vue";
import Variation from "@/Components/Variation/Variation.vue";
import EvolutionChain from "@/Components/EvolutionChain/EvolutionChain.vue";
import DamageRelation from "@/Components/DamageRelation/DamageRelation.vue";

const props = defineProps({
    species: {
        type: Object,
        required: true,
    },
});

const species = computed(() => props.species);
console.log(species);
</script>

<template>
    <Container>
        <div class="flex items-start space-x-8 mt-8">
            <div class="w-1/3">
                <div class="bg-slate-200 rounded-xl">
                    <img
                    class="w-full"
                    :src="species.pokemon.images[0].storage_url"
                />
                </div>
                <div class="capitalize font-bold text-center text-xl">
                    {{ species.name }}
                </div>
                <div class="text-lg">
                    height: {{ species.pokemon.height }}
                </div>
                <div class="text-lg">
                    weight: {{ species.pokemon.weight }}
                </div>
            </div>
            <div class="space-y-8 w-2/3">
                <Card :has-external-heading="true">
                    <template #header>Evolution Chain</template>
                    <EvolutionChain />
                </Card>

                <Card :has-external-heading="true">
                    <template #header>Damage Relations</template>
                    <DamageRelation />
                </Card>

                <Card :has-external-heading="true" v-if="species.variations.length">
                    <template #header>Variations</template>
                    <div class="flex flex-wrap">
                        <Variation :variation="variation" v-for="variation in species.variations"/>
                    </div>
                </Card>
            </div>
        </div>
    </Container>
</template>
