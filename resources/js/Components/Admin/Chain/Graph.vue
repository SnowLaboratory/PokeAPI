<script setup>

import {computed, getCurrentInstance, onMounted, ref, watch} from 'vue'
import interact from 'interactjs'
import Draggable from './Draggable.vue';
import Node from './Node.vue';
import LeaderLine from 'leader-line-new'

const emit = defineEmits([
    'move',
    'selected',
])

// function defineRefs(refs) {
//   return _.chain(refs).keyBy().mapValues(ref).value();
// }

const props = defineProps({
    edges: {
        type: Array,
        default: [
            {
                data: {},
                p1: {x: 20, y: 30, id:11},
                p2: {x: 0, y: 0, id:21},
            },
            {
                data: {},
                p1: {x: 0, y: 0, id:11},
                p2: {x: 0, y: 0, id:31},
            },
        ],
    }
})

const el = ref(null);

const nodeRefs = ref([])

const uniqueNodes = _.chain(props.edges)
    .map('p1')
    .concat(_.map(props.edges, 'p2'))
    .uniqBy('id')
    .keyBy('id')
    .mapValues(point => {
        return {
            position: {
                x: point.x,
                y: point.y,
            },
            id: point.id,
            data: {},
        }
    })
    .value()

    console.log(uniqueNodes)
    // console.log(_.map(uniqueNodes, x => `point_${x.id}`))

// const inputs = defineRefs(_.map(uniqueNodes, x => `point_${x.id}`))

// const nodes = ref([])

const edges = computed(() => props.edges)
const updateEdges = () => {
    edges.value.forEach(edge => {
        // console.log()
        const p1 = el.value.querySelector(`[data-id="${edge.p1.id}"]`);
        const p2 = el.value.querySelector(`[data-id="${edge.p2.id}"]`);

        // console.log(p1)
        edge.line = edge.line ?? new LeaderLine(
            p1, p2
        )
        edge.line.startPlugColor = getComputedStyle(p1).stroke
        edge.line.endPlugColor = getComputedStyle(p2).stroke
        edge.line.gradient = true
    })
}

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

const handleUpdate = (point) => {
    edges.value.filter(edge => {
        return edge.p1.id === point.id
        || edge.p2.id === point.id
    }).forEach(edge => {
        edge.line.position()
    })
}

onMounted(() => {
    updateEdges()
})

watch(edges, (newValue) => {
    if (newValue) updateEdges()
})

</script>

<template>
    <div ref="el">
        <template v-for="(point,id) in uniqueNodes">
                <Node :bounds="bounds"
                  v-model:position="point.position"
                  :data-id="point.id"
                  @update:position="handleUpdate(point)"
                  class="absolute h-6 w-6 bg-emerald-400 rounded-full stroke-slate-600"
                />
                <!-- {{ point.value.id }} -->
        </template>
        <slot></slot>
    </div>
</template>
