<script setup>
import {computed, nextTick, onMounted, reactive} from 'vue';
import Modal from "@/Components/Modal.vue";
import {forEach} from "lodash";
import {useAmper} from "@/Pages/Oferta/tablastiempoyamperaje";
import {formatPesosCol} from "@/global";
import {useForm} from "@inertiajs/vue3";

const emit = defineEmits(['close', 'confirm'])

// <!--<editor-fold desc="propio de vue">-->
/**
 * @typedef {Object} DatosCobre
 * @property {number} valorbarraje
 * @property {number} dataccobre.valorlaminilla
 * @property {number} Aisladores
 * @property {number} Soporteangulo
 * @property {number} docslive
 * @property {number} hora_del_oficial_con_prestaciones
 */

const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
    dataccobre: {
        type: Object,
        required: true,
    },
    itemID: {
        type: Number,
        required: true,
    }
});

const mathround = 10000

// const props.dataccobre?.valorbarraje
// const props.dataccobre?.valorlaminilla
// const props.dataccobre?.Aisladores
// const props.dataccobre?.Soporteangulo
// const props.dataccobre?.docslive


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

    amperios: [482, 0, 0, 0, 0, 0, 0, 0, 0], // controla el v-for
    cantidades: [0, 0, 0, 0, 0, 0, 0, 0, 0],
    metros: [0, 0, 0, 0, 0, 0, 0, 0, 0],  // el resultado buscado
    pesos: [0, 0, 0, 0, 0, 0, 0, 0, 0],

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
        // 'ELECTROPLATEADO',
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
    Soporteangulo: [0, 0],

    //zoona 4
    cantidades4: [0],
    // factoresElectrogible: [[0.25, 0.25], [0.1, 0.5]],
    factoresElectrogible: [[0.25], [0.5]],
    valorElectrogible: [0], //solo quedo el termoencogible
    tiempoElectrogible: [0],

});

onMounted(() => {
    if (typeof (props.show) === 'undefined') {
        props.show = true;
    }
    // if (props.show) {
    nextTick()

    valorTiempoAisladores()
    if(props.dataccobre){
        
        const valor1 = props.dataccobre?.Soporteangulo[0] / 20 //todo: quitar esto de aqui
        const valor2 = (props.dataccobre?.Soporteangulo[1] / 6) * 1.2
        data.Soporteangulo = [valor1, valor2]
    }
    // }
}) //fin onMounted

// <!--</editor-fold>-->

const form = useForm({
    filas: [],
    item_id: props.itemID,
    subtotal: 0,
    abstotal: 0,
    itemID: props.itemID,
});

function guardarTodo() {
    form.filas = getFilasParaGuardar(data);
    form.subtotal = data.subtotal;
    form.abstotal = data.abstotal;

    form.post(route('oferta.guardarFilasCobre'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            // console.log('Todas las filas han sido guardadas exitosamente');
            closeModal();
        },
        onError: (errors) => {
            console.error('Error al guardar las filas:', errors);
            alert("Hubo un error al guardar la información.")
        }
    });
}

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
    MultiplyRound,
    getFilasParaGuardar
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


    // const canti40 = data.cantidades4[0]
    // data.valorElectrogible[0] = 0.25 * subtotal * canti40
    const canti41 = data.cantidades4[0]
    data.valorElectrogible[0] = 0.1 * subtotal * canti41

    // data.tiempoElectrogible[0] = 0.25 * subtotalTiempo * canti40
    data.tiempoElectrogible[0] = 0.5 * subtotalTiempo * canti41


    // data.abstotal = MultiplyRound((subtotal) + data.valorElectrogible[0] + data.valorElectrogible[1])
    const total1 = MultiplyRound((subtotal) + data.valorElectrogible[0])
    const total2 = MultiplyRound(subtotal)
    data.abstotal = total1
    data.subtotal = total2

    let tiempo1 = MultiplyRound((subtotalTiempo) + data.tiempoElectrogible[0])
    data.t_subtotl = MultiplyRound(subtotalTiempo)
    data.t_abstotl = tiempo1
    
    const temp1 = MultiplyRound((tiempo1 * props.dataccobre.docslive * props.dataccobre.hora_del_oficial_con_prestaciones))
    data.ValorProcesoManoObra = temp1
    // data.ValorProcesoManoObra = MultiplyRound(data.t_subtotl * props.docslive * props.hora_del_oficial_con_prestaciones)

}

const calculartotaleN = () => {
    for (let idx = 0; idx < data.textocolumna1.length; idx++) calculartotales1(idx, false)
    for (let idx = 0; idx < data.textocolumna2.length; idx++) calculartotales2(idx, false)
    for (let idx = 0; idx < data.textocolumna3.length; idx++) calculartotales3(idx, false)
}


