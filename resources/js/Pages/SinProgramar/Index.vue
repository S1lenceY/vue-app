<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const sinprogramar = ref(page.props.sinprogramar); // Datos paginados
const perPage = ref(page.props.ziggy.query?.per_page || 5); // Número de registros por página
const filters = ref(page.props.filters || {}); // Valores de los filtros

// Función para aplicar filtros
const applyFilters = () => {
    const url = new URL(window.location.href);

    // Limpiar los parámetros de filtro existentes
    url.searchParams.delete("cultivo");
    url.searchParams.delete("contratante");
    url.searchParams.delete("tipo_evento");
    url.searchParams.delete("inspector");
    url.searchParams.delete("ubicacion");

    // Agregar los nuevos parámetros de filtro
    if (filters.value.cultivo) {
        url.searchParams.set("cultivo", filters.value.cultivo);
    }
    if (filters.value.contratante) {
        url.searchParams.set("contratante", filters.value.contratante);
    }
    if (filters.value.tipo_evento) {
        url.searchParams.set("tipo_evento", filters.value.tipo_evento);
    }
    if (filters.value.inspector) {
        url.searchParams.set("inspector", filters.value.inspector);
    }
    if (filters.value.ubicacion) {
        url.searchParams.set("ubicacion", filters.value.ubicacion);
    }

    // Navegar a la nueva URL
    router.visit(url.toString(), {
        preserveState: true,
        replace: true,
        onSuccess: (response) => {
            sinprogramar.value = response.props.sinprogramar;
        },
    });
};

// Función para cambiar de página
const changePage = (url) => {
    if (url) {
        router.visit(url, {
            preserveState: true, // Mantener el estado actual
            replace: true, // Reemplazar la URL sin añadir entradas al historial
            onSuccess: (response) => {
                sinprogramar.value = response.props.sinprogramar; // Actualizar los datos
            },
        });
    }
};

// Función para actualizar el número de registros por página
const updatePerPage = (event) => {
    const newPerPage = event.target.value;
    perPage.value = newPerPage;

    // Construir la URL con el nuevo valor de per_page
    const url = new URL(window.location.href);
    url.searchParams.set("per_page", newPerPage);

    // Navegar a la nueva URL
    router.visit(url.toString(), {
        preserveState: true,
        replace: true,
        onSuccess: (response) => {
            sinprogramar.value = response.props.sinprogramar;
        },
    });
};
</script>

