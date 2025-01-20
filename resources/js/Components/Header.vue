<script setup>
    import { Link, router } from '@inertiajs/vue3';
    import { Menubar } from 'primevue';
    const menu = [
        {
            label: 'Productos',
            icon: 'pi pi-fw pi-shopping-bag',
            items: [
                {
                    label: 'Crear',
                    icon: 'pi pi-fw pi-plus',
                    command: () => redirect('product.create')
                }
            ]
        },
        {
            label: 'Facturación',
            icon: 'pi pi-fw pi-shopping-cart',
            items: [
                {
                    label: 'Generar',
                    icon: 'pi pi-fw pi-plus',
                    command: () => redirect('invoice.create')
                },
                {
                    label: 'Ver lista',
                    icon: 'pi pi-fw pi-eye',
                    command: () => redirect('invoice.index')
                }
            ]
        }
    ]
    function redirect(routeName){
        router.get(route(routeName));
    }
    
</script>
<template>
    <div class="bg-primary-3">
        <nav class="">
            <Menubar :model="menu"  />
            <ul>
                <li><Link href=""/></li>
            </ul>
        </nav>
    </div>
</template>