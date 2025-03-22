<script setup>
import { onMounted, ref } from "vue";
import L from "leaflet";

// Props para recibir las coordenadas
const props = defineProps({
    coordinates: {
        type: String,
        required: true,
    },
});

// Referencia al mapa
const map = ref(null);

onMounted(() => {
    // Parsear las coordenadas recibidas
    const [lat, lng] = props.coordinates.split(" ").map(Number);

    // Inicializar el mapa
    map.value = L.map("map").setView([lat, lng], 10); // 13 es el nivel de zoom

    // Agregar el tile layer (capa base del mapa)
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map.value);

    // Agregar un marcador en las coordenadas
    L.marker([lat, lng])
        .addTo(map.value)
        .bindPopup(`${lat}, ${lng}`) // Mostrar las coordenadas en el popup
        .openPopup();
});
</script>

<template>
    <div id="map" class="w-full max-w-md h-96 rounded-md"></div>
</template>
