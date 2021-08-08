<template>
    <Head title="Inicio" />

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
                                    <img :src="'img/logo.png'">
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative bg-primary p-5">
                                <Link v-if="$page.props.auth.user" href="/dashboard" class="text-sm text-gray-700 underline">
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
                        <Link v-if="$page.props.auth.user" href="/dashboard" class="text-sm text-gray-700 underline">
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
                    <div class="w-40">
                        <img :src="'img/phone1.jpeg'" alt="" class="w-40">
                        <img :src="'img/phone2.jpeg'" alt="" class="w-40">
                        <img :src="'img/phone3.jpeg'" alt="" class="w-40">
                    </div>
                    <div class="flex-1 border border-gray-200">
                        <img :src="'img/phone2.jpeg'" alt="" class="w-screen">
                    </div>
                    <div class="flex-1 p-6 text-justify">
                        <p>
                        Pantalla Super Retina XDR <br/>
                        Pantalla OLED de 6.1 pulgadas (diagonal) sin marco <br/>
                        Resolución de 2532 x 1170 pixeles a 460 ppi <br/><br/>
                        La pantalla del iPhone 12 Pro tiene esquinas redondeadas que siguen el elegante diseño curvo del teléfono, y las esquinas se encuentran dentro de un rectángulo estándar. Si se mide en forma de rectángulo estándar, la pantalla tiene 6.06 pulgadas en diagonal (el área real de visualización es menor).
                        </p>
                            
                        <p class="font-serif text-5xl italic mt-5">$2000</p>
                        <div>
                            <form  @submit.prevent="submit" class="mt-8">
                                <div class="mb-4">
                                    <input id="quantity" v-model="form.quantity" type="number" placeholder="Cantidad" min="1" class="shadow appearance-none border rounded w-48 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <button  class="bg-primary text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Añadir al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </div>
</template>

<script>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                quantity: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('sale.detail'), {
                onFinish: () => this.form.reset('quantity'),
            })
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

