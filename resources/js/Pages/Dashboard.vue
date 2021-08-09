<template>
    <Head title="Panel Administrativo" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel Administrativo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">Listado de Ordenes</h3>
                        <table class="w-full border">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            #
                                        </div>
                                    </th>
                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            Cliente
                                        </div>
                                    </th>
                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            Correo del Cliente
                                        </div>
                                    </th>
                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            Codigo de orden
                                        </div>
                                    </th>

                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            Status
                                        </div>
                                    </th>
                                    <th class="p-2 border-r text-sm font-thin text-gray-500">
                                        <div class="flex items-center justify-center">
                                            Action
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders" :key="order.id" class="bg-gray-100 text-center border-b text-sm text-gray-600">
                                    <td class="p-2 border-r">{{order.id}}</td>
                                    <td class="p-2 border-r">{{order.customer_name}}</td>
                                    <td class="p-2 border-r">{{order.customer_email}}</td>
                                    <td class="p-2 border-r">{{order.sale_code}}</td>
                                    <td class="p-2 border-r">{{order.status}}</td>
                                    <td>
                                        <a href="#" class="bg-blue-500 p-2 text-white hover:shadow-lg text-xs font-thin">Edit</a>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        
    },
    data() {
        return {
            orders: null,
        }
    },
    mounted() {
        
        axios.get('/orders')
            .then(response => {
                this.orders = response.data.orders})
    },
    methods: {
        formatPrice(value) {
            let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        status(status) {
            if ('created' === status) {
                return 'Venta creada'
            }

            if ('payed' === status) {
                return 'Pago realizado'
            }

            if ('rejected' === status) {
                return 'Pago en espera'
            }
        }
    }
}
</script>
