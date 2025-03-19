<script setup>
import { ref } from "vue";

// Definir las props
const props = defineProps({
    detalle: Object, // Detalles del aviso sin programación
    formulario: Object,
    editando: Boolean,
});

// Emitir eventos al padre
const emit = defineEmits(["submit", "close"]);

// Estado local del formulario
const form = ref(props.formulario);

// Función para manejar el envío del formulario
const handleSave = () => {
    emit("submit"); // Emitir los datos del formulario al padre
};

// Función para cerrar el modal
const closeModal = () => {
    emit("close");
};
</script>

<template>
    <form @submit.prevent="handleSave">
        <!-- Campos del formulario -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Fecha de Contacto:</label
            >
            <input
                v-model="form.contact_date"
                type="date"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required
            />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Fecha Programada:</label
            >
            <input
                v-model="form.program_date"
                type="date"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Éxito:</label
            >
            <select
                v-model="form.is_success"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
                <option :value="true">Sí</option>
                <option :value="false">No</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Comentario:</label
            >
            <textarea
                v-model="form.comment"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            ></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700"
                >Ruta de Audio:</label
            >
            <input
                v-model="form.audio_path"
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
        </div>
        <div class="flex justify-end space-x-2">
            <button
                type="button"
                @click="closeModal"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
            >
                Cancelar
            </button>
            <button
                type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
            >
                Guardar
            </button>
        </div>
    </form>
</template>
