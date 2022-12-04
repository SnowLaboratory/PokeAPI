<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Button from '@/Components/Admin/Button.vue';

const props = defineProps({
    'species': {
        type: Object,
    }
})

const columns = {
    'name': {label: 'Name'},
    'pokemon_count': {label: 'Variations'}
}

const actions = {
    'Pokemon': {
        action(species) {
            Inertia.visit(route('admin.species.pokemon.index', {species}))
        }
    },
    'Edit': {
        action(species) {
            Inertia.visit(route('admin.species.edit', {species}))
        }
    },
    'View': {
        action(species) {
            Inertia.visit(route('species', {species}))
        }
    }
}

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Species">
                <Button primary :href="route('admin.species.create')">
                    Create
                </Button>
            </Heading>
        </template>

        <PaginationTable :rows="species" :columns="columns" :actions="actions" v-slot="{row}">
            <td>{{ row.name }}</td>
            <td>
                <Link :href="route('admin.species.pokemon.index', {species: row.name})"
                    class="text-sky-600 underline">
                    {{ row.pokemon_count }}
                </Link>
            </td>
        </PaginationTable>
    </AdminLayout>
</template>
