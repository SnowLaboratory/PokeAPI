<script setup>
import DefaultColumns from './DefaultColumns.vue';
import DefaultRows from './DefaultRows.vue';
import DefaultContent from './DefaultContent.vue';


const props = defineProps({
    'rows': {
        type: Array,
        default: []
    },
    'columns': {
        type: Object,
        default: {
            'name': {}
        }
    },
    'actions': {
        type: Object,
        default: {
            'edit': {},
            'delete': {},
        }
    }
})

</script>

<template>
    <table class="w-full border-collapse border-spacing-0">
        <tbody class="divide-y divide-gray-400">
            <tr>
                <th class="text-left w-6"></th>

                <slot name="columns">
                    <DefaultColumns :columns="props.columns" />
                </slot>
                <th class="w-12"></th>
            </tr>
            <slot name="rows">
                <DefaultRows v-bind="props" v-slot="{row}">
                    <slot :row="row">
                        <DefaultContent :columns="props.columns" :row="row"/>
                    </slot>
                </DefaultRows>
            </slot>
        </tbody>
    </table>
</template>
