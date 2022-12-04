<script setup>

</script>

<template>
    <div class="breadcrumbs">
        <slot></slot>
    </div>
</template>

<style>
.breadcrumbs {
    @apply flex items-center
}

.breadcrumbs > .breadcrumb:not(:first-child)::before {
    content: '/';
    @apply mx-1;
}
</style>
