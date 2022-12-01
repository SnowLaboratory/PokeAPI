<script setup>

const props = defineProps({
    'formatAsArray' : {
        type: Boolean,
        default: false,
    }
})


</script>

<template>
    <div :class="{'text-orange-500': props.formatAsArray}">
        <!-- <span v-if="props.formatAsArray">[</span> -->
        <span >
            <slot></slot>
        </span>

        <!-- <span v-if="props.formatAsArray">]</span> -->
        <span class="">:</span>
    </div>
</template>
