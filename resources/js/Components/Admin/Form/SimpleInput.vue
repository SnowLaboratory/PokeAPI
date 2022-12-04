<script setup>
const props = defineProps({
    'error': {
        type: String,
    },
    'help': {
        type: String,
    },
    'label': {
        type: String,
    },
    'type': {
        type: String,
    },
    'modelValue': {
        type: String,
        default: '',
        required: true
    }
})
</script>

<template>
    <div class="w-full">
        <label>
            <span v-if="props.label" class="font-bold">{{ props.label }}</span>
            <slot>
                <input class="w-full px-3 py-1 rounded border border-gray-500"
                    :type="type"
                    @input="$emit('update:modelValue', $event.target.value)"
                    :value="props.modelValue"
                    />
            </slot>
        </label>
        <div class="text-sm" :class="{'text-rose-600': props.error}" v-if="(props.error ?? props.help)">
            {{ props.error ?? props.help }}
        </div>
    </div>
</template>
