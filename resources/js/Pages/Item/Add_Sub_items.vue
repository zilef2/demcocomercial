<script setup>
import {watch,ref} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
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
const cantidadItems = ref(props.initialItems ?? 0);
console.log('cantidadItems', cantidadItems.value);

function agregarItem() {
    cantidadItems.value++;
    emit('updateItems', cantidadItems.value);
}

function quitarItem() {
    if (cantidadItems.value > 1) {
        cantidadItems.value--;
        emit('updateItems', cantidadItems.value);
    }
}

watch(() => props.initialItems, (nuevoValor) => {
    cantidadItems.value = nuevoValor;
});
function imprimir() {
  window.print();
}
</script>

<template>
<div class="flex gap-4 items-center my-4">
    <button type="button"
            class="px-4 py-2 text-white bg-[#74bc1f] rounded-2xl"
            @click="agregarItem">
        ➕ Agregar {{ props.nombreDisplayed }}
    </button>
    <button type="button"
            class="px-4 py-2 bg-red-800 text-white hover:bg-red-600 rounded-2xl"
            @click="quitarItem">
        ➖ Quitar {{ props.nombreDisplayed }}
    </button>
    <span class="ml-4 text-gray-700 dark:text-[#74bc1f] text-lg">Cantidad de {{nombreDisplayed}}: {{ cantidadItems }}</span>
    <button type="button"
            class="px-4 py-2 bg-[#74bc1f] text-white hover:bg-[#74b1ff] rounded-2xl"
            @click="imprimir">
        Imprimir
    </button>
</div>
</template>
