<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Create Species" />
        </template>
        <div v-for="i in 100">
            Hello Species Create
        </div>
    </AdminLayout>
</template>
