<script setup>
import JsonKey from './JsonKey.vue';
import JsonValue from './JsonValue.vue';
import { RadioGroupOption } from '@headlessui/vue';


const props = defineProps({
    'obj': {
        type: Object,
        default: {},
    },
    'formatAsArray' : {
        type: Boolean,
        default: false,
    }
})

const isObject = o => {
    return typeof o === 'object' && !Array.isArray(o) && o !== null
}

const canGlue = o => {
    return isObject(o)
        && 'id' in o
        && 'class' in o
}

</script>

<template>
    <div class="font-mono leading-6 text-[0.7rem]">
            <div v-for="key in Object.keys(obj ?? {})" >

                <div v-if="Array.isArray(obj[key])" class="ml-3 array">
                    <!-- <JsonKey>
                            {{ key }}
                    </JsonKey> -->

                    <JsonBlock :obj="Object.assign({}, obj[key])" format-as-array/>
                </div>
                <template v-else>
                    <div v-if="isObject(obj[key])" class="ml-3">

                        <div class="flex items-start space-x-3">
                            <div v-if="canGlue(obj[key])">
                                <RadioGroupOption v-slot="{ checked }" :value="obj[key]">
                                    <input type="radio" :checked="checked">
                                </RadioGroupOption>
                            </div>
                            <div class="relative flex">
                                <JsonKey :format-as-array="props.formatAsArray">
                                    {{ key }}
                                </JsonKey>
                                <JsonBlock :obj="Object.assign({}, obj[key])" class="ml-3"/>
                            </div>

                        </div>


                    </div>
                    <span v-else class="flex space-x-3">
                        <JsonKey>
                            {{ key }}
                        </JsonKey>
                        <JsonValue :value="obj[key]"/>
                    </span>
                </template>

                <!-- <div v-if="typeof ">

                </div> -->
            </div>

    </div>
</template>
