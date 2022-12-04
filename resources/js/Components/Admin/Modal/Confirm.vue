<script setup>
import { Dialog, DialogDescription, DialogPanel, DialogTitle } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { computed, ref, watch } from 'vue';

const emit = defineEmits([
    'close',
    'open',
    'confirm',
])

const props = defineProps({
    'open': Boolean,
    'closeClass': String,
    'modalClass': {
        type: String,
        default: 'max-w-screen-md'
    },
})

const open = ref(props.open)

const actuallyOpen = computed(() => props.open || open.value)

const setIsOpen = (isOpen, action=null) => {
    if (typeof action === 'function') {
        action()
    }
    open.value = isOpen
    emit(isOpen ? 'open' : 'close')
}

const confirm = (action=null) => {
    if (typeof action === 'function') {
        action()
    }
    emit('confirm')
    setIsOpen(false)
}

</script>

<template>
    <Dialog :open="actuallyOpen" @close="setIsOpen(false)">
        <!-- The backdrop, rendered as a fixed sibling to the panel container -->
        <div class="fixed inset-0 bg-black/30 z-40" aria-hidden="true" />

        <!-- Full-screen container to center the panel -->
        <div class="fixed inset-3 flex items-start justify-center p-4 z-40">
            <div class="bg-white px-3 pb-3 rounded w-full relative"
                :class="[modalClass]">
                <DialogPanel class="space-y-3">
                    <div class="top-0 right-0 p-2 absolute">
                        <button @click.prevent="setIsOpen(false)"
                            class="p-2 rounded-full cursor-pointer hover:bg-gray-100"
                            :class="[props.closeClass]">
                            <XMarkIcon class="w-4" />
                        </button>
                    </div>
                    <div class="font-bold text-lg">
                        <slot name="header">
                            <DialogTitle>Model</DialogTitle>
                        </slot>
                    </div>

                    <slot>
                        <DialogDescription>
                            This is a description
                        </DialogDescription>
                    </slot>

                    <div class="border-t border-gray-500 pt-3 flex items-center justify-end space-x-3">
                        <slot name="actions" :setIsOpen="setIsOpen" :submitModal="confirm">
                            <button @click="confirm">Confirm</button>
                            <button @click="setIsOpen(false)">Cancel</button>
                        </slot>
                    </div>
                </DialogPanel>
            </div>

        </div>
    </Dialog>
</template>
