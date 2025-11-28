<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
    ? 'relative px-2 py-2 flex items-center font-sans space-x-4 rounded-lg bg-yellow-800 text-white  hover:bg-yellow-700 dark:hover:bg-gray-700'
        : 'px-2 py-2 flex items-center space-x-4 font-sans rounded-lg text-textcolor group hover:bg-gray-100 hover:text-yellow-900 text-green-950'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
