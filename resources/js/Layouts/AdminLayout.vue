<script setup>
import Navigation from '@/Components/Admin/Navigation.vue'
import { Link } from '@inertiajs/inertia-vue3';
import Breadcrumbs from "@/Components/Admin/Breadcrumb/Breadcrumbs.vue";
import Breadcrumb from "@/Components/Admin/Breadcrumb/Breadcrumb.vue";
import Heading from "@/Components/Admin/Heading.vue";
import { computed } from 'vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    crumbs: {
        type: Object,
        default: {
            'admin': 'dashboard',
        }
    },
    options: {
        type: Object,
        default: {
            'species': {
                'index': route('admin.species.index'),
                'create': route('admin.species.create')
            }
        }
    }
})

const crumbs = computed(() => route().current().split('.'));
const ending = computed(() => crumbs.value.slice(-1)[0])

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

const isCurrent = (check) => route().current(check);

</script>

<template>
    <div class="min-h-screen mx-auto relative">
        <div class="flex justify-center font-mono bg-white">
            <div class="bg-white w-48">
                <nav class="sticky top-0 py-6">
                    <div class="text-xl font-bold px-3 h-12 flex items-center">PokeDB</div>
                    <slot name="navigation">
                        <Navigation class="mt-[1rem]">
                            <Link :href="route('admin.dashboard')"
                                :class="{'active': isCurrent('admin.dashboard')}"
                                >Dashboard</Link>
                            <Link :href="route('admin.species.index')"
                                :class="{'active': isCurrent('admin.species.*')}"
                                >Species</Link>
                            <Link :href="route('admin.pokemon.index')"
                                :class="{'active': isCurrent('admin.pokemon.*')}"
                                >Pokemon</Link>
                            <Link :href="route('admin.items.index')"
                                :class="{'active': isCurrent('admin.items.*')}"
                                >Items</Link>
                        </Navigation>
                    </slot>
                </nav>
            </div>
            <main class="w-full max-w-screen-md bg-white p-6">
                <Breadcrumbs class="text-sm h-12 mb-[1px]">
                    <Breadcrumb v-for="(crumb, index) in crumbs.slice(0,-1)" class="flex items-center relative">
                        <Link :href="getRoute(index + 1, route().params)" class="text-blue-600 hover:underline">
                            {{ crumb }}
                        </Link>
                        <Menu v-if="props.options[crumb]">
                            <MenuButton>
                                <div class="p-[0.1rem] border border-gray-100 hover:bg-gray-100">
                                    <ChevronDownIcon class="w-3"/>
                                </div>

                            </MenuButton>
                            <MenuItems class="absolute inset-x-0 top-full">
                                <div class=" bg-white z-10 border rounded">
                                    <MenuItem v-for="(route, routeName) in props.options[crumb]">
                                        <Link :href="route" class="block px-3 py-1 hover:bg-gray-100" v-show="(routeName != ending)">
                                            {{ routeName }}
                                        </Link>
                                    </MenuItem>
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

                <div class="py-3">
                    <slot></slot>
                </div>
            </main>
        </div>

    </div>
</template>
