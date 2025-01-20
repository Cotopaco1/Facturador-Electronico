<script setup>
    const props = defineProps({
        title: {
            type: String,
            required: true
        }
    });
</script>
<template>
    <div class="flex justify-center">
            <h1 class="text-white uppercase font-bold mb-4">{{ title }}</h1>
        </div>
</template>