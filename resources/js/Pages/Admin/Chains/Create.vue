<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { isRef, onMounted, ref, toRef, unref } from 'vue';
import LeaderLine from 'leader-line-new'


import Draggable from '@/Components/Admin/Chain/Draggable.vue';
import Node from '@/Components/Admin/Chain/Node.vue';
import Graph from '@/Components/Admin/Chain/Graph.vue';

const form = useForm({
    name: 'asdf'
})

const edges = ref([]);

const handleSubmit = () => {
    form.post(route('admin.chains.store'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.chains.index'))
}

const selectingNode = ref(false)
const selectedNode = ref(null);
const newIdCounter = ref(1);

const createNode = (x, y, options = {}) => {
    edges.value.push({
        p1: {
            x,y,
            id: newIdCounter.value++,
            data: {
                selected: false
            },
            // ...options
        },
        p2: null,
    })
    return edges.value[edges.value.length - 1].p1
}

const selectNode = (node) => {
    selectedNode.value = node;
    selectingNode.value = true;

    edges.value.forEach(edge => {
        _.set(edge.p1 ?? {}, 'data.selected', false)
        _.set(edge.p2 ?? {}, 'data.selected', false)
    })

    if (isRef(node.data)) {
        node.data.value.selected = !node.data.value.selected
    } else {
        node.data.selected = !node.data.selected
    }
}

const handleGraphAreaClick = (e) => {
    if (selectingNode.value) {
        e.preventDefault();
        selectingNode.value = false
        return;
    }
    const node = createNode(e.layerX - 24, e.layerY - 24)
    selectNode(node)
    selectingNode.value = false
}

const linkNodes = (p1, p2) => {
    edges.value.push({p1, p2})
}

const handleShiftClick = (e) => {
    if (selectedNode.value) {
        const node = createNode(e.layerX - 24, e.layerY - 24)
        setTimeout(() => {
            linkNodes(selectedNode.value, node)
            selectNode(node)
            selectingNode.value = false
        }, 1)
    }
}

const handleSelectedNode = (e) => {
    selectNode(e.$node)
}

const handleSecondSelection = (e) => {
    linkNodes(selectedNode.value, e.$node)
    selectNode(e.$node)
    selectingNode.value = false
}

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

            <Graph
                @line:click="handleLineClick"
                @click.exact="handleGraphAreaClick"
                @select.stop="handleSelectedNode"
                @select2.stop="handleSecondSelection"
                @click.shift.exact="handleShiftClick"
                :edges="edges"
                class="relative w-full h-96 bg-gray-100 p-3 select-none"
                node-class="bg-emerald-500 stroke-sky-600 hover:cursor-pointer hover:bg-emerald-400 active:cursor-move"
                selected-node-class="border-2 border-slate-800"
                >

                <div class="w-full text-center text-zinc-400 text-sm py-6">
                    <ul class="space-y-3">
                        <li>Click to add/select node</li>
                        <li>Shift + Click to connect nodes</li>
                    </ul>
                </div>

            </Graph>

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
