<script setup>

import {computed, onMounted, ref} from 'vue'
import interact from 'interactjs'
import Draggable from './Draggable.vue';
import Node from './Node.vue';

const emit = defineEmits([
    'move',
    'selected',
])

const props = defineProps({
    edges: {
        type: Array,
        default: [
            {
                data: {},
                p1: {x: 20, y: 30, id:1},
                p2: {x: 0, y: 0, id:2},
            },
            {
                data: {},
                p1: {x: 0, y: 0, id:1},
                p2: {x: 0, y: 0, id:3},
            },
        ],
    }
})

const el = ref(null);

const uniqueNodes = _.chain(props.edges)
    .map('p1')
    .concat(_.map(props.edges, 'p2'))
    .uniqBy('id')
    .value()

const edges = ref(props.edges)

const handleSelect = () => {
    if (!props.locked) {
        emit('selected')
    }
}

const bounds = computed(() => ({
    top: el.value?.getBoundingClientRect().top,
    left: el.value?.getBoundingClientRect().left,
    right: el.value?.getBoundingClientRect().right,
    bottom: el.value?.getBoundingClientRect().bottom,
}))

</script>

<template>
    <div ref="el">
        <template v-for="point in uniqueNodes">
            <Node :bounds="bounds"
                  :position="point"
                  class="absolute h-6 w-6 bg-red-400 rounded-full stroke-blue-500"
                />
        </template>
        <slot></slot>
    </div>
</template>
