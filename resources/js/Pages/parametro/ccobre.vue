<script setup>
import {reactive, watch} from 'vue';
import Modal from "@/Components/Modal.vue";

const emit = defineEmits(['close', 'confirm'])

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
const tabla = [
    {min: 0, max: 273, mts: 1.2},
    {min: 274, max: 582, mts: 1.4},
    {min: 583, max: 993, mts: 1.6},
    {min: 994, max: 1449, mts: 1.8},
    {min: 1450, max: 1729, mts: 1.8},
    {min: 1730, max: 2049, mts: 2.0},
    {min: 2050, max: 3189, mts: 2.2},
    {min: 3190, max: 4499, mts: 2.4},
    {min: 4500, max: 5529, mts: 2.4},
    {min: 5530, max: 6539, mts: 2.6},
    {min: 6540, max: Infinity, mts: 2.8}
]

const getMts = (valor) => {
    const rango = tabla.find(r => valor >= r.min && valor <= r.max)
    return rango ? rango.mts : 0
}

const data = reactive({
    entrada: null, // lo que el usuario digita
    metros: null,  // el resultado buscado
});

// Buscar automáticamente cada vez que cambia la entrada
watch(() => data.entrada, (nuevo) => {
    data.metros = getMts(nuevo)
});

const confirmFunction = () => {
    const result = parseFloat(data.metros);
    if (!isNaN(result) && result >= 0) {
        emit('confirm', result);
        closeModal();
    } else {
        alert("Por favor, introduce un número válido para el factor.");
    }
};

const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Modal @close="closeModal" :show="show" :maxWidth="'md'">

        <div class="p-6 space-y-6">
            <header class="text-center">
                <h1 class="text-slate-800 text-2xl font-bold">
                    Conversión <span class="text-indigo-600">Metros</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Digita un valor para ver su equivalente</p>
            </header>

            <!-- Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Capacidad (amperios)
                </label>
                <input
                    type="number"
                    v-model="data.entrada"
                    class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                />
            </div>

            <!-- Resultado -->
            <div v-if="data.metros !== null" class="text-center">
                <p class="text-gray-600">CANTIDAD DE COBRE EN LA INTERCONEXION (SIN TC´S):</p>
                <p class="mt-2 text-3xl font-bold text-indigo-600">
                    {{ data.metros.toFixed(1) }} MTS
                </p>
            </div>
            <div v-else class="text-center text-gray-400 text-sm">
                No encontrado en la tabla
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <button
                    class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
                    @click="emit('close')">
                    Cancelar
                </button>
                <button
                    class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                    @click="confirmFunction()">
                    Confirmar
                </button>
            </div>
        </div>
    </Modal>
</template>
