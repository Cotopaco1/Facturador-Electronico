<script setup>
    import PrincipalLayout from '@/Layouts/PrincipalLayout.vue';
    import InputTextForm from '@/Components/Form/InputTextForm.vue';
    import InputSelectForm from '@/Components/Form/InputSelectForm.vue';
    import SendButton from '@/Components/Buttons/SendButton.vue';
    import PageTitle from '@/Components/PageTitle.vue';
    import { DataTable, Column, Row, InputNumber } from 'primevue';
    import InputAutoCompleteForm from '@/Components/Form/InputAutoCompleteForm.vue';
    import { ref } from 'vue';
    import { postRequest } from '@/Composables/RequestService';
    import { alertSuccess } from '@/Composables/AlertService';

    const props = defineProps({
        products: [Array],
        identifications_documents: [Array],
        municipalities: [Array],
        payment_methods: [Array],
    });

    const legal_organization_options = [
        { value: 1, label: 'Persona Juridica' },
        { value: 2, label: 'Persona Natural' },
    ];

    const customer = ref({});
    const productsToSell = ref([]);
    const payment = ref({});

    function productSelected(product) {
        let item = product.value;
        const isDuplicate = productsToSell.value.find( localItem => localItem.id === product.value.id);
        if(isDuplicate) {
            return;
        }
        if(productsToSell.value.includes(product)) {
            return;
        }
        item.quantity = 1;
        item.discount_rate = 0;
        productsToSell.value.push(item);
    }

    function onCellEditComplete(event){
        const index = event.index;
        productsToSell.value[index] = event.newData;
    }

    function generateQuotation() {
        const data = {
            customer: customer.value,
            items: productsToSell.value,
            payment_form : payment.value.form,
            payment_method_code : payment.value.method,
        }
        postRequest('/facturacion', data)
            .then( response => {
                console.log(response);
                alertSuccess('Factura generada correctamente', response.message);
            })
            .catch( error => {
                console.log(error);
            });
    }


</script>
<template>
    <PrincipalLayout>
        <PageTitle title="Generar factura de venta"/>
        <form class="form" @submit.prevent="generateQuotation">
            <h2>Cliente</h2>
            <div class="form-field">
                <InputSelectForm 
                    label="Tipo cliente" 
                    v-model="customer.legal_organization_id" 
                    :options="legal_organization_options"
                    optionLabel="label"
                    optionValue="value"
                />
                <InputSelectForm 
                    label="Tipo identificacion" 
                    v-model="customer.identification_document_id" 
                    :options="identifications_documents"
                    optionLabel="name"
                    optionValue="id"
                />
                <InputTextForm label="Identificacion" v-model="customer.identification" />
            </div>
            <div class="form-field">
                <InputTextForm label="Nombre" v-model="customer.names" />
                <InputTextForm label="Telefono" v-model="customer.phone" />
                <InputTextForm label="Correo" v-model="customer.email" />
            </div>
            <div class="form-field">
                <InputAutoCompleteForm label="Municipio" v-model="customer.municipality_id" />
                <InputTextForm label="Direccion" v-model="customer.address" />
                <InputSelectForm 
                    label="Aplica IVA" 
                    v-model="customer.tribute_id" 
                    :options="[{name: 'Si', value : 18 }, {name: 'No', value : 21 }]"
                    optionLabel="name"
                    optionValue="value"
                />
            </div>
            <h2>Productos</h2>
            <div class="form-field">
                <InputSelectForm 
                    label="Seleccione los productos" 
                    :options="products"
                    optionLabel="name"
                    @change="productSelected"
                />
            </div>
            <DataTable :value="productsToSell" editMode="cell" @cell-edit-complete="onCellEditComplete">
                <Column field="name" header="Nombre"></Column>
                <Column field="priceFormatted" header="Precio">
                    
                </Column>
                <Column field="quantity" header="Cantidad">
                    <template #editor="{data}">
                        <InputNumber fluid v-model="data.quantity"  />
                    </template>
                </Column>
                <Column field="discount_rate" header="Porcentaje Descuento">
                    <template #editor="{data}">
                        <InputNumber fluid v-model="data.discount_rate"  />
                    </template>
                </Column>

            </DataTable>
            <div  class="form-field">
                <InputSelectForm 
                    label="Forma de pago" 
                    :options="[{name: 'Pago de contado', value : 1 }]"
                    optionLabel="name"
                    optionValue="value"
                    v-model="payment.form"
                />
                <InputSelectForm 
                    label="Metodo de pago" 
                    :options="payment_methods"
                    optionLabel="name"
                    optionValue="code"
                    v-model="payment.method"
                />

            </div>
            <SendButton label="Generar factura"/>
        </form>
    </PrincipalLayout>
</template>