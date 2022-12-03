<script setup>
import axios from 'axios';
import { ref, computed, watch } from 'vue';
import JsonPicker from '@/Components/Admin/JsonPicker.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Combobox, ComboboxInput, ComboboxOptions, ComboboxOption } from '@headlessui/vue';

const form = useForm({
    base_id: null,
    base_type: null,
    foreign_id: null,
    foreign_type: null,
    json: null,
    name: null,
})

const selectBase = obj => {
    form.base_id = obj['#id']
    form.base_type = obj['#class']
    fetchGlue()
}

const selectForeign = obj => {
    form.foreign_id = obj['#id']
    form.foreign_type = obj['#class']
    fetchGlue()
}

const names = ref(null)

const selectedName = ref(null)
const typedName = ref(null)

const wantedName = computed(() => selectedName.value ?? typedName.value)

const fetchGlue = () => {
    if (form.foreign_id && form.base_id) {
        console.log(form.data)
        axios.post(route('admin.glue.names'), form.data())
        .then(res => {
            names.value = res.data
        })
    }
}

const changeInput = e => {
    if (e.target.value) {
        typedName.value = e.target.value
    }
}

const glueJson = ref(null)
const comboboxInput = ref(null)

const fetchGlueJson = () => {
    comboboxInput.value.el.value = wantedName.value
    if (form.foreign_id && form.base_id && wantedName.value) {
        // console.log(wantedName.value)
        form.name = wantedName.value
        axios.post(route('admin.glue.fetch'), form.data())
        .then(res => {
            form.json = JSON.stringify(res.data)
        })
    }
}

const submitGlueJson = () => {
    comboboxInput.value.el.value = wantedName.value
    if (form.foreign_id && form.base_id && wantedName.value && form.json) {
        // console.log(wantedName.value)
        axios.post(route('admin.glue.save'), form.data())
        .then(res => {
            console.log({res})
        })
    }
}

watch(typedName, (oldValue, newValue) => {
    if (oldValue) {
        fetchGlueJson()
    }
})



</script>

<template>
    <div class="max-w-screen-lg mx-auto">
        <h1 class="text-xl font-bold mb-8">Model Gluer</h1>

        <div class="flex -mx-3">
            <JsonPicker placeholder="base" @selected="selectBase"/>
            <JsonPicker placeholder="foreign" @selected="selectForeign"/>
        </div>

        <div>Glue Name</div>
        <div class="flex space-x-3 w-full">
            <Combobox v-model="selectedName">
                <div class="relative flex-grow">
                    <ComboboxInput ref="comboboxInput" class="w-full" @change.stop="changeInput"/>
                    <ComboboxOptions class="absolute inset-x-0 top-full border border-gray-400 z-10 shadow rounded">
                        <ComboboxOption
                            v-for="name in names"
                            :value="name"
                            class="p-2 bg-white hover:bg-gray-100 cursor-pointer"
                        >
                            {{ name }}
                        </ComboboxOption>
                    </ComboboxOptions>
                </div>
            </Combobox>
            <div>
                <button class="bg-slate-900 rounded px-3 py-1 text-white" @click.prevent="fetchGlueJson">Edit</button>
            </div>

        </div>



        <div class="mt-8 w-full">
            <div>Glue JSON</div>
            <textarea class="w-full" rows="7" v-model="form.json"></textarea>
        </div>

        <button class="bg-slate-900 rounded px-3 py-1 text-white float-right" @click.prevent="submitGlueJson">Save</button>

    </div>
</template>
