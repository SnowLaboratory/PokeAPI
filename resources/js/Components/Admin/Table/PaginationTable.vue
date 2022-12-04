<script setup>

import { computed, getCurrentInstance, getCurrentScope, ref } from 'vue';
import Button from '@/Components/Admin/Button.vue';
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { Link } from '@inertiajs/inertia-vue3';
import SimpleTable from '@/Components/Admin/Table/SimpleTable.vue';
import DefaultColumns from './DefaultColumns.vue';
import DefaultRows from './DefaultRows.vue';
import DefaultContent from './DefaultContent.vue';

const props = defineProps({
    'rows': {
        type: Object,
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

const meta = computed(() => props.rows.meta)

// const slotts = computed(() => getCurrentInstance()?.subTree?.component?.slots)

// console.log(slotts)


</script>

<template>
    <SimpleTable :actions="props.actions" :columns="props.columns" :rows="props.rows.data">
        <template #columns>
            <slot name="columns">
                <DefaultColumns :columns="props.columns" />
            </slot>
        </template>
        <template #rows>
            <slot name="rows">
                <DefaultRows :actions="props.actions" :columns="props.columns" :rows="props.rows.data" v-slot="{ row }">
                    <slot :row="row">
                        <DefaultContent :columns="props.columns" :row="row" />
                    </slot>
                </DefaultRows>
            </slot>
        </template>
    </SimpleTable>

    <div class="flex justify-between items-end mt-4 flex-row-reverse">
        <div class="flex items-end space-x-1 text-[0.75rem]">
            <template v-for="page in meta.links">
                <template v-if="!page.label.includes('...')">
                    <Link :href="page.url"
                        class=" flex items-center justify-center border rounded px-2 py-1 min-w-[1.25rem] h-[1.5rem]"
                        :class="{
                            'border-gray-500': page.url,
                            'bg-slate-900 text-white': page.active,
                            'hover:bg-gray-100 cursor-pointer': !page.active && page.url,
                            'cursor-default opacity-70 border-gray-200': !page.url
                        }" as="button" :disabled="!page.url">
                    <template v-if="page.label.includes('Previous')">
                        <span>
                            <ChevronDoubleLeftIcon class="w-3" />
                        </span>
                    </template>
                    <template v-else>
                        <template v-if="page.label.includes('Next')">
                            <span>
                                <ChevronDoubleRightIcon class="w-3" />
                            </span>
                        </template>
                        <template v-else>
                            <span v-html="page.label"></span>
                        </template>
                    </template>
                    </Link>
                </template>
                <template v-else>
                    <span>...</span>
                </template>
            </template>

        </div>
        <div class="text-right">
            {{ meta.current_page * meta.per_page }} of {{ meta.total }}
        </div>
    </div>

</template>
