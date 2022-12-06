<script setup>

import {computed, createApp, getCurrentInstance, onMounted, ref, watch} from 'vue'
import interact from 'interactjs'
import Draggable from './Draggable.vue';
import Node from './Node.vue';
import LeaderLine from 'leader-line-new'
import LineVue from './Line.vue';

const emit = defineEmits([
    'move',
    'selected',
])


const props = defineProps({
    nodeClass: {
        type: String,
        default: "bg-emerald-300 stroke-slate-600"
    },
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

const uniqueNodes = computed(() => (
    _.chain(props.edges)
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
            edges: {},
            data: {},
        }
    })
    .value()
));


const edges = computed(() => (
    _.chain(props.edges)
    .map((x, id) => ({...x, id: id + 1}))
    .value()
))

const lines = ref({})
const lineEls = ref({})

const updateEdges = () => {
    edges.value.forEach(edge => {
        console.log({edge})

        const n1 = uniqueNodes.value[edge.p1.id]
        n1.edges[edge.id] = edge;

        const n2 = uniqueNodes.value[edge.p2.id]
        n2.edges[edge.id] = edge;

        console.log({n1,n2})

        const p1 = el.value.querySelector(`[data-id="${edge.p1.id}"]`);
        const p2 = el.value.querySelector(`[data-id="${edge.p2.id}"]`);

        const line = lines.value[edge.id] ?? new LeaderLine(p1, p2)

        if (!lineEls[edge.id]) {
            const lineEl = document.body.querySelector(':scope>svg.leader-line:last-of-type');

            const attrs = getCurrentInstance().attrs;
            const prefix = 'onLine:'
            for (let key in attrs) {
                if (key.startsWith(prefix)) {
                    const event = key.slice(prefix.length);
                    lineEl.addEventListener(event, e => {
                        e.$line = line
                        e.$el = lineEl
                        attrs[key].call(undefined, e)
                    })
                }
            }

            lineEls[edge.id] = edge.id
        }

        line.startPlugColor = getComputedStyle(p1).stroke
        line.endPlugColor = getComputedStyle(p2).stroke
        line.gradient = true
        lines.value[edge.id] = line;

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
    for (let edgeId in point.edges) {
        lines.value[edgeId].position()
    }
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
                  class="absolute h-6 w-6 rounded-full"
                  :class="[nodeClass]"
                />
                <!-- {{ point.value.id }} -->
        </template>
        <slot></slot>
    </div>
</template>

<style>
    svg.leader-line {
        pointer-events: none !important;
    }

    svg.leader-line .leader-line-line-path {
        pointer-events: stroke !important;
    }

    svg.leader-line use[href^="#leader-line-arrow"] {
        pointer-events: fill !important;
    }

    svg.leader-line:hover use[href^="#leader-line-arrow"] {
        fill:inherit !important;
    }

    svg.leader-line:hover {
        fill: blue;
        cursor: pointer;
    }

    svg.leader-line:hover .leader-line-line-path {
        stroke: blue;
        cursor: pointer;
    }
</style>
