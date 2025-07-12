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
<div class="flex gap-4 items-center my-4 mx-auto no-print w-max">
    <button type="button"
            class="p-2 text-white bg-indigo-600 rounded-md border-white border-2 hover:bg-[#74bc1f]"
            @click="agregarItem">
        ➕ Agregar {{ props.nombreDisplayed }}
    </button>
    <button type="button"
            class="p-2 text-white bg-red-600 rounded-md border-white border-2 hover:bg-[#74bc1f]"
            @click="quitarItem">
        ➖ Quitar {{ props.nombreDisplayed }}
    </button>
    <span class="ml-4 text-black dark:text-[#74bc1f] text-xl font-bold">Cantidad de {{nombreDisplayed}}: {{ cantidadItems }}</span>
<!--    <button type="button"-->
<!--            class="px-4 py-2 bg-black border border-white border-2 hover:bg-[#74bc1f] text-white hover:bg-[#74b1ff] rounded-2xl"-->
<!--            @click="imprimir">-->
<!--        Imprimir-->
<!--    </button>-->
</div>
</template>
