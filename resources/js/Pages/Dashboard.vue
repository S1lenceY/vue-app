<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const cantidadSinProgramar = page.props.cantidadSinProgramar;

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Bienvenido
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="py-6 text-green-600 font-bold">
                        Total de Avisos: {{ cantidadSinProgramar }}
                    </div>
                    <Link :href="route('sinprogramar')" class="h-20 inline-flex justify-between rounded-xl overflow-hidden bg-yellow-300">
                        <p class="px-6 text-slate-900 text-base font-normal leading-normal self-center">
                            Avisos sin programación
                        </p>
                        <div class="bg-yellow-200 w-20 flex-shrink-0 flex justify-center items-center text-center text-slate-900 text-2xl font-semibold leading-loose">
                            {{ cantidadSinProgramar }}
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
