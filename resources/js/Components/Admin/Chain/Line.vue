<script setup>
import { getCurrentInstance, onMounted } from 'vue';


    const emit = defineEmits([
        'click',
    ])

    const props = defineProps({
        'el': Object,
    })

    onMounted(() => {
        const attrs = getCurrentInstance().attrs
        for (let key in attrs) {
            if (key.startsWith('on')) {
                props.el.addEventListener(key.slice(2).toLowerCase(), attrs[key])
            }
        }
        console.log('line component', getCurrentInstance());
        //
    })
</script>

<template>
    <div class="line-component">
        <!-- <MyEl /> -->
    </div>
</template>
