<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';

const form = useForm({
    name: 'asdf'
})

const handleSubmit = () => {
    form.post(route('admin.species.store'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.species.index'))
}


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Species" />
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name"></SimpleInput>
        </SimpleForm>

    </AdminLayout>
</template>
