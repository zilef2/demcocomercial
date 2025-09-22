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

    textocolumna1: ['BARRAJE PRINCIPAL', 'BARRAJE NEUTRO', 'BARRAJE TIERRA', 'BARRAJE SECUNDARIO 1', 'BARRAJE SECUNDARIO 2', 'BARRAJE SECUNDARIO 3', 'BARRAJE SECUNDARIO 4', 'BARRAJE SECUNDARIO 5', 'LAMINILLA'],
    cantidades: [1, 1, 1, 1],
    amperios: [482, 327, 327, 0], // lo que el usuario digita
    metros: [1.1, 0.4, 0.4, 0],  // el resultado buscado
    pesos: [1.1, 0.4, 0.4, 0],
    pesototal: ["0", "0", "0", "0"],
});

onMounted(() => {
    if (typeof (props.show) === 'undefined') {
        props.show = true;
    }
}) //fin onMounted

console.log("🚀🚀 ~ show: ", props.show);
const tabla = [
    {min: 0, max: 161, peso: 0, mts: 0},
    {min: 162, max: 273, peso: 0.396, mts: 1.2},
    {min: 274, max: 326, peso: 0.84, mts: 1.4},
    {min: 327, max: 378, peso: 1.06, mts: 1.4},
    {min: 379, max: 481, peso: 1.29, mts: 1.4},
    {min: 482, max: 585, peso: 1.73, mts: 1.6},
    {min: 586, max: 671, peso: 1.68, mts: 1.6},
    {min: 672, max: 687, peso: 2.57, mts: 1.6},
    {min: 688, max: 693, peso: 2.62, mts: 1.6},
    {min: 694, max: 714, peso: 2.65, mts: 1.6},
    {min: 715, max: 794, peso: 3.37, mts: 1.6},
    {min: 795, max: 835, peso: 3.19, mts: 1.6},
    {min: 836, max: 884, peso: 3.46, mts: 1.6},
    {min: 885, max: 993, peso: 3.51, mts: 1.6},
    {min: 994, max: 1079, peso: 4.35, mts: 1.8},
    {min: 1080, max: 1149, peso: 4.4, mts: 1.8},
    {min: 1150, max: 1259, peso: 5.24, mts: 1.8},
    {min: 1260, max: 1449, peso: 6.53, mts: 1.8},
    {min: 1450, max: 1729, peso: 7.02, mts: 2.0},
    {min: 1730, max: 2049, peso: 8.79, mts: 2.2},
    {min: 2050, max: 2479, peso: 13.19, mts: 2.2},
    {min: 2480, max: 2719, peso: 17.4, mts: 2.2},
    {min: 2720, max: 3189, peso: 14.03, mts: 2.4},
    {min: 3190, max: 3259, peso: 17.59, mts: 2.4},
    {min: 3260, max: 3979, peso: 26.1, mts: 2.4},
    {min: 3980, max: 4499, peso: 34.8, mts: 2.4},
    {min: 4500, max: 5529, peso: 41.91, mts: 2.6},
    {min: 5530, max: 6539, peso: 56.13, mts: 2.8},
    {min: 6540, max: Infinity, peso: 70.36, mts: 2.8}
];

const getMts = (valor) => {
    const rango = tabla.find(r => valor >= r.min && valor <= r.max)
    return rango ? [rango.mts, rango.peso] : [0, 0]
}

const handleAmperiosChange = (valor, idx) => {
    // Actualiza primero el valor en el array reactivo
    data.amperios[idx] = Number(valor);

    // Luego, realiza los cálculos con el valor recién actualizado
    const amp = data.amperios[idx];
    
    [data.metros[idx], data.pesos[idx]] = getMts(amp);
    data.pesototal[idx] = (data.pesos[idx] * data.cantidades[idx]).toFixed(2);
};

const handlecantidadesChange = (valor, idx) => {
    data.cantidades[idx] = Number(valor);
    const canti = data.cantidades[idx];
    
    data.pesototal[idx] = (data.pesos[idx] * canti).toFixed(2);
};


setTimeout(() => {
    data.amperios[0] = 5350;
    console.log('Amperios cambiados a 5350. Espera un segundo...');
}, 1800);

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
                                :value="data.amperios[index]"
                                @input="handleAmperiosChange($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                :value="data.cantidades[index]"
                                @input="handlecantidadesChange($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                v-model="data.metros[index]" 
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            /> mts
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                v-model="data.pesos[index]"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            /> kg
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            {{ data.pesototal[index] }} kg
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
