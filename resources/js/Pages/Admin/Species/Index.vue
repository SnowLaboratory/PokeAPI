<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    'species': {
        type: Object,
    }
})

const columns = {
    'name': {label: 'Name'},
    'pokemon_count': {label: 'Variations'}
}

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Species" />
        </template>

        <PaginationTable :rows="species" :columns="columns" v-slot="{row}">
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
