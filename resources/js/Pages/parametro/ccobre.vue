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

const mathround = 10000

const propsvalorbarraje = 65520 //sacar el valor de la bd (codigo de equipo: 61600)
const propsvalorlaminilla = 75488 //sacar el valor de la bd, para LAMINILLA (codigo de equipo: 61663)
const propsAisladores = [7800, 16300] //codigo de equipo: 61003) , codigo de equipo: 61004)
// const propsSoporteangulo = [172805, 93590.7] //T40 y T50 -- codigo de equipo: 61511) , codigo de equipo: 61566) div20 y el otro  *1.2
const propsSoporteangulo = [180000, 79966] //T40 y T50 -- codigo de equipo: 61511) , codigo de equipo: 61566) div20 y el otro  *1.2
// const propsSoporteangulo = [8640.25, 18718.14]


//a

const consSOPORTET40 = 1.45
const consSOPORTET50 = 1.5
const consAISLADORES = 0.08


const data = reactive({
    subtotal: 0,
    abstotal: 0,
    t_subtotl: 0,
    t_abstotl: 0,
    ValorProcesoManoObra: 0,

    textocolumna1: ['BARRAJE PRINCIPAL', 'BARRAJE NEUTRO', 'BARRAJE TIERRA', 'BARRAJE SECUNDARIO 1',
        'BARRAJE SECUNDARIO 2', 'BARRAJE SECUNDARIO 3', 'BARRAJE SECUNDARIO 4', 'BARRAJE SECUNDARIO 5',
        'LAMINILLA',
    ],

    amperios: [482, 327, 327, 0, 0, 0, 0, 0, 0], // controla el v-for
    cantidades: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    metros: [1.1, 0.4, 0.4, 0, 0, 0, 0, 0, 0],  // el resultado buscado
    pesos: [1.1, 0.4, 0.4, 0, 0, 0, 0, 0, 0],

    pesototal: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    valortotal: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    tiempoprincipal: [0, 0, 0, 0, 0, 0, 0, 0, 0],


    textocolumna2: [
        ' AISLADORES MEDIANO T40',
        ' AISLADORES GRANDE T50',
    ],
    textocolumna3: [
        ' SOPORTE AISLADORES T40',
        ' SOPORTE AISLADORES T50',
    ],
    textocolumna4: [
        'ELECTROPLATEADO',
        'TERMOENCOGIBLE',
    ],
    textocolumna2_descrip: [
        'HASTA 584A',
        'DESDE 3190A',
    ],
    textocolumna3_descrip: [
        'HASTA 584A',
        'DESDE 3190A',
    ],

    //zoona 2
    cantidades2: [0, 0],
    valortotal2: [0, 0],
    tiempoprincipal2: [0, 0],

    //zoona 3
    amperios3: [274, 583],
    cantidades3: [0, 0],
    metros3: [0.07, 0.17],
    pesos3: [0, 0],
    pesototal3: [0, 0],
    valortotal3: [0, 0],
    tiempoprincipal3: [0, 0],
    soportest450: [0, 0], // acesorios 2.1025 2.175 0.116

    //no zoona
    factorMultiplicadoCG: 1.45,
    dAISLADORES: 0,
    dSOPORTET40: 0,
    dSOPORTET50: 0,
    propsSoporteangulo: [0, 0],

    //zoona 4
    cantidades4: [0, 0],
    factoresElectrogible: [[0.25, 0.25], [0.1, 0.5]],
    valorElectrogible: [0, 0],
    tiempoElectrogible: [0, 0],

});

onMounted(() => {
    if (typeof (props.show) === 'undefined') {
        props.show = true;
    }
    if (props.show) {
        valorTiempoAisladores()
        const valor1 = propsSoporteangulo[0] / 20
        const valor2 = (propsSoporteangulo[1] / 6) * 1.2

        data.propsSoporteangulo = [valor1, valor2]
    }
}) //fin onMounted

// <!--</editor-fold>-->


function makeFormatted(key, formatter) {
    return computed(() => data[key].map(formatter));
}

function makeFormattedSimple(key, formatter) {
    return computed(() => formatter(data[key]));
}

