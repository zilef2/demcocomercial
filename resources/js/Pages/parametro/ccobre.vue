<script setup>
import {computed, onMounted, reactive, watch} from 'vue';
import Modal from "@/Components/Modal.vue";
import {forEach} from "lodash";
import {useAmper} from "@/Pages/Oferta/tablastiempoyamperaje";
import {formatPesosCol} from "@/global";

const emit = defineEmits(['close', 'confirm'])

// <!--<editor-fold desc="propio de vue">-->
const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
});
const data = reactive({

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
    valortotal: ["0", "0", "0", "0"],
    tiempoprincipal: [0, 0, 0, 0],
});

onMounted(() => {
    if (typeof (props.show) === 'undefined') {
        props.show = true;
    }
}) //fin onMounted

const formattedValortotal = computed(() => {
  return data.valortotal.map(val => formatPesosCol(val));
});
const formattedtiempoPrincipal = computed(() => {
  return data.tiempoprincipal.map(val => (Math.round(val * 10000) / 10000).toFixed(3))
});
// <!--</editor-fold>-->


const {
    getMts,
    getTiempo,
} = useAmper()

const valorbarraje = 65520 //sacar el valor de la bd (codigo 61600)

const esValido = (valor) => valor && !isNaN(valor) && valor >= 0;


const calculartotales = (idx) => {
    const cantimetros = data.cantidades[idx] * data.metros[idx]

    data.pesototal[idx] = (data.pesos[idx] * cantimetros).toFixed(3);
    data.valortotal[idx] = (valorbarraje * data.pesototal[idx]).toFixed(3);
    data.tiempoprincipal[idx] = getTiempo(data.amperios[idx]) * cantimetros;
}
const handleAmperiosChange = (valor, idx) => {
    if (!esValido(valor)) return

    data.amperios[idx] = Number(valor);
    console.log("🚀🚀handleAmperiosChange ~ data.amperios[idx]: ", data.amperios[idx]);
    [data.metros[idx], data.pesos[idx]] = getMts(data.amperios[idx]);


    calculartotales(idx)

};

const handlecantidadesChange = (valor, idx) => {
    if (!esValido(valor)) return

    data.cantidades[idx] = Number(valor);

    calculartotales(idx)

};

const handlemetrosChange = (valor, idx, ispesos = '') => {
    if (!esValido(valor)) return

    if (ispesos === 'ispesos') {
        data.pesos[idx] = Number(valor);
    } else {
        data.metros[idx] = Number(valor);
        data.pesos[idx] = getMts(data.amperios[idx])[1];
    }

    calculartotales(idx)
};


// setTimeout(() => { //quitarrr 
//     data.amperios[0] = 5350;
//     console.log('Amperios cambiados a 5350. Espera un segundo...');
// }, 2800);

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
                                :value="data.metros[index]"
                                @input="handlemetrosChange($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            /> mts
                        </td>
<!--                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">-->
<!--                            <input-->
<!--                                type="number"-->
<!--                                :value="data.pesos[index]"-->
<!--                                @input="handlemetrosChange($event.target.value, index,'ispesos')"-->
<!--                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"-->
<!--                            /> kg-->
<!--                        </td>-->

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            {{ data.pesos[index] }} kg
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            {{ data.pesototal[index] }} kg
                        </td>


                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ formattedValortotal[index] }}
                        </td>
                        
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ formattedtiempoPrincipal[index] }}
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
