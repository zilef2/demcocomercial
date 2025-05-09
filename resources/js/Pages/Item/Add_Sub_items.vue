<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';

import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect,ref} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

// --------------------------- ** -------------------------

const props = defineProps({
    initialItems: {
        type: Number,
        required: true,
    },
    nombreDisplayed: {
        type: String,
        default: 'Items',
    }
});

const emit = defineEmits(['updateItems']);
const cantidadItems = ref(props.initialItems);

function agregarEquipo() {
    cantidadItems.value++;
    emit('updateItems', cantidadItems.value);
}

function quitarEquipo() {
    if (cantidadItems.value > 1) {
        cantidadItems.value--;
        emit('updateItems', cantidadItems.value);
    }
}

watch(() => props.initialItems, (nuevoValor) => {
    cantidadItems.value = nuevoValor;
});

</script>

<template>
<div class="flex gap-4 items-center my-4">
    <button type="button"
            class="px-4 py-2 text-white rounded bg-indigo-700 rounded-2xl"
            @click="agregarEquipo">
        ➕ Agregar {{ props.nombreDisplayed }}
    </button>
    <button type="button"
            class="px-4 py-2 bg-red-800 text-white rounded hover:bg-red-600 rounded-2xl"
            @click="quitarEquipo">
        ➖ Quitar {{ props.nombreDisplayed }}
    </button>
    <span class="ml-4 text-gray-700 dark:text-gray-300 text-lg">Cantidad de {{nombreDisplayed}}: {{ cantidadItems }}</span>
</div>
</template>
