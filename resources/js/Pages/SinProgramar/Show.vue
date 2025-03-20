<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";
import Modal from "@/Components/Modal.vue"; // Importar el componente Modal.vue
import ScheduleForm from "./ScheduleForm.vue";
import ScheduleDelete from "./ScheduleDelete.vue";

// Definir las props
const props = defineProps({
    detalle: Object, // Detalles del aviso sin programación
});

// Estado local
const mostrarModal = ref(false);
const editando = ref(false);

const formulario = ref({
    contact_date: "",
    program_date: null,
    is_success: true,
    comment: "",
    audio_path: "",
});

// Función para abrir el modal
const abrirModal = (llamada) => {
    if (llamada) {
        editando.value = true;
        console.log("Editando:", editando.value); // Depuración
        formulario.value = { ...llamada };
    } else {
        editando.value = false;
        console.log("Creando:", editando.value); // Depuración
        formulario.value = {
            contact_date: "",
            program_date: "",
            is_success: null,
            comment: "",
            audio_path: "",
        };
    }
    mostrarModal.value = true; // Abrir el modal
};

// Función para cerrar el modal
const cerrarModal = () => {
    mostrarModal.value = false; // Cerrar el modal
};

// Función para guardar y editar una llamada
const guardarLlamada = async () => {
    try {
        const url = editando.value
            ? route("llamadas.update", {
                  id: props.detalle.id,
                  llamada: formulario.value.id,
              })
            : route("llamadas.store", { id: props.detalle.id });

        const method = editando.value ? "put" : "post";

        const response = await axios[method](url, formulario.value);

        // Actualizar el estado local con los datos devueltos por el servidor
        props.detalle.llamadas = response.data.detalle.llamadas;

        // Cerrar el modal
        cerrarModal();
    } catch (error) {
        console.error("Error al guardar la llamada:", error);
    }
};

// Función para eliminar una llamada
const mostrarModalEliminar = ref(false);
const llamadaAEliminar = ref(null);

const abrirModalEliminar = (id) => {
    llamadaAEliminar.value = id;
    mostrarModalEliminar.value = true;
};

const cerrarModalEliminar = () => {
    mostrarModalEliminar.value = false;
};

const confirmarEliminarLlamada = async () => {
    if (!llamadaAEliminar.value) return;

    try {
        const response = await axios.delete(
            route("llamadas.destroy", {
                id: props.detalle.id,
                llamada: llamadaAEliminar.value,
            })
        );

        // Actualizar el estado local con los datos devueltos por el servidor
        props.detalle.llamadas = response.data.detalle.llamadas;

        // Cerrar el modal y resetear valores
        cerrarModalEliminar();
        llamadaAEliminar.value = null;
    } catch (error) {
        console.error("Error al eliminar la llamada:", error);
    }
};

const formatFecha = (fecha) => {
    return new Date(fecha).toLocaleString("es-PE", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
    });
};
</script>

<template>
    <Head title="Detalle del Aviso" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Aviso {{ detalle.id_poliza }}
                </h2>
                <Link :href="route('sinprogramar')">
                    <PrimaryButton>Regresar</PrimaryButton>
                </Link>
            </div>
        </template>

        <!-- Detalles -->
        <section class="pt-6 mx-auto space-y-4 max-w-7xl px-4 sm:px-6 lg:px-8">
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

        <!-- Llamadas -->
        <div class="mx-auto max-w-7xl space-y-4 px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Llamadas</h3>
                <PrimaryButton @click="abrirModal(null)">Añadir</PrimaryButton>
            </div>
            <section class="overflow-x-auto bg-white shadow-sm rounded-lg">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead
                        class="text-xs text-black font-bold uppercase bg-white border-b"
                    >
                        <tr>
                            <th class="px-2 py-2">#</th>
                            <th scope="col" class="px-4 py-3 text-nowrap">
                                Fecha de Contacto
                            </th>
                            <th scope="col" class="px-4 py-3 text-nowrap">
                                Fecha Programada
                            </th>
                            <th scope="col" class="px-4 py-3">Comentario</th>
                            <th scope="col" class="px-4 py-3">Éxito</th>
                            <th scope="col" class="px-4 py-3 text-nowrap">
                                Fecha y Hora Registro
                            </th>
                            <th scope="col" class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody
                        class="text-slate-900 text-xs font-normal leading-none"
                    >
                        <tr
                            v-for="(llamada, i) in detalle.llamadas"
                            :key="llamada.id"
                            class="bg-white border-b"
                        >
                            <td class="px-2 py-2">
                                {{ i + 1 }}
                            </td>
                            <td class="px-4 py-2">
                                {{ llamada.contact_date }}
                            </td>
                            <td class="px-4 py-2">
                                {{
                                    llamada.program_date
                                        ? llamada.program_date
                                        : "-"
                                }}
                            </td>
                            <td class="px-4 py-2 min-w-40 max-w-40">
                                {{ llamada.comment }}
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    :class="{
                                        'px-3 p-1 bg-green-500 text-white rounded-lg':
                                            llamada.is_success,
                                        'px-2 p-1 bg-red-500 text-white rounded-lg':
                                            !llamada.is_success,
                                    }"
                                    >{{
                                        llamada.is_success ? "Sí" : "No"
                                    }}</span
                                >
                            </td>
                            <td class="px-4 py-2">
                                {{ formatFecha(llamada.created_at) }}
                            </td>
                            <td class="space-x-4 px-4 py-2">
                                <button @click="abrirModal(llamada)">✏️</button>
                                <button @click="abrirModalEliminar(llamada.id)">
                                    🗑️
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>

        <!-- Modal de Guardar o Editar -->
        <Modal :show="mostrarModal" @close="cerrarModal" maxWidth="xl">
            <ScheduleForm
                :detalle="detalle"
                :formulario="formulario"
                :editando="editando"
                @submit="guardarLlamada"
                @close="cerrarModal"
            />
        </Modal>

        <!-- Modal para Eliminar -->
        <Modal
            :show="mostrarModalEliminar"
            @close="cerrarModalEliminar"
            maxWidth="md"
        >
            <ScheduleDelete
                :show="mostrarModalEliminar"
                @close="cerrarModalEliminar"
                @confirm="confirmarEliminarLlamada"
            />
        </Modal>
    </AuthenticatedLayout>
</template>