// <!--<editor-fold desc="zona 1">-->
const calculartotales1 = (idx, llamarAbstotal = false) => {
    const cantimetros = data.cantidades[idx] * data.metros[idx]

    let valortotal = props.dataccobre?.valorbarraje
    if (data.textocolumna1.length - 1 === idx) valortotal = props.dataccobre?.valorlaminilla

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
    data.valortotal2[idx] = props.dataccobre?.Aisladores[idx] * data.cantidades2[idx];

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


    data.soportest450[idx] = (Math.round(props.dataccobre?.valorbarraje * data.pesototal3[idx] * mathround) / mathround)

    const parte2 = data.Soporteangulo[idx]

    const parte1 = data.soportest450[idx]
    data.valortotal3[idx] = data.cantidades3[idx] * (parte1 + parte2)
    valorTiempoAisladores()
    // data.tiempoprincipal3[idx] = getTiempo(data.amperios3[idx]) * cantimetros;
    calcularAbsTotales(3)
}


const handlecantidadesChange3 = (valor, idx) => {
    if (!esValido(valor)) return;

    if (esNegativo(valor)) {
        data.cantidades3[idx] = 0;
    }

    calculartotales3(idx);
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
// <!--</editor-fold>-->


setTimeout(() => { //todo: quitarrr 
    data.amperios = [482, 327, 0, 0, 0, 0, 0, 0, 0]
    data.cantidades = [1, 1, 0, 0, 0, 0, 0, 0, 0]
    data.cantidades2 = [1, 1]
    data.cantidades3 = [1, 1]
    data.cantidades4 = [1, 1]

    nextTick()

    handleAmperiosChange(482, 0)
    handleAmperiosChange(327, 1)

    handlecantidadesChange(1, 0)
    handlecantidadesChange(1, 1)
    handlecantidadesChange2(1, 0)
    handlecantidadesChange2(1, 1)
    handlecantidadesChange3(1, 0)
    handlecantidadesChange3(1, 1)
    handleCanti4(1, 0)
    handleCanti4(1, 1)
    console.log('Amperios ha cambiado. Espera medio segundo...');
}, 600);


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
                        <td
                            v-tooltip="'61600	KILO COBRE: ' + props.dataccobre?.valorbarraje+ ' x ' +data.pesototal3[index] +' = ' +data.soportest450[index]"
                            class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            <!--                            <input-->
                            <!--                                type="number"-->
                            <!--                                :value="data.metros3[index]"-->
                            <!--                                @input="handlemetrosChange3($event.target.value, index)"-->
                            <!--                                class="w-5/6 pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"-->
                            <!--                            /> mts-->
                            {{ props.dataccobre?.valorbarraje }}
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

                        <td
                            v-tooltip="data.Soporteangulo[index] +' + ' + data.soportest450[index]"
                            class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
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
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                            Factor electroplateado
                            <input disabled
                                   type="number"
                                   :value="data.factoresElectrogible[index][0]"
                                   class="bg-gray-400 text-white ml-2 pl-1 w-2/3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"
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
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            Valor Proceso Mano de Obra
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ formatPesosCol(data.ValorProcesoManoObra) }}
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
            <!--            <p>props.dataccobre?.valorbarraje: {{ props.dataccobre?.valorbarraje }}</p>-->
            <!--            <p>props.dataccobre?.valorlaminilla: {{ props.dataccobre?.valorlaminilla }}</p>-->
            <!--            <p>props.dataccobre?.Aisladores: {{ props.dataccobre?.Aisladores }}</p>-->
            <!--            <p>props.dataccobre?.Soporteangulo: {{ props.dataccobre?.Soporteangulo }}</p>-->

            <hr>
            <hr>
            <!--            <p>valor barraje: {{ props.dataccobre?.valorbarraje }}</p>-->
            <!--            <p>valor laminilla: {{ props.dataccobre?.dataccobre.valorlaminilla }}</p>-->
            <!--            <p>Aisladores: {{ props.dataccobre?.Aisladores }}</p>-->
            <!--            <p>Soporteangulo: {{ props.dataccobre?.Soporteangulo }}</p>-->
            <pre>Soporteangulo: {{ props.dataccobre }}</pre>

            
            
            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <button
                    class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300"
                    @click="emit('close')">
                    Cancelar
                </button>
                <!--                    bg-indigo-600 text-white hover:bg-indigo-700-->
                <button
                    class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                    @click="guardarTodo()">
                    Confirmar y Guardar
                </button>
            </div>
        </div>
    </Modal>
</template>
