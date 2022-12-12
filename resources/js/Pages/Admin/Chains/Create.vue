<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';

import LeaderLine from 'leader-line-new'


import Draggable from '@/Components/Admin/Chain/Draggable.vue';
import Node from '@/Components/Admin/Chain/Node.vue';
import Graph from '@/Components/Admin/Chain/Graph.vue';
import { useGraph } from '@/Composables/Admin/useGraph';
import { computed } from 'vue';



const handleSubmit = () => {
    form.post(route('admin.chains.store'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.chains.index'))
}

const form = useForm({
    edges: {},
    nodes: {
        1: {
            id: 1,
            position: {x: 50, y: 50},
            data: {},
            meta: {selected: true},
            data: {
                name: 'asdf'
            }
        },
        2: {
            id: 2,
            position: {x: 100, y: 100},
            data: {},
            meta: {selected: false}
        }
    },
})

const graph = useGraph({
    nodes: form.nodes,
    edges: form.edges,
    onAfterAddNode(node) {
        form.nodes = {
            ...form.nodes,
            [node.id]: node
        }
    },
    onAfterAddLink(edge) {
        form.edges = {
            ...form.edges,
            [edge.id]: edge
        }
    }
})

graph.selectNode(1)


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Evolution Chain"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">

            <Graph :graph="graph" as="main"
                @line:click="handleLineClick"
                class="relative w-full h-96 bg-gray-100 p-3 select-none"
                node-class="bg-emerald-500 stroke-emerald-600 hover:cursor-pointer hover:bg-emerald-400 active:cursor-move ring-2"
                selected-node-class="ring-black hover:ring-slate-800"
                unselected-node-class="ring-emerald-600 hover:ring-emerald-500"
                >
                <div class="w-full text-center text-zinc-400 text-sm py-6 pointer-events-none">
                    <ul class="space-y-3">
                        <li>Click to add/select node</li>
                        <li>Shift + Click to connect nodes</li>
                    </ul>
                </div>
            </Graph>

            <div class="space-y-3 mt-3">

                <template v-if="graph.selectedNode">
                    <h1 class="text-lg font-bold">Node Data</h1>
                    <SimpleInput label="name"
                        :model-value="graph.selectedNode?.data?.name"
                        @update:model-value="graph.nodeModel($event, 'name')"
                        :error="form.errors.name"></SimpleInput>
                </template>

                <template v-if="graph.selectedEdge">
                    <h1 class="text-lg font-bold">Edge Data</h1>
                    <SimpleInput label="name"
                        :model-value="graph.selectedEdge?.data?.name"
                        @update:model-value="graph.edgeModel($event, 'name')"
                        :error="form.errors.name"></SimpleInput>
                </template>
            </div>

        </SimpleForm>

    </AdminLayout>
</template>

<style>
svg.leader-line {
    fill: theme('colors.emerald.600') !important;
}

svg.leader-line.selected,
svg.leader-line:hover {
    fill: theme('colors.emerald.800') !important;
    @apply cursor-pointer;
}
svg.leader-line.selected linearGradient > stop,
svg.leader-line:hover linearGradient > stop{
    stop-color: theme('colors.emerald.800') !important;
}

</style>
