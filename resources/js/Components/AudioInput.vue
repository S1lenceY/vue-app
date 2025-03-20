<script setup>
import { shallowRef } from "vue";

// Referencias reactivas
const fileRef = shallowRef(null);
const fileMessage = shallowRef("Subir audio");

// Función para abrir el input file
const handleFile = () => fileRef.value.click();

// Función que maneja la selección de archivos
const handleUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        fileMessage.value = file.name;
    }
};
</script>

<template>
    <div class="flex flex-col items-center gap-2">
        <!-- Input file oculto -->
        <input
            ref="fileRef"
            type="file"
            accept="audio/*"
            class="hidden"
            @change="handleUpload"
        />

        <!-- Botón personalizado para subir archivo -->
        <button
            @click="handleFile"
            type="button"
            class="group/btn relative w-full md:max-w-44 shadow-sm rounded-md border border-gray-300 text-gray-700 text-sm"
        >
            <div
                class="relative flex items-center justify-center gap-2 rounded-md px-4 py-2"
            >
                <p class="truncate">{{ fileMessage }}</p>
                <svg
                    class="h-4 w-4 transition-transform duration-300 group-hover/btn:translate-x-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                    ></path>
                </svg>
            </div>
        </button>
    </div>
</template>
