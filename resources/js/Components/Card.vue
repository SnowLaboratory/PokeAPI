<script setup>
const props = defineProps({
    hasExternalHeading: {
        type: Boolean,
        default: true,
    },

    heading: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div>
        <slot name="header" v-if="props.hasExternalHeading">
            {{ props.heading }}
        </slot>
        <div class="border border-gray-700 rounded-md">
            <slot name="content">
                <div class="p-3">
                    <slot name="header" v-if="!props.hasExternalHeading">
                        {{ props.heading }}
                    </slot>
                    <div>
                        <slot></slot>
                    </div>
                </div>
            </slot>
        </div>
    </div>
</template>
