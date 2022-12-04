<script setup>

const props = defineProps({
    'columns': {
        type: Object,
        default: {
            'name': {},
        }
    }
})

</script>

<template>
    <th class="text-left" v-for="(settings, column) in columns">
        {{ settings.label ?? column }}
    </th>
</template>
