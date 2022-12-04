<script setup>

const props = defineProps({
    'columns': {
        type: Object,
        default: {
            'name': {},
        }
    },
    'row': {
        type: Object,
    }
})

</script>

<template>
    <template v-for="(value, columnName) in row">
        <td class="text-left leading-loose" v-if="(columnName in props.columns)">{{ value }}</td>
    </template>
</template>
