<script setup>
import Heading from '@/Components/Admin/Heading.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
    'species': Number,
    'pokemon': Number,
    'items': Number,
})

</script>

<template>
    <AdminLayout>
        <template #heading>
            <Heading label="Dashboard" />
        </template>

        <div class="flex flex-wrap -mx-2 -mt-2">
            <div class="w-full md:w-1/3 sm:w-1/2 px-2 pt-2">
                <div class="border border-slate-500 rounded-lg p-3">
                    <div class="text-lg pb-1">Species</div>
                    <div class="text-3xl">{{ props.species }}</div>
                </div>
            </div>
            <div class="w-full md:w-1/3 sm:w-1/2 px-2 pt-2">
                <div class="border border-slate-500 rounded-lg p-3">
                    <div class="text-lg pb-1">Pokemon</div>
                    <div class="text-3xl">{{ props.pokemon }}</div>
                </div>
            </div>
            <div class="w-full md:w-1/3 sm:w-1/2 px-2 pt-2">
                <div class="border border-slate-500 rounded-lg p-3">
                    <div class="text-lg pb-1">Items</div>
                    <div class="text-3xl">{{ props.items }}</div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
