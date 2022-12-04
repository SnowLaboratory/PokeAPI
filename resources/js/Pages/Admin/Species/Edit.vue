<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { computed } from 'vue';

const props = defineProps({
    'species': {
        type: Object,
        required: true
    },
})

const species = computed( () => props.species.data)

const form = useForm({
    name: species.value.name
})

const handleSubmit = () => {
    form.post(route('admin.species.update'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.species.index'))
}


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Edit Species"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name" :error="form.errors.name"></SimpleInput>
        </SimpleForm>

    </AdminLayout>
</template>
