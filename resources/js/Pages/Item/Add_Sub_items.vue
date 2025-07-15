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
            class="inline-block p-2 text-white bg-indigo-600 rounded-md border-white border-2 hover:bg-[#74bc1f]"
            @click="agregarItem">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-4 mx-auto">
             <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
             />
         </svg>
        Agregar {{ props.nombreDisplayed }}
    </button>
    <button type="button"
            class="p-2 text-white bg-red-600 rounded-md border-white border-2 hover:bg-[#74bc1f]"
            @click="quitarItem">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="size-4 mx-auto">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
            />
        </svg>
         Quitar {{ props.nombreDisplayed }}
    </button>
</div>
<div class="flex gap-4 items-center my-4 mx-auto no-print w-max">
    <span class="ml-4 text-black dark:text-[#74bc1f] text-2xl font-bold">Cantidad de {{nombreDisplayed}}: {{ cantidadItems }}</span>
<!--    <button type="button"-->
<!--            class="px-4 py-2 bg-black border border-white border-2 hover:bg-[#74bc1f] text-white hover:bg-[#74b1ff] rounded-2xl"-->
<!--            @click="imprimir">-->
<!--        Imprimir-->
<!--    </button>-->
</div>
</template>
