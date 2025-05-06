<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect,ref} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

// --------------------------- ** -------------------------

const props = defineProps({
    initialEquipos: {
        type: Number,
        default: 1,
    }
});

const emit = defineEmits(['updateEquipos']);

// Control interno
const cantidadEquipos = ref(props.initialEquipos);

// Métodos
function agregarEquipo() {
    cantidadEquipos.value++;
    emit('updateEquipos', cantidadEquipos.value);
}

function quitarEquipo() {
    if (cantidadEquipos.value > 1) {
        cantidadEquipos.value--;
        emit('updateEquipos', cantidadEquipos.value);
    }
}
</script>

<template>
<div class="flex gap-4 items-center my-4">
    <button type="button"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
            @click="agregarEquipo">
        ➕ Agregar Equipo
    </button>
    <button type="button"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
            @click="quitarEquipo">
        ➖ Quitar Equipo
    </button>
    <span class="ml-4 text-gray-700 dark:text-gray-300">Cantidad: {{ cantidadEquipos }}</span>
</div>
</template>
