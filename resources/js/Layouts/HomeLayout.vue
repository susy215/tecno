<script setup>
import { ref, onMounted } from "vue";

import axios from 'axios';
import { initFlowbite } from "flowbite";

// import HomeLayout from "@/Layouts/HomeLayout.vue";

const visitCount = ref(0);

onMounted(() => {
    initFlowbite();

    // Registrar la visita
    axios.post('/api/page-visit', { page: window.location.pathname })
        .then(() => {
            // Obtener el contador total después de registrar
            axios.get('/api/total-visits')
                .then(res => {
                    visitCount.value = res.data.total || 0;
                })
                .catch(error => {
                    console.error('No se pudo obtener el contador total:', error);
                });
        })
        .catch(error => {
            console.error('No se pudo registrar la visita:', error);
        });

    // Obtener el contador total de visitas
    axios.get('/api/total-visits')
        .then(res => {
            visitCount.value = res.data.total || 0;
        })
        .catch(error => {
            console.error('No se pudo obtener el contador de visitas:', error);
        });
});

import Navbar from "@/Layouts/Navbar.vue";
import Footer from "@/Layouts/Footer.vue";
import AccessibleLayout from "@/Layouts/AccessibleLayout.vue";
import VisitCounter from "@/Components/VisitCounter.vue";
</script>

<template>
    <AccessibleLayout>
        <div>
            <Navbar></Navbar>
        </div>
        <main class="h-auto pt-5 ">
            <slot />
        </main>
        <div class="mt-20">
            <Footer>

            </Footer>
        </div>
        <VisitCounter :count="visitCount" />
    </AccessibleLayout>

</template>
