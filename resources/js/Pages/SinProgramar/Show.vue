<script setup>
/* Importaciones */
import { ref } from "vue";
import axios from "axios";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import ScheduleForm from "./ScheduleForm.vue";
import ScheduleDelete from "./ScheduleDelete.vue";

/* Definir Props */
const props = defineProps({
    detalle: {
        type: Object,
        required: true,
        validator: (value) =>
            value && value.id_poliza && Array.isArray(value.llamadas),
    },
});

/* Estados Reactivos */
const llamadas = ref([...props.detalle.llamadas]); // ✅ Mantener reactividad
const mostrarModal = ref(false);
const editando = ref(false);
const mostrarModalEliminar = ref(false);
const llamadaAEliminar = ref(null);

// Resetear formulario
const resetFormulario = () => ({
    contact_date: "",
    program_date: "",
    is_success: null,
    comment: "",
    audio_path: "",
});

const formulario = ref(resetFormulario());

// Gestión de Modales
const modalActivo = ref(null);

const inicializarFormulario = (tipo, llamada = null) => {
    if (tipo === "editar") {
        editando.value = true;
        formulario.value = { ...llamada };
    } else if (tipo === "crear") {
        editando.value = false;
        formulario.value = resetFormulario();
    } else if (tipo === "eliminar") {
        llamadaAEliminar.value = llamada?.id || null;
    }
};

const abrirModal = (tipo, llamada = null) => {
    modalActivo.value = tipo;
    inicializarFormulario(tipo, llamada);

    mostrarModal.value = tipo !== "eliminar"; // Si no es "eliminar", es "crear" o "editar"
    mostrarModalEliminar.value = tipo === "eliminar";
};

const cerrarModal = async () => {
    modalActivo.value = null;
    mostrarModal.value = false;
    mostrarModalEliminar.value = false;
    formulario.value = resetFormulario();
    llamadaAEliminar.value = null;
};

/* Función para hacer peticiones Axios */
const enviarPeticion = async (url, method, data) => {
    try {
        const response = await axios({
            method,
            url,
            data,
            headers: { "Content-Type": "multipart/form-data" },
        });
        return response.data;
    } catch (error) {
        console.error("Error en la petición:", error.response?.data);
        throw error;
    }
};

/* Guardar/Editar Llamada */
const guardarLlamada = async (formData) => {
    try {
        let url = route("llamadas.store", { id: props.detalle.id });
        let method = "post";

        if (editando.value) {
            url = route("llamadas.update", {
                id: props.detalle.id,
                llamada: formData.get("id"),
            });
            formData.append("_method", "PUT");
        }

        const response = await enviarPeticion(url, method, formData);
        const nuevaLlamada = response.detalle;

        // ✅ Reemplazar o añadir llamada
        const index = llamadas.value.findIndex(
            (ll) => ll.id === nuevaLlamada.id
        );
        if (index !== -1) llamadas.value[index] = nuevaLlamada;
        else llamadas.value.push(nuevaLlamada);

        cerrarModal();
    } catch (error) {
        console.error("Error al guardar la llamada:", error);
    }
};

/* Eliminar Llamada */
const confirmarEliminarLlamada = async () => {
    if (!llamadaAEliminar.value) return;

    try {
        const url = route("llamadas.destroy", {
            id: props.detalle.id,
            llamada: llamadaAEliminar.value,
        });

        await enviarPeticion(url, "delete");

        llamadas.value = llamadas.value.filter(
            (ll) => ll.id !== llamadaAEliminar.value
        );
        await cerrarModal(); // ✅ Esperar que se elimine antes de cerrar modal
    } catch (error) {
        console.error("Error al eliminar la llamada:", error);
    }
};

/* Formatear fecha */
const formatFecha = (fecha) => {
    if (!fecha) return "-";
    return new Intl.DateTimeFormat("es-PE", {
        dateStyle: "short",
        timeStyle: "medium",
        hour12: false,
    }).format(new Date(fecha));
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
                <PrimaryButton @click="abrirModal('crear')"
                    >Añadir</PrimaryButton
                >
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
                            <th scope="col" class="px-4 py-3">Audio</th>
                            <th scope="col" class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody
                        class="text-slate-900 text-xs font-normal leading-none"
                    >
                        <tr
                            v-for="(llamada, i) in llamadas"
                            :key="llamada.id"
                            class="bg-white border-b"
                        >
                            <td class="px-2 py-2">{{ i + 1 }}</td>
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
                            <td class="px-4 py-2">
                                <audio
                                    controls
                                    v-if="llamada.audio_path"
                                    class="w-48"
                                >
                                    <source
                                        :src="`/storage/${llamada.audio_path}`"
                                        type="audio/mpeg"
                                    />
                                    Tu navegador no soporta el elemento de
                                    audio.
                                </audio>
                                <span v-else>-</span>
                            </td>
                            <td class="space-x-5 px-4 py-2 text-center">
                                <button
                                    @click="abrirModal('editar', llamada)"
                                    class="scale-100 hover:scale-125"
                                >
                                    ✏️
                                </button>
                                <button
                                    @click="abrirModal('eliminar', llamada)"
                                    class="scale-100 hover:scale-125"
                                >
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
        <Modal :show="mostrarModalEliminar" @close="cerrarModal" maxWidth="md">
            <ScheduleDelete
                :show="mostrarModalEliminar"
                @close="cerrarModal"
                @confirm="confirmarEliminarLlamada"
            />
        </Modal>
    </AuthenticatedLayout>
</template>
