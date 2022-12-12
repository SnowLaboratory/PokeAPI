<script setup>

import {computed, createApp, getCurrentInstance, onMounted, ref, watch} from 'vue'
import Node from './Node.vue';
import LeaderLine from 'leader-line-new'
import { useGraph } from '@/Composables/Admin/useGraph';

const emit = defineEmits([
    'move',
    'select',
    'select2'
])


const props = defineProps({
    selectedNodeClass: {
        type: String,
        default: 'ring-black',
    },
    nodeClass: {
        type: String,
        default: "bg-emerald-300 stroke-slate-600 ring-2"
    },
    unselectedClass: {
        type: String,
        default: "ring-emerald-600"
    },
    as: {
        type: String,
        default: 'div',
    },
    graph: {
        type: Object,
        default: useGraph({})
    }
})

const el = ref(null);
const graph = computed(() => props.graph)
const attrs = ref(getCurrentInstance().attrs)

const bounds = computed(() => ({
    top: el.value?.getBoundingClientRect().top,
    left: el.value?.getBoundingClientRect().left,
    right: el.value?.getBoundingClientRect().right,
    bottom: el.value?.getBoundingClientRect().bottom,
}))


const createNewNode = (e) => {
    graph.value.addNode(e.offsetX, e.offsetY)
}

const vBindLineElement = (edge) => {
    const prefix = 'onLine:'
    for (let key in attrs.value) {
        if (key.startsWith(prefix)) {
            const event = key.slice(prefix.length);
            edge.meta.lineElement.addEventListener(event, e => {
                e.$line = edge.meta.line
                e.$el = edge.meta.lineElement
                e.$edge = edge
                attrs.value[key].call(undefined, e)
            })
            edge.meta.lineElement.addEventListener(event, e => {
                graph.value.selectEdge(edge.id)
            })
        }
    }
}

watch(graph.value.selectedEdgeRef, (newValue, oldValue) => {
    if (newValue) {
        newValue.meta.lineElement.classList.add('selected')
    }
    if (oldValue) {
        oldValue.meta.lineElement.classList.remove('selected')
    }
})

const createLineElement = (edge) => {
    const p1 = el.value.querySelector(`[data-id="${edge.parent.id}"]`);
    const p2 = el.value.querySelector(`[data-id="${edge.child.id}"]`);

    const line = edge.meta.line ?? new LeaderLine(p1, p2, {hide:true})

    if (!edge.meta.lineElement) {
        const lineEl = document.body.querySelector(':scope>svg.leader-line:last-of-type');
        edge.meta.lineElement = lineEl
        vBindLineElement(edge)
    }

    line.startPlugColor = getComputedStyle(p1).stroke
    line.endPlugColor = getComputedStyle(p2).stroke
    line.gradient = true
    line.path = 'fluid'
    line.size = 6;
    line.startPlugSize = 0.6;
    line.endPlugSize = 0.6;
    line.dash = {
        animation: {
            duration: 750,
            timing: 'linear'
        }
    }
    line.show('draw', {duration: 150, timing: 'ease-in-out'})
    edge.meta.line = line;
}

const linkNodes = (n1, n2) => {
    const edge = graph.value.linkNodes(n1, n2)
    n1.meta.edges = {
        ...n1.meta.edges,
        [edge.id]: edge
    };
    n2.meta.edges = {
        ...n2.meta.edges,
        [edge.id]: edge
    };
    setTimeout(() => {
        createLineElement(edge)
        graph.value.selectNode(n2.id)
    }, 1)
}

const linkNewNode = (e) => {
    const previousNode = graph.value.selectedNode
    const newNode = graph.value.addNode(e.offsetX, e.offsetY)
    if (previousNode) {
        linkNodes(previousNode, newNode)
    }
}

const linkExistingNode = (existingNode) => {
    const previousNode = graph.value.selectedNode
    if (previousNode) {
        linkNodes(previousNode, existingNode)
    }
}

const updateNodePosition = (node) => {
    for (let edgeId in node.meta.edges ?? {}) {
        const edge = node.meta.edges[edgeId]
        edge.meta.line.position()
    }
}

</script>

<template>
    <component ref="el" :is="as"
        @click.exact="createNewNode"
        @click.shift.exact="linkNewNode"
        >
        <template v-for="(node,id) in graph.nodes">
                <Node :bounds="bounds"
                    v-model:position="node.position"
                    @select="graph.selectNode(id)"
                    @click.exact.stop=""
                    @click.shift.exact.stop="linkExistingNode(node)"
                    @update:position="updateNodePosition(node)"
                >
                    <div :data-id="node.id"
                        class="absolute h-6 w-6 rounded-full -translate-x-full -translate-y-full"
                        :class="[nodeClass, {
                            [selectedNodeClass]: graph.selectedNode?.id === node.id,
                            [unselectedClass]: graph.selectedNode?.id !== node.id
                        }]">
                    </div>
                </Node>
        </template>
        <slot></slot>
    </component>
</template>

<style>
    svg.leader-line {
        pointer-events: none !important;
    }

    svg.leader-line .leader-line-line-path {
        pointer-events: stroke !important;
    }

    svg.leader-line use[href^="#leader-line-arrow"] {
        fill: inherit !important;
        pointer-events: fill !important;
    }

    svg.leader-line:hover use[href^="#leader-line-arrow"] {
        fill:inherit !important;
    }

</style>
