<template>
    <Head title="Welcome" />

    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center content-logo">
                                <Link href="/">
                                    <img :src="'/img/logo.png'">
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative bg-primary p-5">
                                <Link v-if="$page.props.auth" href="/dashboard" class="text-sm text-gray-700 underline">
                                    Dashboard
                                </Link>
                                <template v-else>
                                    <Link :href="route('login')" class="text-sm text-white no-underline left-0">
                                        Ingresar
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <Link v-if="$page.props.auth" href="/dashboard" class="text-sm text-gray-700 underline">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-700 underline left-0">
                                Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline left-0">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <div class="w-4/5 m-auto mt-12 bg-white border border-gray-200">
                    <div class="flex space-x-4">
                        <div class="p-5 flex-1">
                            <div class="flex space-x-4 text-center">
                                <div class="flex-1"><p class="font-serif font-bold font-base">Producto</p></div>
                                <div class="flex-1"><p class="font-serif font-bold font-base">Cantidad</p></div>
                                <div class="flex-1"><p class="font-serif font-bold font-base">Precio</p></div>
                                <div class="flex-1"><p class="font-serif font-bold font-base">Precio Total</p></div>
                            </div>
                            <hr/>
                            <div class="flex space-x-4 text-center">
                                <div class="flex-1">
                                    <img :src="'/img/phone1.jpeg'" alt="" class="w-20 m-auto">
                                    iPhone 12 Pro 4G
                                </div>
                                <div class="flex-1">
                                    <div class="mb-4 p-6">
                                        <input 
                                        id="quantity" 
                                            type="number" 
                                            v-model="quantity" 
                                            placeholder="Cantidad" 
                                            min="1" 
                                            class="shadow appearance-none border rounded w-48 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            @input="changeQuantity()"
                                        >
                                    </div>
                                </div>
                                <div class="flex-1 p-8"><p class="font-serif font-bold font-base">${{formatPrice(2000)}}</p></div>
                                <div class="flex-1 p-8"><p class="font-serif font-bold font-base">${{ formatPrice(total) }}</p></div>
                            </div>
                        </div>
                        
                        <div class="w-96 p-5">
                            <form @submit.prevent="checkForm(this)">
                                
                                <div class="w-90 p-5 border border-gray-200">
                                    <p class="font-serif font-bold text-2xl p-2">Datos personales</p>
                                    <hr />
                                    <div class="flex space-4 font-extralight p-2">
                                        <div class="flex-1 text-left">
                                            <input id="name" v-model="form.customer_name" type="text" placeholder="Nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="flex space-4 font-extralight p-2">
                                        <div class="flex-1 text-left">
                                            <input id="phone" v-model="form.customer_mobile" type="text" placeholder="Número telefonico" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="flex space-4 font-extralight p-2">
                                        <div class="flex-1 text-left">
                                            <input id="email" v-model="form.customer_email" type="email" placeholder="Correo electrónico" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        </div>
                                    </div>
                                    <p v-if="errors" class="bg-red-400 text-white font-bold p-2 mb-3">{{ errors }}</p>
                                </div>

                                <div class="w-90 mt-4 p-5 border border-gray-200">
                                    <p class="font-serif font-bold text-2xl p-2">Resumen de pedido</p>
                                    <hr />
                                    <div class="flex space-4 font-extralight p-2">
                                        <div class="flex-1 text-left">Subtotal ({{ quantity }})</div>
                                        <div class="flex-1 text-right">${{ formatPrice(total) }}</div>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <button class="bg-primary text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Comprar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
      Head,
      Link,
    },
    props: {
        canRegister: Boolean,
        auth: Boolean,
        quantityProps: Number,
        url: String
    },
    data() {
        return {
            errors: null,
            quantity: null,
            total: null,
            form: this.$inertia.form({
                quantity: null,
                customer_name: null,
                customer_mobile: null,
                customer_email: null,
                firstPayment: true
            })
        }
    },
    created() {
        this.quantity = this.quantityProps
        this.total = this.quantity * 2000
        this.form.quantity = this.quantity
    },
    methods: {

        formatPrice(value) {
            let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        changeQuantity() {
            console.log(this.quantity)
            this.form.quantity = this.quantity
            this.total = this.quantity * 2000
        },
        submit() {
            this.form.post(this.route('sale.payment'), {
                onFinish: () => window.location = this.url,
            })
        },
        checkForm(e) {
            if (this.form.quantity && this.form.customer_name && this.form.customer_mobile && this.form.customer_email) {
                this.errors = null;
                this.submit();
                return true;
            }

            if (!this.form.quantity) {
                this.errors = 'La cantidad es obligatorio.';
            }

            if (!this.form.customer_name) {
                this.errors = 'El nombre es obligatorio.';
            }

            if (!this.form.customer_mobile) {
                this.errors = 'El numero de telefono es obligatorio.';
            }

            if (!this.form.customer_email) {
                this.errors = 'El correo electronico es obligatorio.';
            }

            if (!this.form.quantity && !this.form.customer_name && !this.form.customer_mobile && !this.form.customer_email) {
                this.errors = 'Debe llenar todos los campos';
            }

            e.preventDefault();
        }
    }
}
</script>


<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    .content-logo {
        width: 20% !important;
    }

    .border-primary{
        border-color: #1ebfa0;
    }

    .bg-primary {
        background-color: #1ebfa0;
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