const formattedValortotal = makeFormatted("valortotal", formatPesosCol);
const formattedValortotal2 = makeFormatted("valortotal2", formatPesosCol);
const formattedValortotal3 = makeFormatted("valortotal3", formatPesosCol);
const formatsubtotal = makeFormattedSimple("subtotal", formatPesosCol);
const formatabstotal = makeFormattedSimple("abstotal", formatPesosCol);

const timeFormatter = (val) => (Math.round(val * 10000) / 10000).toFixed(3);

const formattedtiempoPrincipal = makeFormatted("tiempoprincipal", timeFormatter);
const formattedtiempoPrincipal2 = makeFormatted("tiempoprincipal2", timeFormatter);
const formattedtiempoPrincipal3 = makeFormatted("tiempoprincipal3", timeFormatter);


const {
    getMts,
    getTiempo,
    esValido,
    esNegativo,
    MultiplyRound
} = useAmper()


const calcularAbsTotales = (fuente = 0) => {

    let subtotal = 0
    let subtotalTiempo = 0


    if (!fuente) calculartotaleN()

    forEach(data.valortotal, (valor, indi) => {
        subtotal += valor
        subtotalTiempo += data.tiempoprincipal[indi]
    });
    forEach(data.valortotal2, (valor, indi) => {
        subtotal += valor
        subtotalTiempo += data.tiempoprincipal2[indi]
    });
    forEach(data.valortotal3, (valor, indi) => {
        subtotal += valor
        subtotalTiempo += data.tiempoprincipal3[indi]
    });


    const canti40 = data.cantidades4[0]
    const canti41 = data.cantidades4[1]
    data.valorElectrogible[0] = 0.25 * subtotal * canti40
    data.valorElectrogible[1] = 0.1 * subtotal * canti41

    data.tiempoElectrogible[0] = 0.25 * subtotalTiempo * canti40
    data.tiempoElectrogible[1] = 0.5 * subtotalTiempo * canti41


    data.abstotal = MultiplyRound((subtotal) + data.valorElectrogible[0] + data.valorElectrogible[1])
    data.subtotal = MultiplyRound(subtotal)

    data.t_abstotl = MultiplyRound((subtotalTiempo) + data.tiempoElectrogible[0] + data.tiempoElectrogible[1])
    data.t_subtotl = MultiplyRound(subtotalTiempo)
}

const calculartotaleN = () => {
    for (let idx = 0; idx < data.textocolumna1.length; idx++) calculartotales1(idx, false)
    for (let idx = 0; idx < data.textocolumna2.length; idx++) calculartotales2(idx, false)
    for (let idx = 0; idx < data.textocolumna3.length; idx++) calculartotales3(idx, false)
}

// <!--<editor-fold desc="zona 1">-->
const calculartotales1 = (idx, llamarAbstotal = false) => {
    const cantimetros = data.cantidades[idx] * data.metros[idx]

    let valortotal = propsvalorbarraje
    if (data.textocolumna1.length - 1 === idx) valortotal = propsvalorlaminilla

    data.pesototal[idx] = Math.round(data.pesos[idx] * cantimetros * mathround) / mathround

    data.valortotal[idx] = Math.round(valortotal * data.pesototal[idx] * mathround) / mathround
    data.tiempoprincipal[idx] = getTiempo(data.amperios[idx]) * cantimetros;

    // if(llamarAbstotal) 
    calcularAbsTotales(1)
}


const handleAmperiosChange = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.amperios[idx] = 0;
        return;
    }

    data.amperios[idx] = Number(valor);
    [data.metros[idx], data.pesos[idx]] = getMts(data.amperios[idx]);


    calculartotales1(idx)
};

const handlecantidadesChange = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.cantidades[idx] = 0;
        return;
    }

    data.cantidades[idx] = Number(valor);

    calculartotales1(idx)

};

const handlemetrosChange = (valor, idx, ispesos = '') => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.metros[idx] = 0;
        return;
    }

    if (ispesos === 'ispesos') {
        data.pesos[idx] = Number(valor);
    } else {
        data.metros[idx] = Number(valor);
        data.pesos[idx] = getMts(data.amperios[idx])[1];
    }

    calculartotales1(idx)
};
// <!--</editor-fold>-->


