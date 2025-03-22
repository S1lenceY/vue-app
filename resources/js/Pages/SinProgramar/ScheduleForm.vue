<script setup>
import { ref, onMounted } from "vue";
import AudioInput from "@/Components/AudioInput.vue";

// Definir las props
const props = defineProps({
    detalle: Object, // Detalles del aviso sin programación
    formulario: Object,
    editando: Boolean,
});

// Emitir eventos al padre
const emit = defineEmits(["submit", "close"]);

// Estado local del formulario
const form = ref({ ...props.formulario });
const audioFile = ref(null);

// Depuración
console.log("Props recibidas:", props);
onMounted(() => {
    console.log("Valor de editando al montar:", props.editando);
});

// Función para preparar los datos del formulario
const prepareFormData = () => {
    const formData = new FormData();
    formData.append("contact_date", form.value.contact_date || "");
    formData.append("program_date", form.value.program_date || "");
    formData.append("is_success", form.value.is_success ? "1" : "0");
    formData.append("comment", form.value.comment || "");

    if (audioFile.value) {
        formData.append("audio_file", audioFile.value);
    }

    if (props.editando) {
        formData.append("id", form.value.id);
    }

    return formData;
};

// Función para emitir el evento submit
const emitSubmit = (formData) => {
    emit("submit", formData);
};

// Función para manejar el envío del formulario
const handleSave = () => {
    try {
        const formData = prepareFormData();
        emitSubmit(formData);
    } catch (error) {
        console.error("Error al preparar los datos:", error);
    }
};

// Función para manejar cambios en el archivo de audio
const handleFileChange = (file) => {
    audioFile.value = file;
};

// Función para cerrar el modal
const closeModal = () => {
    emit("close");
};
</script>

<template>
    <form @submit.prevent="handleSave" class="p-4 space-y-5">
        <div class="border-b border-gray-200">
            <h3 v-if="editando" class="text-lg font-semibold">
                Editar Llamada
            </h3>
            <h3 v-else class="text-lg font-semibold">Crear Llamada</h3>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700"
                    >Fecha de Contacto:</label
                >
                <input
                    v-model="form.contact_date"
                    type="date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    required
                />
            </div>
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700"
                    >Fecha Programada:</label
                >
                <input
                    v-model="form.program_date"
                    type="date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                />
            </div>
            <div class="w-full" v-if="!editando">
                <label class="block text-sm font-medium text-gray-700"
                    >Éxito:</label
                >
                <select
                    v-model="form.is_success"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                    required
                >
                    <option :value="true">Sí</option>
                    <option :value="false">No</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700"
                >Comentario:</label
            >
            <textarea
                v-model="form.comment"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
            ></textarea>
        </div>
        <div class="flex flex-col md:flex-row justify-between md:items-center">
            <div class="mb-4 md:mb-0" v-if="!editando">
                <AudioInput name="file" @file-selected="handleFileChange" />
            </div>
            <div class="flex gap-3 text-sm h-full">
                <button
                    type="button"
                    @click="closeModal"
                    class="bg-white border border-green-500 hover:bg-green-500 text-gray-700 hover:text-white transition-colors px-3 py-2 rounded w-full"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white px-3 py-2 rounded w-full"
                >
                    Guardar
                </button>
            </div>
        </div>
    </form>
</template>
