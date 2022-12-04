<script setup>
import Cards from '@/Components/Admin/Card/Cards.vue';
import Card from '@/Components/Admin/Card/Card.vue';
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

        <Cards>
            <Card>
                <div class="text-lg pb-1">Species</div>
                <div class="text-3xl">{{ props.species }}</div>
            </Card>
            <Card>
                <div class="text-lg pb-1">Pokemon</div>
                <div class="text-3xl">{{ props.pokemon }}</div>
            </Card>
            <Card>
                <div class="text-lg pb-1">Items</div>
                <div class="text-3xl">{{ props.items }}</div>
            </Card>
        </Cards>

    </AdminLayout>
</template>
