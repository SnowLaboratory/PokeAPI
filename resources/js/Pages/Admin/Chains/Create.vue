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


const form = useForm({
    edges: [],
})

const handleSubmit = () => {
    form.post(route('admin.chains.store'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.chains.index'))
}

const graph = useGraph({})

const handleLineClick = (e) => {
    e.$line.middleLabel = LeaderLine.captionLabel({text: 'Clicked!', color: 'red'});
}

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Evolution Chain"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">

            <!-- <Graph
                @line:click="handleLineClick"
                @click.exact="graph.handleAreaClick"
                @select.stop="graph.handleSelectedNode"
                @select2.stop="graph.handleSecondSelection"
                @click.shift.exact="graph.handleShiftClick"
                :edges="graph.edges"
                class="relative w-full h-96 bg-gray-100 p-3 select-none"
                node-class="bg-emerald-500 stroke-sky-600 hover:cursor-pointer hover:bg-emerald-400 active:cursor-move"
                selected-node-class="border-2 border-slate-800"
                > -->
            <Graph :graph="graph" as="main" class="relative w-full h-96 bg-gray-100 p-3 select-none">
                <div class="w-full text-center text-zinc-400 text-sm py-6 pointer-events-none">
                    <ul class="space-y-3">
                        <li>Click to add/select node</li>
                        <li>Shift + Click to connect nodes</li>
                    </ul>
                </div>
            </Graph>

            <div>
                <!-- <SimpleInput label="name" :model-value="graph.selectedNode?.data?.name" @update:model-value="graph.dataModel($event, 'name')" :error="form.errors.name"></SimpleInput> -->
            </div>

        </SimpleForm>

    </AdminLayout>
</template>

<style>

svg.leader-line:hover {
    @apply fill-sky-300;
}

svg.leader-line:hover .leader-line-line-path {
    @apply stroke-sky-300;
}

</style>
