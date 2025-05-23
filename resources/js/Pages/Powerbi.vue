<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { watchEffect } from 'vue';


const props = defineProps({
    users: Number,
    roles: Number,
    reportes: Number,
    permissions: Number,
})

const widthAndHeight =[1940, 1240];


</script>

<template>
    <h2>Última actualización: 23 de mayo 2025</h2>
    <iframe title="3 Demco Comercial 3"
            src="https://app.powerbi.com/reportEmbed?reportId=f107a1c3-0e93-483d-b2a9-4a2f0de9817a&autoAuth=true&embeddedDemo=true" frameborder="0" allowFullScreen="true"
            :width="widthAndHeight[0]" :height="widthAndHeight[1]"
            class="pt-8"
    ></iframe>
<!--    <iframe title="3 Demco Comercial 3" :width="widthAndHeight[0]" :height="widthAndHeight[1]" src="https://app.powerbi.com/reportEmbed?reportId=f107a1c3-0e93-483d-b2a9-4a2f0de9817a&autoAuth=true&embeddedDemo=true" frameborder="0" allowFullScreen="true" class="pt-8"></iframe>-->
<!--        <iframe title="Demco Comercial" width="1940" height="1240" src="https://app.powerbi.com/reportEmbed?reportId=4fe1b4bc-0539-46c6-8492-d2082fa67662&autoAuth=true&embeddedDemo=true" frameborder="0" allowFullScreen="true"></iframe>-->
<!--        <iframe title="Demco Comercial" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=4fe1b4bc-0539-46c6-8492-d2082fa67662&autoAuth=true&embeddedDemo=true" frameborder="0" allowFullScreen="true"></iframe>-->
</template>
