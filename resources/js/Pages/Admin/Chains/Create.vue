<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { onMounted, ref } from 'vue';
import LeaderLine from 'leader-line-new'


import Draggable from '@/Components/Admin/Chain/Draggable.vue';
import Node from '@/Components/Admin/Chain/Node.vue';
import Graph from '@/Components/Admin/Chain/Graph.vue';

const form = useForm({
    name: 'asdf'
})

const handleSubmit = () => {
    form.post(route('admin.chains.store'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.chains.index'))
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
                class="relative w-full h-96 bg-gray-100 p-3"
                node-class="bg-emerald-500 stroke-sky-600 hover:cursor-pointer hover:bg-emerald-400 active:cursor-move">

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
