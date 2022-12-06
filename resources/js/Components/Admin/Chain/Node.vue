<script setup>

import {getCurrentInstance, onMounted, ref} from 'vue'
import interact from 'interactjs'
import Draggable from './Draggable.vue';

const emit = defineEmits([
    'update:position',
    'select',
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
    data: {
        type: Object,
        default: {}
    }
})


const internalPos = ref(props.position ?? {
    x: 0,
    y: 0,
})

const handleSelect = (e) => {
    if (!props.locked) {
        e.$node = {
            data: props.data
        }
        emit('select', e)
    }
}

</script>

<template>
    <Draggable
        @mousedown.exact="handleSelect"
        :bounds="props.bounds"
        :locked="props.locked"
        v-model:position="internalPos"
        @update:position="$emit('update:position', internalPos)">
        <slot></slot>
    </Draggable>
</template>
