<script setup>
import { Head, Link } from "@inertiajs/vue3";

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

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Welcome" />
    <div class="relative min-h-screen flex flex-col bg-gray-100 text-gray-700">
        <!-- Imagen de fondo -->
        <img
            id="background"
            class="absolute left-0 top-0 w-[700px] opacity-20 lg:opacity-100"
            src="/images/backgroundGreen.svg"
        />

        <!-- Contenido principal -->
        <div
            class="relative flex flex-1 flex-col items-center justify-center px-6 selection:bg-green-500 selection:text-white"
        >
            <div class="w-full max-w-3xl lg:max-w-6xl">
                <!-- Header -->
                <header
                    class="grid grid-cols-2 items-center gap-4 lg:grid-cols-3"
                >
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <svg
                            class="h-12 w-auto text-green-500 lg:h-16"
                            viewBox="0 0 62 65"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <!-- Aquí va tu código SVG -->
                        </svg>
                    </div>
                </header>

                <!-- Contenedor principal -->
                <section class="mt-10 flex flex-col items-center text-center">
                    <h1
                        class="text-4xl font-extrabold text-gray-900 sm:text-5xl"
                    >
                        ¡Bienvenido!
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Explora lo mejor de este sitio web increíble.
                    </p>

                    <!-- Botón de acción -->
                    <div
                        class="flex flex-col bg-[#14532d] w-64 p-2 mt-6 rounded-3xl gap-1"
                    >
                        <template v-if="!$page.props.auth.user">
                            <!-- Botón Log in -->
                            <a
                                :href="route('login')"
                                class="bg-[#15803d] hover:bg-[#16a34a] hover:scale-[1.065] hover:translate-y-[-7px] hover:rounded-[23px] hover:rounded-bl-none hover:rounded-br-none px-6 py-2 rounded-2xl rounded-bl-lg rounded-br-lg transition-all text-center text-[#eafbea] hover:text-[#d1fadf] font-medium cursor-pointer"
                            >
                                Log in
                            </a>

                            <!-- Botón Register (si el registro está habilitado) -->
                            <a
                                v-if="canRegister"
                                :href="route('register')"
                                class="bg-[#166534] hover:bg-[#1a7f3f] hover:scale-[1.065] hover:translate-y-[7px] hover:rounded-[23px] hover:rounded-tl-none hover:rounded-tr-none px-6 py-2 rounded-2xl rounded-tl-lg rounded-tr-lg transition-all text-center text-[#eafbea] hover:text-[#c9f7d6] font-medium cursor-pointer"
                            >
                                Register
                            </a>
                        </template>

                        <!-- Botón Dashboard si el usuario está autenticado -->
                        <a
                            v-else
                            :href="route('dashboard')"
                            class="bg-[#065f46] hover:bg-[#047857] hover:scale-[1.03] px-6 py-2 rounded-2xl transition-all text-center text-white font-medium cursor-pointer"
                        >
                            Dashboard
                        </a>
                    </div>
                </section>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-4 text-center text-sm text-black">
            Hecho por: <span class="font-semibold">S1lenceY</span>
        </footer>
    </div>
</template>
