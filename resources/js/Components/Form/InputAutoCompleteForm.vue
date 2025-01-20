<script setup>
    import { AutoComplete, IftaLabel } from 'primevue';
    import { ref, watch } from 'vue';
    import { getRequest } from '@/Composables/RequestService';
    const emit = defineEmits(['update:modelValue']);
    const props = defineProps({
        modelValue: {
            type: [String],
            required: true
        },
        label: {
            type: String,
            required: true
        },
        
    });
    const suggestions = ref([]);
    
    function updateValue(event){
        emit('update:modelValue', event.value.searchable.id);
    }

    function searchQuery(event){
        const query = event.query;
        getRequest(`/municipalities?query=${query}`).then( response => {
            suggestions.value = response.municipalities;
        });
    }

</script>
<template>
    <IftaLabel class="w-full">
        <AutoComplete fluid v-model="localValue"
            @complete="searchQuery"
            @option-select="updateValue"  
            :suggestions="suggestions" 
            optionLabel="title"
        />
        <label :for="label + '_id'"> {{ label }} </label>
    </IftaLabel>
</template>