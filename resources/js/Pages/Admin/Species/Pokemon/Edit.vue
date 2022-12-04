<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { computed } from 'vue';

const props = defineProps({
    'pokemon': {
        type: Object,
        required: true
    }
})

const pokemon = computed( () => props.pokemon.data)

const form = useForm({
    name: pokemon.value.name
})

const handleSubmit = () => {
    form.post(route('admin.species.pokemon.update'))
}

const handleRedirect = () => {
    Inertia.visit(route('admin.species.pokemon.index'))
}


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Edit Variation"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name" :error="form.errors.name"></SimpleInput>
        </SimpleForm>

    </AdminLayout>
</template>
