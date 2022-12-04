<script setup>
import Button from '@/Components/Admin/Button.vue'

const props = defineProps({
    'heading': {
        type: String,
        default: 'Heading'
    }
})

</script>

<template>
    <div class="flex justify-between items-end border-b border-gray-500 h-12 pb-2">
        <h1 class="text-lg font-bold leading-none h-10 flex items-end">
            <slot name="heading">
                {{ heading }}
            </slot>
        </h1>
        <div class="flex items-center">
            <slot>
                <Button primary>Add</Button>
            </slot>
        </div>

    </div>
</template>
