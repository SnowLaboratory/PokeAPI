<script setup>

const props = defineProps([
    'value'
])


</script>

<template>
    <span :class="{
            'text-emerald-600': typeof props.value === 'string',
            'text-orange-500': typeof props.value === 'number',
            'text-purple-600 uppercase': typeof props.value === 'boolean',
        }" class="font-bold">
        <span v-if="typeof props.value === 'string'">"</span>
        <span >
            {{ value }}
        </span>
        <span v-if="typeof props.value === 'string'">"</span>
    </span>
</template>
