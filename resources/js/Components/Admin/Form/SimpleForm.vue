<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Admin/Button.vue';
import { ref, watch, computed } from 'vue';

const emit = defineEmits([
    'submit',
    'redirect',
]);

const shouldRedirect = ref(false);

const recentlySuccessful = computed(() => props.form.recentlySuccessful)

const props = defineProps({
    'form': {
        type: Object,
        default: useForm()
    }
})

const handleRedirect = () => {
    shouldRedirect.value = true
    emit('submit', props.form)
}

watch(recentlySuccessful, () => {
    if (shouldRedirect.value) {
        shouldRedirect.value = false;
        emit('redirect')
    }
})

</script>

<template>

<form @submit.prevent="$emit('submit', props.form)">
    <slot></slot>
    <div class="mt-8 border-t py-3 border-gray-500 flex items-center justify-end space-x-3">
        <div class="text-emerald-600 font-medium" v-if="recentlySuccessful">
            Success!
        </div>
        <button
            @click.prevent="$emit('submit', form)"
            class="py-1 px-3 font-medium rounded-lg"
            :class="{
                'bg-slate-900 text-slate-200 hover:text-white hover:bg-slate-800 cursor-pointer': form.isDirty,
                'bg-slate-400 text-slate-200': !form.isDirty
            }"
            :disabled="!form.isDirty"
            >
            Save and Continue
        </button>
        <button
            @click.prevent="handleRedirect"
            class="py-1 px-3 font-medium rounded-lg"
            :class="{
                'bg-slate-900 text-slate-200 hover:text-white hover:bg-slate-800 cursor-pointer': form.isDirty,
                'bg-slate-400 text-slate-200': !form.isDirty
            }"
            :disabled="!form.isDirty"
            >
            Save
        </button>
    </div>
</form>

</template>
