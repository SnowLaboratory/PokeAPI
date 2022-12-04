<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';

const form = useForm({
    name: '',
    weight: '',
    height: '',
    is_default: false,
})

const handleSubmit = () => {
    form.post(route('admin.species.pokemon.store', route().params))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.species.pokemon.index'))
}


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Pokemon"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name" :error="form.errors.name"></SimpleInput>
            <SimpleInput label="weight" v-model="form.weight" :error="form.errors.weight"></SimpleInput>
            <SimpleInput label="height" v-model="form.height" :error="form.errors.height"></SimpleInput>
            <input type="checkbox" v-model="form.is_default">
        </SimpleForm>

    </AdminLayout>
</template>
