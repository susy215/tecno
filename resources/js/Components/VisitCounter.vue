<template>
    <div class="fixed bottom-4 left-4 z-50">
        <span class="px-3 py-2 bg-gray-200 rounded shadow text-gray-700 text-sm font-semibold dark:bg-gray-600 dark:text-gray-200">
            Visitas: {{ count }}
        </span>
    </div>
</template>

<script setup>
defineProps({
    count: {
        type: Number,
        required: true
    }
});
</script>
