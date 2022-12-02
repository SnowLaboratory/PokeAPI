<script setup>

const props = defineProps({
    species: {
        type: Object,
    },
});

</script>

<template>
    <div class="w-1/3 p-3 text-center" v-if="species">
        <img
            class="max-w-[5rem] mx-auto"
            :src="species.pokemon.images[0].url"
        />
        <span class="text-center"> {{ species.name }}</span>
    </div>
</template>
