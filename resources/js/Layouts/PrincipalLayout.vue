<script setup>
    import Header from '@/Components/Header.vue';
</script>

<template>
    <div class="flex flex-col min-h-screen">
        <Header/>
        <div class="flex-1 bg-primary-2 pt-6">
            <slot />

        </div>

    </div>


</template>