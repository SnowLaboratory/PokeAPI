<script setup>

import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    variation: {
        type: Object,
    },
});

</script>

<template>
    <Link :href="route('species', {species: variation.species})" class="block w-36 h-36 relative" v-if="variation">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <img
                    class="w-20 mx-auto"
                    :src="variation.images[0].url"
                />
                <span>{{ variation.name }}</span>
            </div>
        </div>
    </Link>
</template>
