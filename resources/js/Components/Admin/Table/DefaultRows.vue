<script setup>
import DefaultContent from './DefaultContent.vue';
import { computed, ref } from 'vue';
import Button from '@/Components/Admin/Button.vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/24/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { Link } from '@inertiajs/inertia-vue3';

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

const selectedData = ref({})
const selectedRows = computed(() => Object.values(selectedData.value ?? {}))

const isChecked = id => {
    return id in selectedData.value;
}

const select = (id, data) => {
    selectedData.value[id] = data;
}

const remove = id => {
    delete selectedData.value[id];
}

const toggle = (id, data) => {
    isChecked(id) ? remove(id) : select(id, data);
}

</script>

<template>
    <tr v-for="(row, index) in props.rows" class="relative" :class="{
        'bg-gray-100': isChecked(index)
    }">
        <td class="text-left w-6 leading-none">
            <input type="checkbox" @input="toggle(index, row)" />
        </td>
        <slot :row="row">
            <DefaultContent :columns="props.columns" :row="row" />
        </slot>
        <td class="leading-none">
            <div class="h-8 leading-loose mt-1">
                <Menu>
                    <MenuButton as="template">
                        <button class="border border-gray-500 rounded-lg p-1 hover:bg-slate-100 cursor-pointer relative"
                            :class="{
                                'hover:bg-gray-200': isChecked(index)
                            }">
                            <EllipsisVerticalIcon class="w-5" />
                        </button>
                    </MenuButton>
                    <MenuItems class="absolute inset-x-0 top-full -mt-3 text-sm right-6 left-[unset] z-10 w-24">
                        <div class=" bg-yellow-50 z-10 border rounded shadow shadow-zinc-300">
                            <MenuItem v-for="(options, actionName) in props.actions">
                            <template v-if="options.href">
                                <Link :href="options.href" class="w-full text-left block px-3 py-1 hover:bg-yellow-100">
                                {{ actionName }}
                                </Link>
                            </template>
                            <template v-else>
                                <button @click.prevent="options.action"
                                    class="w-full text-left block px-3 py-1 hover:bg-yellow-100">
                                    {{ actionName }}
                                </button>
                            </template>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </Menu>

            </div>
        </td>
    </tr>
</template>
