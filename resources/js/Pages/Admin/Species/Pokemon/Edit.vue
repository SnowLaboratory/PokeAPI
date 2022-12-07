<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleForm from '@/Components/Admin/Form/SimpleForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import SimpleInput from '@/Components/Admin/Form/SimpleInput.vue';
import { computed } from 'vue';
import { relationRoute } from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    'pokemon': {
        type: Object,
        required: true
    }
})

const pokemon = computed( () => props.pokemon.data)

const form = useForm({
    name: pokemon.value.name,
    weight: pokemon.value.weight,
    height: pokemon.value.height,
    is_default: pokemon.value.is_default,
})

const handleSubmit = () => {
    form.patch(relationRoute('admin.species.pokemon.update'))
}

const handleRedirect = () => {
    Inertia.visit(relationRoute('admin.species.pokemon.index'))
}

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Edit Variation"/>
        </template>

        <SimpleForm @submit="handleSubmit" @redirect="handleRedirect" :form="form">
            <SimpleInput label="name" v-model="form.name" :error="form.errors.name"></SimpleInput>
            <SimpleInput label="weight" v-model="form.weight" :error="form.errors.weight"></SimpleInput>
            <SimpleInput label="height" v-model="form.height" :error="form.errors.height"></SimpleInput>
            <input type="checkbox" v-model="form.is_default">
        </SimpleForm>

    </AdminLayout>
</template>
