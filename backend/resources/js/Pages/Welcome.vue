<script setup>
defineProps({
    naziv: String,
    poruka: String,
});
</script>

<template>
    <div class="flex min-h-screen flex-col items-center justify-center gap-3 bg-white text-center">
        <h1 class="text-3xl font-semibold text-[#0E8275]">{{ naziv }}</h1>
        <p class="text-gray-600">{{ poruka }}</p>
    </div>
</template>
