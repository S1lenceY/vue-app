<script setup>
import { onMounted, ref } from "vue";

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="flex w-full items-center gap-1.5 pt-1">
        <input
            ref="input"
            type="file"
            class="flex h-10 w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium"
            accept="audio/*"
        />
    </div>
</template>
