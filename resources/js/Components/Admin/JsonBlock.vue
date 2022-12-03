<script setup>
import JsonKey from './JsonKey.vue';
import JsonValue from './JsonValue.vue';
import { RadioGroupOption } from '@headlessui/vue';
import { ref } from 'vue';
import _ from 'lodash'


const props = defineProps({
    'obj': {
        type: Object,
        default: {},
    },
    'formatAsArray' : {
        type: Boolean,
        default: false,
    },
    'depth': {
        type: Number,
        default: 0
    }
})

// const isObject = o => {
//     return typeof o === 'object' && !Array.isArray(o) && o !== null
// }



const isChecked = ref(false)

const updateCheck = (e) => {
    isChecked.value = e.target.checked
}

const getThing = o => {
    if (typeof o === 'object') {
        return Object.assign({}, o)
    }
    return o
}

</script>

<template>

        <template v-for="key in Object.keys(getThing(props.obj) ?? {})">
            <template v-if="typeof obj[key] === 'object'">
                <slot name="group"
                    :label="key"
                    :value="Object.assign({}, obj[key])"
                    :grouping="true"
                    :isArray="Array.isArray(obj[key])"
                    :isNull="(obj[key] === null)"
                    :block="$slots.block"
                    :group="$slots.group"
                    v-if="key[0] !== '#'"
                    >
                </slot>
            </template>
            <template v-else>
                <slot name="block"
                    :label="key"
                    :value="props.obj[key]"
                    :depth="depth"
                    :grouping="false"
                    v-if="key[0] !== '#'"
                    >
                </slot>
            </template>

        </template>

</template>