// <!--<editor-fold desc="zona 2">-->
const calculartotales2 = (idx) => {

    data.tiempoprincipal2[idx] = data.dAISLADORES * data.cantidades2[idx]
    data.valortotal2[idx] = propsAisladores[idx] * data.cantidades2[idx];

    calcularAbsTotales(2)
}

const handlecantidadesChange2 = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.cantidades2[idx] = 0;
        return;
    }

    data.cantidades2[idx] = Number(valor);

    calculartotales2(idx)
};

// <!--</editor-fold>-->


// <!--<editor-fold desc="zona 3">-->
const valorTiempoAisladores = () => {
    if (!data.factorMultiplicadoCG && !data.cantidades3[0] && !data.cantidades3[1]) return

    data.dSOPORTET40 = data.factorMultiplicadoCG * consSOPORTET40
    data.dSOPORTET50 = data.factorMultiplicadoCG * consSOPORTET50

    data.tiempoprincipal3[0] = data.dSOPORTET40 * (data.cantidades3[0] ?? 0)
    data.tiempoprincipal3[1] = data.dSOPORTET50 * (data.cantidades3[1] ?? 0)

    data.dAISLADORES = MultiplyRound(data.factorMultiplicadoCG, consAISLADORES)
}

const calculartotales3 = (idx, llamarAbstotal = false) => {
    const cantimetros = data.metros3[idx]
    data.pesos3[idx] = getMts(data.amperios3[idx])[1];

    if (!cantimetros) return

    const achu = data.pesos3[idx]
    data.pesototal3[idx] = Math.round(data.pesos3[idx] * cantimetros * mathround) / mathround


    data.soportest450[idx] = (Math.round(propsvalorbarraje * data.pesototal3[idx] * mathround) / mathround)

    const parte2 = data.propsSoporteangulo[idx]

    const parte1 = data.soportest450[idx]
    data.valortotal3[idx] = data.cantidades3[idx] * (parte1 + parte2)
    valorTiempoAisladores()
    // data.tiempoprincipal3[idx] = getTiempo(data.amperios3[idx]) * cantimetros;
    calcularAbsTotales(3)
}

const handleAmperiosChange3 = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.amperios3[idx] = 0;
        return;
    }

    data.amperios3[idx] = Number(valor);
    [data.metros3[idx], data.pesos3[idx]] = getMts(data.amperios3[idx]);


    calculartotales3(idx)
};

const handlecantidadesChange3 = (valor, idx) => {
  if (!esValido(valor)) return;

  if (esNegativo(valor)) {
    data.cantidades3[idx] = 0;
  }

  calculartotales3(idx);
};

const handlemetrosChange3 = (valor, idx, ispesos = '') => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.metros3[idx] = 0;
        return;
    }


    data.metros3[idx] = Number(valor);
    data.pesos3[idx] = getMts(data.amperios3[idx])[1];

    calculartotales3(idx)
};

// <!--</editor-fold>-->


// <!--<editor-fold desc="zona 4">-->

const handleCanti4 = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.cantidades4[idx] = 0;
        return;
    }


    data.cantidades4[idx] = Number(valor);

    calcularAbsTotales()
};
const handleFactoresET = (valor, idx) => {
    if (!esValido(valor)) return
    if (esNegativo(valor)) {
        data.factoresElectrogible[idx] = 0; //que???
        return;
    }
    data.factoresElectrogible[idx] = Number(valor);

    calcularAbsTotales()
};
// <!--</editor-fold>-->


setTimeout(() => { //quitarrr 
    data.amperios = [482, 327, 327, 0, 0, 0, 0, 0, 0],
    data.cantidades = [1,1,1,0,0,0,0,0,0],
    data.cantidades2 = [1,1],
    data.cantidades3 = [1,1],
    data.cantidades4 = [1,1],
        
    handlecantidadesChange(1,0)
    handlecantidadesChange(1,1)
    handlecantidadesChange2(1,0)
    handlecantidadesChange2(1,1)
    handlecantidadesChange3(1,0)
    handlecantidadesChange3(1,1)
    handleCanti4(1,0)
    handleCanti4(1,1)
    console.log('Amperios ha cambiado. Espera un segundo...');
}, 800);


const confirmFunction = () => {
    const result = parseFloat(data.metros);
    if (!isNaN(result) && result >= 0) {
        emit('confirm', result);
        closeModal();
    } else alert("Por favor, introduce un número válido para el factor.");
};

