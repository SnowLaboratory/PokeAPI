<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { computed } from 'vue';

const props = defineProps({
    'items': {
        type: Object,
        required: true
    },
})

const item = computed( () => props.items.data)

const form = useForm({
    name: item.value.name
})

const handleSubmit = () => {
    form.post(route('admin.items.update'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.items.index'))
}

const actions = {
    'Edit': {
        action(item) {
            Inertia.visit(route('admin.items.edit', {item}))
        }
    }

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Edit Item"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name" :error="form.errors.name"></SimpleInput>
        </SimpleForm>

    </AdminLayout>
</template>
