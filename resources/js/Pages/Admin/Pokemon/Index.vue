<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Heading from '@/Components/Admin/Heading.vue';


</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Pokemon" />
        </template>
        <div v-for="i in 100">
            Hello Pokemon
        </div>
    </AdminLayout>
</template>
