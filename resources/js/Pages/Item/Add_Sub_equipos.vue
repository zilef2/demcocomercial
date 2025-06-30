<script setup>
import {onMounted, reactive, watch, watchEffect,ref} from 'vue';
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

const emit = defineEmits(['updatEquipos']);
const cantidadEquipos = ref(props.initialEquipos);

function agregarEquipo() {
    cantidadEquipos.value++;
    emit('updatEquipos', cantidadEquipos.value);
}

function quitarEquipo() {
    if (cantidadEquipos.value > 1) {
        cantidadEquipos.value--;
        emit('updatEquipos', cantidadEquipos.value);
    }
}

watch(() => props.initialEquipos, (nuevoValor) => {
    cantidadEquipos.value = nuevoValor;
});

</script>

<template>
<div class="flex gap-4 items-center my-4">
    <button type="button"
            class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-green-600"
            @click="agregarEquipo">
        ➕ Agregar {{ props.nombreDisplayed }}
    </button>
    <button type="button"
            class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-600"
            @click="quitarEquipo">
        ➖ Quitar {{ props.nombreDisplayed }}
    </button>
    <span class="ml-4 text-gray-700 dark:text-gray-300 text-lg">Cantidad de {{nombreDisplayed}}: {{ cantidadEquipos }}</span>
</div>
</template>
