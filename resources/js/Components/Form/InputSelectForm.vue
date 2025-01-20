<script setup>
    import { Select, IftaLabel } from 'primevue';
import { ref, watch } from 'vue';
    const emit = defineEmits(['update:modelValue', 'change']);
    const props = defineProps({
        modelValue: {
            type: [String, Number],
            required: true
        },
        label: {
            type: String,
        },
        options: {
            type: Array,
            required: true
        },
        optionLabel: {
            type: String,
        },
        optionValue: {
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
        <Select @change="emit('change', $event)" class="w-full" v-model="localValue" :options="options" :optionLabel="optionLabel" :optionValue="optionValue" />
        <label :for="label + '_id'"> {{ label }} </label>
    </IftaLabel>
</template>