<script setup>
import Navigation from '@/Components/Admin/Navigation.vue'
import { Link, usePage } from '@inertiajs/inertia-vue3';
import Breadcrumbs from "@/Components/Admin/Breadcrumb/Breadcrumbs.vue";
import Breadcrumb from "@/Components/Admin/Breadcrumb/Breadcrumb.vue";
import Heading from "@/Components/Admin/Heading.vue";
import { computed } from 'vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/24/outline'
import Alert from '@/Components/Admin/Alert/Alert.vue';
import Alerts from '@/Components/Admin/Alert/Alerts.vue';


const defaultOptions = {
    'species': {
        'index': route('admin.species.index'),
        'create': route('admin.species.create'),
        'edit': detectRelation('admin.species.edit'),
    }
}

const props = defineProps({
    crumbs: {
        type: Object,
        default: {
            'admin': 'dashboard',
        }
    },
    options: {
        type: Object,
        default: {},
    },
})

const crumbs = computed(() => route().current().split('.'));
const ending = computed(() => crumbs.value.slice(-1)[0]);
const options = computed (() => Object.assign(defaultOptions, props.options));

const getRoute = (offset, params) => {
    var wantedCrumbs = crumbs.value.slice(0, offset)
    const lastCrumb = wantedCrumbs.slice(-1)[0]
    const page = props.crumbs[lastCrumb] ?? 'index';
    try {
        return route([...wantedCrumbs, page].join('.'), params)
    } catch {
        return route([...wantedCrumbs].join('.'), params)
    }
}

const getOptionRoute = (link) => {
    if (typeof link === 'function') {
        try {
            return link();
        } catch {
            return null;
        }
    }
    return link;
}

const isCurrent = (check) => route().current(check);

const messages = computed(() => usePage().props.value.messages);

</script>

<script>
    export const detectRelation = r => () => route(r, route().params)
    export const relationRoute = r => detectRelation(r)()
</script>

<template>
    <div class="min-h-screen mx-auto relative">
        <div class="flex justify-center font-mono bg-white">
            <div class="bg-white w-48">
                <nav class="sticky top-0 py-6">
                    <div class="text-xl font-bold px-3 h-12 flex items-center">PokeDB</div>
                    <slot name="navigation">
                        <Navigation class="mt-[1rem]">
                            <Link :href="route('admin.dashboard')" :class="{ 'active': isCurrent('admin.dashboard') }">
                            Dashboard</Link>
                            <Link :href="route('admin.species.index')"
                                :class="{ 'active': isCurrent('admin.species.*') }">Species</Link>
                            <Link :href="route('admin.items.index')" :class="{ 'active': isCurrent('admin.items.*') }">
                            Items</Link>
                        </Navigation>
                    </slot>
                </nav>
            </div>
            <main class="w-full max-w-screen-lg bg-white px-6 pb-6">
                <div class="sticky top-0 bg-white pt-6 z-20">
                    <Alerts v-if="messages">
                        <Alert v-if="messages.info"
                            class="bg-sky-200"
                            button-class="hover:bg-sky-300 text-sky-800"
                            message-class="text-sky-800"
                            label="Info"
                            :message="messages.info"
                            :timeout="3000"
                            @close="delete messages.info"
                        />
                        <Alert v-if="messages.success"
                            class="bg-emerald-200"
                            button-class="hover:bg-emerald-300 text-emerald-800"
                            message-class="text-emerald-800"
                            label="Success"
                            :message="messages.success"
                            :timeout="3000"
                            @close="delete messages.success"
                        />
                        <Alert v-if="messages.warning"
                            class="bg-amber-200"
                            button-class="hover:bg-amber-300 text-amber-800"
                            message-class="text-amber-800"
                            label="Warning"
                            :message="messages.warning"
                            @close="delete messages.warning"
                        />
                        <Alert v-if="messages.error"
                            class="bg-rose-200"
                            button-class="hover:bg-rose-300 text-rose-800"
                            message-class="text-rose-800"
                            label="Error"
                            :message="messages.error"
                            @close="delete messages.error"
                        />
                    </Alerts>
                    <Breadcrumbs class="text-sm h-12 mb-[1px]">
                        <Breadcrumb v-for="(crumb, index) in crumbs.slice(0, -1)" class="flex items-center relative">
                            <Link :href="getRoute(index + 1, route().params)" class="text-blue-600 hover:underline">
                            {{ crumb }}
                            </Link>
                            <Menu v-if="options[crumb]">
                                <MenuButton>
                                    <div class="p-[0.1rem] border border-gray-100 hover:bg-gray-100">
                                        <ChevronDownIcon class="w-3" />
                                    </div>

                                </MenuButton>
                                <MenuItems class="absolute inset-x-0 top-full">
                                    <div class=" bg-white z-10 border rounded">
                                        <template v-for="(route, routeName) in options[crumb]">
                                            <template v-if="getOptionRoute(route)">
                                                <MenuItem >
                                                        <Link :href="getOptionRoute(route)" class="block px-3 py-1 hover:bg-gray-100">
                                                            {{ routeName }}
                                                        </Link>
                                                </MenuItem>
                                            </template>
                                        </template>
                                    </div>
                                </MenuItems>
                            </Menu>
                        </Breadcrumb>
                        <Breadcrumb v-if="crumbs.length > 1">
                            {{ ending }}
                        </Breadcrumb>
                    </Breadcrumbs>

                    <slot name="heading">
                        <Heading :label="crumbs.slice(-2).join(' ')" />
                    </slot>
                </div>


                <div class="py-3">
                    <slot></slot>
                </div>
            </main>
        </div>

    </div>
</template>
