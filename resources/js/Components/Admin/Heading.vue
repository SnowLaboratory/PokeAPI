<script setup>
import Button from '@/Components/Admin/Button.vue'

const props = defineProps({
    'label': {
        type: String,
        default: 'Heading'
    }
})

</script>

<template>
    <div class="flex justify-between items-end border-b border-gray-500 h-12 pb-2">
        <h1 class="text-lg font-bold leading-none h-10 flex items-end">
            <slot name="label">
                {{ label }}
            </slot>
        </h1>
        <div class="flex items-center" id="page-actions">
            <slot></slot>
        </div>

    </div>
</template>
