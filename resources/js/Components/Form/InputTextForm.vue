<script setup>
    import { InputText, IftaLabel } from 'primevue';
import { ref, watch } from 'vue';
    const emit = defineEmits(['update:modelValue']);
    const props = defineProps({
        modelValue: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        }
    });
    const localValue = ref(props.modelValue);
    watch( localValue , (value) => {
        emit('update:modelValue', value);
    });

</script>
<template>
    <IftaLabel class="w-full">
        <InputText fluid v-model="localValue" />
        <label :for="label + '_id'"> {{ label }} </label>
    </IftaLabel>
</template>