<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Button from '@/Components/Admin/Button.vue';

const props = defineProps({
    'pokemon': {
        type: Object,
    },

    'species': {
        type: Object,
    }
})

const columns = {
    'name': {label: 'Name'},
    'species': {label: 'Species'}
}

const actions = {
    'edit': {
        action(pokemon) {
            Inertia.visit(route('admin.species.pokemon.edit', {
                species: pokemon.species,
                pokemon: pokemon
            }))
        }
    },

    'view': {
        action(pokemon) {
            Inertia.visit(route('species', {species: pokemon.species}))
        }
    }
}

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Pokemon">
                <Button v-if="species" primary :href="route('admin.species.pokemon.create', route().params)">
                    Create
                </Button>
            </Heading>
        </template>

        <PaginationTable :rows="pokemon" :columns="columns" :actions="actions" v-slot="{row}">
            <td class="text-left leading-loose">{{ row.name }}</td>
            <td class="text-left leading-loose">
                <Link :href="route('admin.species.index')" class="text-sky-600 underline">
                    {{ row.species.name }}
                </Link>
            </td>
        </PaginationTable>
    </AdminLayout>
</template>
