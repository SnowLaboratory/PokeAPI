<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';
import PaginationTable from '@/Components/Admin/Table/PaginationTable.vue';
import Button from '@/Components/Admin/Button.vue'

const props = defineProps({
    'chains': {
        type: Object,
    }
})
</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Evolution Chains">
                <Button primary :href="route('admin.chains.create')">
                    New Chain
                </Button>
            </Heading>
        </template>

        <PaginationTable :rows="chains">
            <td>Chain</td>
        </PaginationTable>
    </AdminLayout>
</template>