<template>
    <Head title="sin-programar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Avisos sin programación
            </h2>
        </template>

        <!-- Filtros -->
        <section class="pt-12 space-y-4 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-800">Filtros</h3>
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Filtro por cultivo -->
                <div>
                    <label
                        for="filter-cultivo"
                        class="block text-sm font-medium text-gray-700"
                        >Cultivo</label
                    >
                    <input
                        id="filter-cultivo"
                        v-model="filters.cultivo"
                        @input="applyFilters"
                        type="text"
                        placeholder="Buscar por cultivo"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    />
                </div>

                <!-- Filtro por contratante -->
                <div>
                    <label
                        for="filter-contratante"
                        class="block text-sm font-medium text-gray-700"
                        >Contratante</label
                    >
                    <input
                        id="filter-contratante"
                        v-model="filters.contratante"
                        @input="applyFilters"
                        type="text"
                        placeholder="Buscar por contratante"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    />
                </div>

                <!-- Filtro por tipo de evento -->
                <div>
                    <label
                        for="filter-tipo-evento"
                        class="block text-sm font-medium text-gray-700"
                        >Tipo de Evento</label
                    >
                    <select
                        id="filter-tipo-evento"
                        v-model="filters.tipo_evento"
                        @change="applyFilters"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    >
                        <option value="">Todos</option>
                        <option value="ALEJANDRO_TORRES">Granizo</option>
                        <option value="INCENDIO">Incendio</option>
                        <option value="INUNDACIÓN">Inundación</option>
                        <option value="SEQUIA">Sequía</option>
                        <option value="VIENTO">Viento</option>
                        <option value="OTROS">Otros</option>
                    </select>
                </div>

                <!-- Filtro por inspector -->
                <div>
                    <label
                        for="filter-inspector"
                        class="block text-sm font-medium text-gray-700"
                        >Inspector</label
                    >
                    <input
                        id="filter-inspector"
                        v-model="filters.inspector"
                        @input="applyFilters"
                        type="text"
                        placeholder="Buscar por inspector"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    />
                </div>

                <!-- Filtro por ubicación (departamento/provincia) -->
                <div>
                    <label
                        for="filter-ubicacion"
                        class="block text-sm font-medium text-gray-700"
                        >Ubicación</label
                    >
                    <input
                        id="filter-ubicacion"
                        v-model="filters.ubicacion"
                        @input="applyFilters"
                        type="text"
                        placeholder="Buscar por ubicación"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    />
                </div>
            </div>
        </section>

        <!-- Tabla -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <section
                    class="overflow-x-auto bg-white shadow-sm rounded-lg"
                >
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-white border-b"
                        >
                            <tr>
                                <th
                                    scope="col"
                                    class="px-3 py-3 sticky left-0 bg-white min-w-[100px]"
                                >
                                    ID Aviso
                                </th>
                                <th scope="col" class="px-4 py-3">Póliza</th>
                                <th scope="col" class="px-4 py-3">Cultivo</th>
                                <th scope="col" class="px-4 py-3">
                                    Contratante
                                </th>
                                <th scope="col" class="px-4 py-3">Asegurado</th>
                                <th scope="col" class="px-4 py-3">
                                    Departamento
                                </th>
                                <th scope="col" class="px-4 py-3">Provincia</th>
                                <th scope="col" class="px-4 py-3">Distrito</th>
                                <th scope="col" class="px-4 py-3">Dirección</th>
                                <th scope="col" class="px-4 py-3">
                                    Tipo de Evento
                                </th>
                                <th scope="col" class="px-4 py-3">Inspector</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="sinprogramars in sinprogramar.data"
                                class="bg-white border-b"
                            >
                                <th
                                    scope="row"
                                    class="font-medium text-gray-900 whitespace-nowrap sticky left-0 bg-white"
                                >
                                    <Link
                                        :href="route('sinprogramar.show', sinprogramars.id)"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded ml-3"
                                    >
                                        {{ sinprogramars.id_poliza }}
                                    </Link>
                                </th>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.poliza }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.cultivo }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.contratante }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.asegurado }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.departamento }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.provincia }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.distrito }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.direccion }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.tipo_evento }}
                                </td>
                                <td class="px-2 py-2">
                                    {{ sinprogramars.inspector }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <!-- Paginación -->
                <div class="flex justify-between mt-4 flex-col sm:flex-row">
                    <!-- Mostrando tanto de tantos registros -->
                    <div class="flex justify-center items-center mt-4 sm:mt-0">
                        <p class="text-sm text-gray-700">
                            Mostrando {{ sinprogramar.from }} a
                            {{ sinprogramar.to }} de
                            {{ sinprogramar.total }} registros
                        </p>
                    </div>

                    <div class="flex justify-center mt-4 sm:mt-0 space-x-4">
                        <!-- Selector para cambiar el número de registros por página -->
                        <div>
                            <label for="per-page" class="mr-2 text-sm"
                                >Mostrar:</label
                            >
                            <select
                                id="per-page"
                                @change="updatePerPage"
                                class="border border-gray-300 rounded-md text-xs"
                            >
                                <option value="5" :selected="perPage === 5">
                                    5
                                </option>
                                <option value="10" :selected="perPage === 10">
                                    10
                                </option>
                                <option value="15" :selected="perPage === 15">
                                    15
                                </option>
                            </select>
                        </div>

                        <!-- Botones de Paginación -->
                        <nav aria-label="Page navigation">
                            <ul class="inline-flex -space-x-px text-sm">
                                <!-- Botón "Anterior" -->
                                <li>
                                    <button
                                        @click="
                                            changePage(
                                                sinprogramar.prev_page_url
                                            )
                                        "
                                        :disabled="!sinprogramar.prev_page_url"
                                        class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <
                                    </button>
                                </li>

                                <!-- Números de página -->
                                <li
                                    v-for="page in sinprogramar.last_page"
                                    :key="page"
                                >
                                    <button
                                        @click="
                                            changePage(
                                                `${sinprogramar.path}?page=${page}`
                                            )
                                        "
                                        :class="[
                                            page === sinprogramar.current_page
                                                ? 'z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700'
                                                : 'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700',
                                        ]"
                                    >
                                        {{ page }}
                                    </button>
                                </li>

                                <!-- Botón "Siguiente" -->
                                <li>
                                    <button
                                        @click="
                                            changePage(
                                                sinprogramar.next_page_url
                                            )
                                        "
                                        :disabled="!sinprogramar.next_page_url"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        >
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
