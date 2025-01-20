<script setup>
    import PrincipalLayout from '@/Layouts/PrincipalLayout.vue';
    import InputTextForm from '@/Components/Form/InputTextForm.vue';
    import InputSelectForm from '@/Components/Form/InputSelectForm.vue';
    import InputPriceForm from '@/Components/Form/InputPriceForm.vue';
    import { ref } from 'vue';
    import SendButton from '@/Components/Buttons/SendButton.vue';
    import { postRequest } from '@/Composables/RequestService';
    import { alertSuccess } from '@/Composables/AlertService';
    import PageTitle from '@/Components/PageTitle.vue';

    const props = defineProps({
        tributes: {
            type: Array,
            required: true
        },
        units_measures: {
            type: Array,
            required: true
        }
    });

    const product = ref({
        name: '',
        price: '',
        is_excluded: '',
        tribute_id: '',
        tax_rate: '',
        unit_measure_id: '',
    });
    const isExcludedIvaOptions = [
        { label: 'Si', value: '1' },
        { label: 'No', value: '0' }
    ]

    function createProduct(){
        postRequest('/producto', product.value )
            .then((response) => {
                console.log('ha entrado en el .then... de create.vue', response);
                alertSuccess('Producto creado correctamente');
                product.value = {};
            })
            .catch(error=>{
                console.log('ha entrado en el .catch... de create.vue');
                console.log(error);
            });
    }
</script>
<template>
    <PrincipalLayout>
        <PageTitle title="Crear Producto"/>
        
        <form class="form" @submit.prevent="createProduct">
            <div class="form-field">
                <InputTextForm label="Nombre" v-model="product.name" />
                <InputPriceForm label="Precio" v-model="product.price" />
                <InputSelectForm 
                    label="Unidad de medida" 
                    v-model="product.unit_measure_id" 
                    :options="units_measures"
                    optionLabel="name"
                    optionValue="id"
                />
            </div>
            <div class="form-field">
                <InputSelectForm 
                    label="Excluida de iva?" 
                    :options="isExcludedIvaOptions" 
                    optionLabel="label"
                    optionValue="value"
                    v-model="product.is_excluded" 
                />
                <InputSelectForm 
                    label="Impuesto a aplicar" 
                    v-model="product.tribute_id"
                    :options="tributes"
                    optionLabel="name"
                    optionValue="id"
                />
                <InputTextForm label="Porcentaje de impuesto a aplicar" v-model="product.tax_rate" />
            </div>
            <SendButton label="Crear producto"/>
        </form>
    </PrincipalLayout>
</template>