const closeModal = () => emit('close')
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
<!--            <div class="text-center">-->
<!--                <p class="text-sm text-gray-500 mt-1">FACTOR MULTIPLICADOR SOLICITADO POR COMITÉ DE GERENCIA</p>-->
<!--                <input-->
<!--                    type="number"-->
<!--                    :value="data.factorMultiplicadoCG"-->
<!--                    @input="handleFMChange($event.target.value)"-->
<!--                    class="w-1/12 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"-->
<!--                />-->
<!--            </div>-->


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
                            AMPERIOS
                        </th>
                        <th scope="col"
                            class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            CANTITDAD
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
                            TIEMPO/HORA
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(texto,index) in data.textocolumna1" :key="index">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ texto }}
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
                    <tr v-for="(texto,index) in data.textocolumna2" :key="index">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ texto }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ data.textocolumna2_descrip[index] }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                :value="data.cantidades2[index]"
                                @input="handlecantidadesChange2($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.dAISLADORES }} <small> HORAS/ACCESORIOS </small>


                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            -
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ formattedValortotal2[index] }}
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ formattedtiempoPrincipal2[index] }}
                        </td>
                    </tr>
                    <tr v-for="(texto,index) in data.textocolumna3" :key="index">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ texto }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm ">
                            <!--                            <input-->
                            <!--                                type="number"-->
                            <!--                                :value="data.amperios3[index]"-->
                            <!--                                @input="handleAmperiosChange3($event.target.value, index)"-->
                            <!--                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"-->
                            <!--                            />-->
                            <p>{{ data.textocolumna3_descrip[index] }}</p>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                v-model.number="data.cantidades3[index]"
                                @input="handlecantidadesChange3($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <!--                            <input-->
                            <!--                                type="number"-->
                            <!--                                :value="data.metros3[index]"-->
                            <!--                                @input="handlemetrosChange3($event.target.value, index)"-->
                            <!--                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"-->
                            <!--                            /> mts-->
                            {{ propsvalorbarraje }} x {{ data.pesototal3[index] }} = {{ data.soportest450[index] }}
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
                            {{ data.pesos3[index] }} kg
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">
                            {{ data.pesototal3[index] }} kg
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <small class="text-xs">
                                {{ data.propsSoporteangulo[index] }} +
                                {{ data.soportest450[index] }}
                            </small>
                            <p>{{ formattedValortotal3[index] }}</p>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <!--                            <small>{{ index === 1 ? data.dSOPORTET50 : data.dSOPORTET40 }}</small>-->
                            <p>{{ formattedtiempoPrincipal3[index] }}</p>
                        </td>
                    </tr>
                    <tr v-for="(texto,index) in data.textocolumna4" :key="index">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ texto }}
                            | Factores
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input disabled
                                   type="number"
                                   :value="data.factoresElectrogible[index][0]"
                                   @input="handleFactoresET($event.target.value, index)"
                                   class="bg-gray-400 text-white ml-2 pl-1 w-1/3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                            <input disabled
                                   type="number"
                                   :value="data.factoresElectrogible[index][1]"
                                   @input="handleFactoresET($event.target.value, index)"
                                   class="bg-gray-400 text-white ml-2 pl-1 w-1/3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <input
                                type="number"
                                :value="data.cantidades4[index]"
                                @input="handleCanti4($event.target.value, index)"
                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
                            />
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 ">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 bg-yellow-100">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ formatPesosCol(data.valorElectrogible[index]) }}
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.tiempoElectrogible[index] }}
                        </td>
                    </tr>


                    <!--                    totales-->
                    <tr>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            Subtotal
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <b>{{ formatsubtotal }}</b>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.t_subtotl }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            Total
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">-</td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">Valor Proceso Mano de
                            Obra
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ data.ValorProcesoManoObra }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <b>{{ formatabstotal }}</b>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ data.t_abstotl }}
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
                <!--                    bg-indigo-600 text-white hover:bg-indigo-700-->
                <button
                    class="px-4 py-2 rounded-md 
                    bg-gray-400
"
                    @click="confirmFunction()">
                    <!--                    Confirmar-->
                    Solo estamos probrando
                </button>
            </div>
        </div>
    </Modal>
</template>
