<script setup>
import axios from 'axios';
import { computed, ref } from 'vue';
import JsonBlock from './JsonBlock.vue';
import {RadioGroup} from '@headlessui/vue'
import debounce from 'lodash/debounce'

const emit = defineEmits([
    'selected'
])

const url = ref("")
const json = ref(null);

const getJson = () => {
    json.value = null
    if (!(url.value.length > 3)) return
    axios.get(`${url.value}?json=true&glue=true`)
    .then(result => {
        json.value = result.data;
    }).catch(() => {
        json.value = null
    })
}

const deferJson = debounce(getJson, 500)

const model = ref(null)

const props = defineProps({
    'placeholder': {
        type: String,
        default: 'url'
    }
})

const update = value => {
    model.value = value
    emit('selected', value)
}

</script>

<template>

    <form @submit.prevent="getJson" class="text-sm font-mono w-1/2 p-3">
        <input type="search" v-model="url" @input="deferJson"
                class="text-sm font-mono px-3 py-1 w-full border border-gray-200"
                :placeholder="props.placeholder"/>

        <div v-if="json" class="w-full overflow-scroll border whitespace-pre -mt-1 p-3 h-96">
            <RadioGroup :model-value="model" @update:model-value="update">
                <JsonBlock :obj="json" />
            </RadioGroup>
        </div>
    </form>

</template>
