<script setup>

import {getCurrentInstance, onMounted, ref} from 'vue'
import interact from 'interactjs'
import Draggable from './Draggable.vue';

const emit = defineEmits([
    'update:position',
    'selected',
])

const props = defineProps({
    position: {
        type: Object,
        default: null,
    },
    locked: {
        type: Boolean,
        default: false,
    },
    bounds: {
        type: Object,
        default: null,
    },
})


const internalPos = ref(props.position ?? {
    x: 0,
    y: 0,
})

const handleSelect = () => {
    if (!props.locked) {
        emit('selected')
    }
}

onMounted(() => {
    console.log('node component', getCurrentInstance())
})

</script>

<template>
    <Draggable
        @click="handleSelect"
        :bounds="props.bounds"
        :locked="props.locked"
        v-model:position="internalPos"
        @update:position="$emit('update:position', internalPos)">
        <slot></slot>
    </Draggable>
</template>
