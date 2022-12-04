<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import SimpleTable from '@/Components/Admin/Table/SimpleTable.vue';

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

        <SimpleTable :rows="species.data">

        </SimpleTable>
    </AdminLayout>
</template>
