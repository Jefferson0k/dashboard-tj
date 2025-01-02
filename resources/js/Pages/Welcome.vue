<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Sistema Integral de Salud" />
    <div class="min-h-screen bg-gradient-to-b from-sky-50 via-white to-blue-50">
        <div class="relative overflow-hidden">
            <!-- Navegación -->
            <header class="absolute top-0 left-0 right-0 z-50 px-6 py-4">
                <nav v-if="canLogin" class="flex justify-end max-w-7xl mx-auto">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded-md px-4 py-2 text-sky-600 hover:bg-sky-50 transition-colors duration-200"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-md px-4 py-2 text-sky-600 hover:bg-sky-50 transition-colors duration-200"
                        >
                            Log in
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-md px-4 py-2 text-sky-600 hover:bg-sky-50 transition-colors duration-200"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </header>
            
            <!-- Contenido principal -->
            <div class="relative px-6 py-12 mx-auto max-w-7xl sm:py-16 lg:py-20">
                <!-- Header con logo -->
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-800 sm:text-5xl md:text-6xl">
                        <span class="block">Seguro  Integral</span>
                        <span class="block text-sky-600">de Salud</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-600 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Brindando acceso a servicios de salud de calidad para todos los peruanos
                    </p>
                </div>

                <!-- Imágenes principales -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <img 
                            src="https://cdn.www.gob.pe/uploads/campaign/photo/000/082/960/campaign_DISEÑO_DE_VENTANA_DE_CAMPAÑA_EN_LA_WEB_Mesa_de_trabajo_1__1_.jpg"
                            alt="SIS Campaña"
                            class="w-full h-64 object-cover"
                        />
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <img 
                            src="https://eltiempope36ae5.zapwp.com/wp-content/uploads/2024/06/sis-gratuito.jpg"
                            alt="SIS Gratuito"
                            class="w-full h-64 object-cover"
                        />
                    </div>
                </div>

                <!-- Características principales -->
                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Característica 1 -->
                        <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-sky-100">
                                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-xl font-semibold text-gray-800">Cobertura Total</h2>
                            <p class="mt-2 text-center text-gray-600">Acceso a servicios de salud integrales</p>
                        </div>

                        <!-- Característica 2 -->
                        <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-sky-100">
                                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-xl font-semibold text-gray-800">Atención Rápida</h2>
                            <p class="mt-2 text-center text-gray-600">Procesos simplificados y eficientes</p>
                        </div>

                        <!-- Característica 3 -->
                        <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-sky-100">
                                <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-xl font-semibold text-gray-800">Seguridad</h2>
                            <p class="mt-2 text-center text-gray-600">Protección de datos y privacidad</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-16 text-center text-sm text-gray-500">
                    <p>Sistema Integral de Salud - Perú | Laravel v{{ laravelVersion }} | PHP v{{ phpVersion }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.bg-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
</style>