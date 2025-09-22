<script setup>
import {onMounted, reactive, watch} from 'vue';
import Modal from "@/Components/Modal.vue";
import {forEach} from "lodash";

const emit = defineEmits(['close', 'confirm'])

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
});
const data = reactive({
    barrajePrincipalCobre: 482,
    barrajePrincipalCant: 3,
    barrajePrincipalMetros: 1.1,
    barrajePrincipalPesoUnd: 1.73,
    barrajePrincipalPesoTotal: 5.71,
    barrajePrincipalValor: 374054,
    barrajePrincipalTiempo: 2.39,


    laminillaCobre: 0,
    aisladoresMedianoCant: 4,
    aisladoresMedianoPesoTotal: 3.2,
    aisladoresMedianoValor: 31200,
    aisladoresMedianoTiempo: 0.5,
    aisladoresGrandeCant: 0,
    aisladoresGrandePesoTotal: 0,
    aisladoresGrandeValor: 0,
    aisladoresGrandeTiempo: 0,
    soporteAisladoresT40Valor: 0,
    soporteAisladoresT50Valor: 0,

    electroplateadoValor: 0,
    termoencogibleValor: 0,

    valorProcesoManoDeObra: 235495,
    subtotal: 461024,
    total: 461024,
    tiempoTotal: 3.20,

    textocolumna1: ['BARRAJE PRINCIPAL', 'BARRAJE NEUTRO', 'BARRAJE TIERRA','BARRAJE SECUNDARIO 1','BARRAJE SECUNDARIO 2','BARRAJE SECUNDARIO 3','BARRAJE SECUNDARIO 4','BARRAJE SECUNDARIO 5','LAMINILLA'],
    amperios: [482, 327, 327, 0], // lo que el usuario digita
    metros: [1.1, 0.4, 0.4, 0],  // el resultado buscado
});

onMounted(() => {
    if (typeof (props.show) === 'undefined') {
        props.show = true;

    }
}) //fin onMounted

console.log("🚀🚀 ~ show: ", props.show);
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

// const data = reactive({
//     entrada: null, // lo que el usuario digita
//     metros: null,  // el resultado buscado
// });


watch(() => data.amperios, (amperios) => {
    amperios.forEach((amp, idx) => {
        data.metros[idx] = getMts(amp)
    })
},{ deep: true});


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
    <Modal @close="closeModal" :show="show" :maxWidth="'xl8'">

        <div class="p-6 space-y-6">
            <header class="text-center">
                <h1 class="text-slate-800 text-2xl font-bold">
                    Calculo del <span class="text-indigo-600">Cobre</span>
                </h1>
                <!--                <p class="text-sm text-gray-500 mt-1">Digita un valor para ver su equivalente</p>-->
            </header>


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DESCRIPCION
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            COBRE (AMP)
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            CANT
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            METROS
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            PESO (UND)
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            PESO (TOTAL)
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            VALOR
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TIEM/HOR
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(amperrios,index) in data.amperios" :key="index">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ data.textocolumna1[index] }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                v-model="data.amperios[index]"
                                class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.barrajePrincipalCant }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                v-model="data.metros[index]"
                                class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.barrajePrincipalPesoUnd }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            {{ data.barrajePrincipalPesoTotal }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            ${{ data.barrajePrincipalValor.toLocaleString() }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.barrajePrincipalTiempo }}
                        </td>
                    </tr>
                    </tbody>
                </table>
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
