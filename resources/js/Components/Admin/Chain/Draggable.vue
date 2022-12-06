<script setup>

import {computed, onMounted, ref} from 'vue'
import interact from 'interactjs'

const emit = defineEmits([
    'update:position',
    'move',
])

const props = defineProps({
    locked: {
        type: Boolean,
        default: false,
    },
    position: {
        type: Object,
        default: null
    },
    bounds: {
        type: Object,
        default: null,
    }
})


const el = ref(null)

const internalPos = ref(props.position ?? {
    x: 0,
    y: 0,
})

const bounds = computed(() => props.bounds)

const restrictions = computed(() => {
    return interact.modifiers.restrict({
        restriction: () => {
            const rect = el.value.getBoundingClientRect();
            return {
                ...bounds.value,
                right: bounds.value.right - rect.width,
                top: bounds.value.top + rect.height,
            }
        },
        elementRect: { left: 0, right: 0, top: 1, bottom: 1 },
        endOnly: false,
    })
})

onMounted(() => {
    el.value.style.transform =`translate(${internalPos.value.x}px, ${internalPos.value.y}px)`
    interact(el.value).draggable({
        modifiers: [
            restrictions.value
        ],
        listeners: {
            move (event) {

                let newPos;
                if (props.position) {
                    newPos = {
                        x: props.position.x + event.dx,
                        y: props.position.y + event.dy,
                    };
                } else {
                    newPos = {
                        x: internalPos.value.x + event.dx,
                        y: internalPos.value.y + event.dy,
                    }
                    internalPos.value = newPos
                }

                if (!props.locked) {
                    event.target.style.transform =`translate(${newPos.x}px, ${newPos.y}px)`
                    emit('update:position', newPos)
                    emit('move', newPos)
                }

            },
        },
    }).styleCursor(false)
})

</script>

<template>
    <div ref="el">
        <slot></slot>
    </div>
</template>
