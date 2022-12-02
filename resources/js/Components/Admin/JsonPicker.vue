<script setup>
import axios from 'axios';
import { computed, getCurrentInstance, ref } from 'vue';
import JsonBlock from './JsonBlock.vue';
import {RadioGroup, RadioGroupOption} from '@headlessui/vue'
import JsonKey from './JsonKey.vue';
import JsonValue from './JsonValue.vue';
import debounce from 'lodash/debounce'

const emit = defineEmits([
    'selected'
])

const url = ref("")
const json = ref(null);

// const iterate = (obj, callback) => {
//     Object.keys(obj).forEach(key => {

//     // console.log(`key: ${key}, value: ${obj[key]}`)
//     callback(key, obj[key])

//     if (typeof obj[key] === 'object' && obj[key] !== null) {
//             iterate(obj[key], callback)
//         }
//     })
// }

const getJson = () => {
    json.value = null
    if (!(url.value.length > 3)) return
    axios.get(`${url.value}?json=true&glue=true`)
    .then(result => {
        json.value = result.data;

        // iterate(json.value, (key, value) => {
        //     if (_.isObject(value) && !Array.isArray(value)) {
        //         // console.log(key, value)
        //         value.isChecked = computed(() => {
        //             return !!(model.value
        //                     && model.value?.['#id'] === value['#id']
        //                     && model.value?.['#class'] === value['#class'])
        //         })
        //     }
        // })
    }).catch(() => {
        json.value = null
    })
}


const deferJson = debounce(getJson, 300)

const model = ref(null)

const props = defineProps({
    'placeholder': {
        type: String,
        default: 'url'
    }
})

const handleCheck = (e, value) => {
    Array.from(document.querySelectorAll('.object-wrapper')).forEach(
        node => node.classList.remove('bg-gray-100')
    )
    e.target.parentNode.parentNode.classList.add('bg-gray-100')
    model.value = value
    emit('selected', value)
}

const isChecked = (id, className) => {
    return !!(model.value
        && model.value?.['#id'] === id
        && model.value?.['#class'] === className)
}

</script>

<template>

    <form @submit.prevent="getJson" class="text-sm font-mono w-1/2 p-3">
        <input type="search" v-model="url"
                class="text-sm font-mono px-3 py-1 w-full border border-gray-200"
                :placeholder="props.placeholder"/>

        <div v-if="json" class="w-full overflow-scroll border whitespace-pre -mt-1 p-3 h-96 json-picker leading-8 text-[0.7rem] select-none">
            <JsonBlock :obj="json">
                <template #block="{label, value, grouping}">
                    <template v-if="grouping">
                        <div class="mr-2">
                            <input type="radio" :name="`json_picker_${getCurrentInstance().uid}`" @input="handleCheck($event, value)"/>
                        </div>
                        <JsonKey class="mr-2">{{ label }}</JsonKey>
                    </template>
                    <template v-else>
                        <div class="flex items-center flex-wrap">
                            <JsonKey class="mr-2">{{ label }}</JsonKey>
                            <JsonValue :value="value" />
                        </div>
                    </template>
                </template>
                <template #group="{label, value, block, group:oldGroup, isArray, isNull}">
                    <div class="flex items-start object-wrapper">
                        <component :is="block" :label="label" :value="value" :grouping="true" />

                        <div>
                            <template v-if="isArray">
                                <div>array[{{ Object.values(value).length }}]</div>
                            </template>
                            <template v-else>
                                <div class="text-blue-600 font-bold" v-if="isNull">
                                    NULL
                                </div>
                                <div v-else>
                                    object
                                </div>
                            </template>

                            <JsonBlock :obj="value">
                                <template #block="{label, value, grouping}">
                                    <component :is="block" :label="label" :value="value" :grouping="grouping" />
                                </template>
                                <template #group="{label, value, group:newGroup, isArray, isNull}">
                                    <component :is="oldGroup" :label="label" :value="value" :block="block" :group="newGroup" :isArray="isArray" :isNull="isNull" />
                                </template>
                            </JsonBlock>
                        </div>
                    </div>
                </template>
            </JsonBlock>
        </div>
    </form>

</template>
