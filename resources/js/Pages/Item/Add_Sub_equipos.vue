<script setup>
import 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

// --------------------------- ** -------------------------

const props = defineProps({
    initialEquipos: {
        type: Number,
        default: 1,
        required: true,
    },
    nombreDisplayed: {
        type: String,
        default: 'Equipos',
    }
});

const emit = defineEmits(['addRow']);

function agregarFila(tipo) {
    emit('addRow', tipo);
}
</script>

<template>
<div class="flex gap-4 items-center my-4">
    <button type="button"
            class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-green-600"
            @click="agregarFila('modelo1')">
        ➕ Agregar Equipo
    </button>
    <button type="button"
            class="px-4 py-2 bg-black text-white rounded hover:bg-green-600"
            @click="agregarFila('cobre')">
        ➕ Agregar Cobre
    </button>
    <button type="button"
            class="px-4 py-2 bg-black text-white rounded hover:bg-green-600"
            @click="agregarFila('cableado')">
        ➕ Agregar Cableado
    </button>
    <span class="ml-4 text-gray-700 dark:text-gray-300 text-lg">Cantidad de {{nombreDisplayed}}: {{ props.initialEquipos }}</span>
</div>
</template>