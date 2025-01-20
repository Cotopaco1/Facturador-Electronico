<script setup>
    import PrincipalLayout from '@/Layouts/PrincipalLayout.vue';
    import PageTitle from '@/Components/PageTitle.vue';
    import { DataTable, Column } from 'primevue';
    import axios from 'axios';
    
    const props = defineProps({
        invoices: [Array],
    });
    function showInvoice(){

    }
    function downloadPdf(number){
        axios.get(route('invoice.download', number),{responseType: 'blob'}).then(response => {
            const file = response.data;
            const downloadUrl = window.URL.createObjectURL(new Blob([file]));

            const link = document.createElement('a');

            link.href = downloadUrl;

            link.setAttribute('download', `file.pdf`); //any other extension

            document.body.appendChild(link);

            link.click();

            link.remove();

        }).catch(error => {
            console.log(error);
        });
    }

</script>
<template>
    <PrincipalLayout>
        <PageTitle title="Ver facturas"/>
        <div class="container mx-auto">
            <DataTable :value="invoices.data" stripedRows>
                <Column field="number" header="Numero" />
                <Column field="reference_code" header="Codigo" />
                <Column field="names" header="Nombre cliente" />
                <Column field="total" header="Total" />
                <Column field="status" header="Estado" />
                <Column field="created_at" header="Fecha de creación" />
                <Column header="Acciones">
                    <template #body="slotProps">
                        <div class="flex gap-4">
                            <span class="pi pi-fw pi-eye btn-image" @click="showInvoice"></span>
                            <span class="pi pi-fw pi-file-pdf btn-image" @click="downloadPdf(slotProps.data.number)"></span>
                        </div>
                    </template>
                </Column>
            </DataTable>

        </div>
    </PrincipalLayout>
</template>