<script setup>
    import { InputNumber, IftaLabel } from 'primevue';

    import { ref, watch } from 'vue';

    const emit = defineEmits(['update:modelValue']);
    const props = defineProps({
        modelValue: {
            type: [String,Number],
        },
        label: {
            type: String,
        }
    });
    const localValue = ref(props.modelValue);
    watch( localValue , (value) => {
        emit('update:modelValue', value);
    });

</script>
<template>
    <IftaLabel class="w-full">
        <InputNumber fluid v-model="localValue" :maxFractionDigits="2" locale="es-CO" />
        <label :for="label + '_id'"> {{ label }} </label>
    </IftaLabel>
</template>