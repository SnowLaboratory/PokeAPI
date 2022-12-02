<script setup>
const props = defineProps({
    variation: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="w-1/3 p-3 text-center">
        <img class="max-w-[5rem] mx-auto" :src="variation.images[0].url" />
        <span class="text-center"> {{ variation.formatted_name }}</span>
    </div>
</template>
