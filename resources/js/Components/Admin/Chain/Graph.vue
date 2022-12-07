<script setup>

import {computed, createApp, getCurrentInstance, onMounted, ref, watch} from 'vue'
import Node from './Node.vue';
import LeaderLine from 'leader-line-new'

const emit = defineEmits([
    'move',
    'select',
    'select2'
])


const props = defineProps({
    selectedNodeClass: {
        type: String,
        default: '',
    },
    nodeClass: {
        type: String,
        default: "bg-emerald-300 stroke-slate-600"
    },
    edges: {
        type: Array,
        default: [],
    }
})

const el = ref(null);
const nodeIds = ref(1)
const uniqueNodes = computed(() => (
    _.chain(props.edges)
    .map('p1')
    .concat(_.map(props.edges, 'p2'))
    .map(point => {
        if (!point) return null;

        const id = ++nodeIds.value
        return {
            position: {
                x: point.x,
                y: point.y,
            },
            id: point?.id || id,
            edges: {},
            data: ref(point?.data ?? {}),
        }
    })
    .filter()
    .uniqBy('id')
    .keyBy('id')
    .value()
));


const edges = computed(() => (
    _.chain(props.edges)
    .map((x, id) => ({...x, id: id + 1}))
    .value()
))

const lines = ref({})
const lineEls = ref({})
const attrs = ref(getCurrentInstance().attrs)

const updateEdges = () => {
    edges.value.forEach(edge => {

        if (!edge.p1?.id || !edge.p2?.id) return;

        const n1 = uniqueNodes.value[edge.p1.id]
        n1.edges[edge.id] = edge;

        const n2 = uniqueNodes.value[edge.p2.id]
        n2.edges[edge.id] = edge;

        const p1 = el.value.querySelector(`[data-id="${edge.p1.id}"]`);
        const p2 = el.value.querySelector(`[data-id="${edge.p2?.id}"]`);

        const line = lines.value[edge.id] ?? new LeaderLine(p1, p2)

        if (!lineEls[edge.id]) {
            const lineEl = document.body.querySelector(':scope>svg.leader-line:last-of-type');

            const prefix = 'onLine:'
            for (let key in attrs.value) {
                if (key.startsWith(prefix)) {
                    const event = key.slice(prefix.length);
                    lineEl.addEventListener(event, e => {
                        e.$line = line
                        e.$el = lineEl
                        attrs.value[key].call(undefined, e)
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

const handleSelect = (e, point) => {
    if (!props.locked) {
        const data = e.$node.data
        e.$node = {
            ...e.$node,
            ...point,
            data
        }
        e.$node.data.value.selected = !e.$node.data.value.selected
        emit('select', e)
    }
}

const handleSelect2 = (e, point) => {
    if (!props.locked) {
        e.$node = point
        e.$node.data.value.selected = !e.$node.data.value.selected
        emit('select2', e)
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
                  @select="handleSelect($event, point)"
                  @click.shift.exact="handleSelect2($event, point)"
                  v-model:position="point.position"
                  :data-id="point.id"
                  @update:position="handleUpdate(point)"
                  class="absolute h-6 w-6 rounded-full"
                  :class="[nodeClass, {[selectedNodeClass]: point.data.value.selected}]"
                  :data="point.data"
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
