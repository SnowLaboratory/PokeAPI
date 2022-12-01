<script setup>
import axios from 'axios';
import { ref } from 'vue';
import JsonBlock from './JsonBlock.vue';
import {RadioGroup} from '@headlessui/vue'

const baseUrl = ref("")
const foreignUrl = ref("")
const baseJson = ref(null);
const foreignJson = ref(null);


const getJson = () => {
    baseJson.value = null
    axios.get(`${baseUrl.value}?json=true&glue=true`)
    .then(result => {
        baseJson.value = result.data;
    })
}

const getJson2 = () => {
    foreignJson.value = null
    axios.get(`${foreignUrl.value}?json=true&glue=true`)
    .then(result => {
        foreignJson.value = result.data;
    })
}

const base = ref(null)
const foreign = ref(null)

</script>

<template>
    <div class="max-w-screen-lg mx-auto">
        <h1 class="text-xl font-bold mb-8">Model Gluer</h1>

        <div class="flex -mx-3">
            <form @submit.prevent="getJson" class="text-sm font-mono w-1/2 p-3">
                <input type="search" v-model="baseUrl" @blur="getJson" @change="getJson"
                        class="text-sm font-mono px-3 py-1 w-full border border-gray-200"
                        placeholder="base"/>

                <div v-if="baseJson" class="w-full overflow-scroll border whitespace-pre -mt-1 p-3 h-96">
                    <RadioGroup v-model="base">
                        <JsonBlock :obj="baseJson" />
                    </RadioGroup>
                </div>
            </form>

            <form @submit.prevent="getJson2" class="text-sm font-mono w-1/2 p-3">
                <input type="search" v-model="foreignUrl" @blur="getJson2" @change="getJson2"
                        class="text-sm font-mono px-3 py-1 w-full border border-gray-200"
                        placeholder="foreign"/>

                <div v-if="foreignJson" class="w-full overflow-scroll border whitespace-pre -mt-1 p-3 h-96">
                    <RadioGroup v-model="foreign">
                        <JsonBlock :obj="foreignJson" />
                    </RadioGroup>
                </div>
            </form>
        </div>


    </div>
</template>
