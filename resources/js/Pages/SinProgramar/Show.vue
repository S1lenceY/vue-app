<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    detalle: Object, // Propiedad que contiene los datos del registro
});
</script>

<template>
    <Head title="Detalle del Aviso" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Aviso {{ detalle.id_poliza }}
                </h2>
                <PrimaryButton>
                    <Link :href="route('sinprogramar')"> Regresar </Link>
                </PrimaryButton>
            </div>
        </template>

        <!-- Detalles -->
        <section class="pt-12 mx-auto space-y-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800">Detalles</h3>
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >ID Aviso:</label
                        >
                        <p class="text-gray-900">{{ detalle.id_poliza }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Póliza:</label
                        >
                        <p class="text-gray-900">{{ detalle.poliza }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Cultivo:</label
                        >
                        <p class="text-gray-900">{{ detalle.cultivo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Contratante:</label
                        >
                        <p class="text-gray-900">{{ detalle.contratante }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Departamento:</label
                        >
                        <p class="text-gray-900">{{ detalle.departamento }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Provincia:</label
                        >
                        <p class="text-gray-900">{{ detalle.provincia }}</p>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
