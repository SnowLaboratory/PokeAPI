<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { onMounted, ref } from 'vue';

const emit = defineEmits([
    'close'
])

const props = defineProps({
    'message': {
        type: String,
    },
    'label' : {
        type: String,
        default: 'Alert'
    },
    'timeout': {
        type: Number,
        default: 0,
    },
    'buttonClass': {
        type: String,
        default: 'hover:bg-gray-100'
    },
    'messageClass': {
        type: String,
        default: 'hover:bg-gray-100'
    },
    'resetsTimeout' : {
        type: Boolean,
        default: true,
    }
})

const timeoutMS = ref(props.timeout)
const timeout = ref(null)

const createTimeout = () => {
    if (timeoutMS.value) {
        timeout.value = setTimeout(() => {
            emit('close', props.label)
        }, timeoutMS.value)
    }
}

onMounted(() => {
    createTimeout()
})

const cancelTimeout = () => {
    clearTimeout(timeout.value)
    if (props.resetsTimeout) {
        createTimeout()
    }
}


</script>

<template>
    <div class="rounded w-full space-x-2 z-30 relative" @click="cancelTimeout">
        <div class="p-3 flex items-start space-x-3" :class="[props.messageClass]">
            <slot>
                <div class="font-bold">
                    {{ label }}:
                </div>
                <div v-if="message">
                    {{ message }}
                </div>
            </slot>
        </div>
        <div class="top-0 right-0 p-2 absolute">
            <button @click.prevent="$emit('close', props.label)"
                class="p-2 rounded-full cursor-pointer"
                :class="[props.buttonClass]">
                <XMarkIcon class="w-4" />
            </button>
        </div>
    </div>
</template>
