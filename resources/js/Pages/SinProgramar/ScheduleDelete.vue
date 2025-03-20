<script setup>
const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(["close", "confirm"]);

const closeModal = () => {
    emit("close");
};

const confirmDelete = () => {
    emit("confirm");
};
</script>

<template>
    <div class="p-6 text-center space-y-5">
        <div
            class="inline-flex items-center justify-center w-12 h-12 bg-white border border-red-600 text-red-600 text-2xl rounded-full"
        >
            !
        </div>
        <h4 class="text-xl font-semibold">Eliminar Llamada</h4>
        <p class="text-gray-700 font-medium">
            ¿Estás seguro? Estás a punto de eliminar una llamada.
        </p>
        <div class="flex gap-4 text-sm">
            <button
                @click="closeModal"
                class="bg-white border border-gray-500 hover:bg-gray-500 text-gray-700 hover:text-white transition-colors px-3 py-2 rounded w-full"
            >
                Cancelar
            </button>
            <button
                @click="confirmDelete"
                class="bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded w-full"
            >
                Eliminar
            </button>
        </div>
    </div>
</template>
