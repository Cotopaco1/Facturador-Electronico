<script setup>
    const prop = defineProps({
        label: {
            type: String,
            default: 'Enviar'
        }
    });
</script>
<template>
    <div>
        <button class="text-white button bg-green-400" type="submit"> {{ label }}</button>
    </div>
</template>