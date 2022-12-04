<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';

const props = defineProps({
    'items': {
        type: Object,
    }
})
</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Items" />
        </template>

        <PaginationTable :rows="items"/>
    </AdminLayout>
</template>
