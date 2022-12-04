<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import { computed, ref } from 'vue';
import SimpleTable from '@/Components/Admin/Table/SimpleTable.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';

const props = defineProps({
    'species': {
        type: Object,
    }
})



</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Species" />
        </template>

        <PaginationTable :rows="species"/>
    </AdminLayout>
</template>
