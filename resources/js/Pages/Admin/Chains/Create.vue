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


const pos = ref({x:0, y:0})
// const p1 = ref(null)
// const p2 = ref(null)

// const pos = ref({
//     x: 0,
//     y: 0,
// })

// onMounted(() => {
//     console.log(p1.value, p2.value)
//     const line = new LeaderLine(p1.value, p2.value)

//     const lineElement = document.body.querySelector(':scope>svg.leader-line:last-of-type');

//     lineElement.classList.add('stroke-blue-500', 'stroke-[8]')


//     console.log(parseInt(getComputedStyle(lineElement).strokeWidth))
//     line.color = getComputedStyle(lineElement).stroke
//     line.size = parseInt(getComputedStyle(lineElement).strokeWidth)

//     lineElement.classList.remove('stroke-[8]')

//     interact(p1.value).draggable({
//         listeners: {
//             move (event) {
//                 console.log(line)
//                 pos.value.x += event.dx;
//                 pos.value.y += event.dy;
//                 event.target.style.transform =
//                     `translate(${pos.value.x}px, ${pos.value.y}px)`
//                 line.position();
//             },
//         },
//     })
// })

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Evolution Chain"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">

            <Graph class="relative w-full h-96 bg-gray-100 p-3">
                Put graph editor here
            </Graph>

        </SimpleForm>

    </AdminLayout>
</template>
