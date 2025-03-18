<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const cantidadSinProgramar = page.props.cantidadSinProgramar;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Bienvenido
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="py-6 text-green-600 font-bold">
                        Cantidad Total: {{ cantidadSinProgramar }}
                    </div>
                    <Link
                        :href="route('sinprogramar')"
                        class="h-fit inline-flex"
                    >
                        <div
                            class="hover:-translate-y-2 group bg-neutral-50 duration-500 w-44 h-44 flex text-neutral-600 flex-col justify-center items-center relative rounded-xl overflow-hidden shadow-md"
                        >
                            <svg
                                viewBox="0 0 200 200"
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute blur z-10 fill-green-300 duration-500 group-hover:blur-none group-hover:scale-105"
                            >
                                <path
                                    transform="translate(100 100)"
                                    d="M39.5,-49.6C54.8,-43.2,73.2,-36.5,78.2,-24.6C83.2,-12.7,74.8,4.4,69,22.5C63.3,40.6,60.2,59.6,49.1,64.8C38.1,70,19,61.5,0.6,60.7C-17.9,59.9,-35.9,67,-47.2,61.9C-58.6,56.7,-63.4,39.5,-70,22.1C-76.6,4.7,-84.9,-12.8,-81.9,-28.1C-79,-43.3,-64.6,-56.3,-49.1,-62.5C-33.6,-68.8,-16.8,-68.3,-2.3,-65.1C12.1,-61.9,24.2,-55.9,39.5,-49.6Z"
                                ></path>
                            </svg>

                            <div
                                class="z-20 flex flex-col justify-center items-center"
                            >
                                <span class="font-bold text-6xl ml-2">{{ cantidadSinProgramar }}</span>
                                <p class="font-bold">Sin Programar</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
