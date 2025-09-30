<template>
    <div v-if="props.mostrarDetalles"
         class=" text-center mx-auto mt-6 mb-2 relative drop-shadow-xl min-w-[180px] h-12 overflow-hidden rounded-xl bg-gray-800">
        <div :id="'itemN' + props.indexItem"
             class="absolute flex items-center justify-center text-white z-[1] rounded-xl inset-0.5 bg-gray-800 py-1">
            <p class="text-center text-lg mx-2 w-32">Item {{ indexItem + 1 }}</p>
            <input
                type="text"
                v-model="data.daitem.nombre"
                class="max-w-[880px] min-w-[480px] text-center py-0 border-transparent
                 dark:bg-gray-900 bg-gray-800 dark:text-gray-300
                 rounded-md mt-1 block w-full text-xl"
                :class="{'border-red-500 border-2': data.daitem.nombre == '' || data.daitem.nombre == null}"
            />
            <button @click.prevent="copyitem"
                    type="button" @keydown.enter.prevent="false"
                    class="ml-4 bg-gray-900 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                Copiar
            </button>
            <button @click.prevent="deleteAndOk"
                    type="button" @keydown.enter.prevent="false"
                    class="ml-4 bg-gray-900 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                ¡Eliminar!
            </button>
        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>

    <div class="p-4 mb-6 grid-cols-2 gap-4 overflow-x-auto xs:min-w-[500px] md:min-w-[1500px] 2xl:min-w-[1800px]
     bg-gray-50 dark:bg-gray-900
     border-x-[2px] border-gray-300 dark:border-indigo-700 rounded-xl
     hover:shadow-indigo-300/50 dark:hover:shadow-indigo-700/50
     transition-all duration-300 ease-in-out"
         @focusin="focusStore.setFocusedItem(props.indexItem)"
         @focusout="focusStore.clearFocusedItem()">

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>


        <table class="divide-y-1 divide-gray-200 w-full">
            <thead class="ltr:text-left rtl:text-right">
            <tr class="*:font-medium dark:text-gray-900 bg-gray-900 text-white shadow-md rounded-xl"
                v-html="tableheaders"></tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr v-for="(equipo, index) in data.equipos" :key="equipo.idd"
                :class="{ 'bg-gray-200 dark:bg-gray-700': index % 2 !== 0 }">
                <template v-if="equipo.tipoFila === 'modelo1'">
                    <!-- Campo editable para definir posición -->
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <button @click="alternarTipoFila(equipo)"
                                type="button"
                                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
                            ♻️
                        </button>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <input type="text"
                               :value="equipo.orden"
                               class="w-14 border rounded text-center"
                               @keyup.enter="moverYReindexar(equipo, $event.target.value)"
                               @blur="verificarIndices(equipo, $event)"
                        >
                    </td>
                    <!-- codigo -->
                    <td class="p-2 whitespace-nowrap min-w-[10px] max-w-[50px] text-center">
                        <p class="mx-auto">{{ data.equipos[index]?.equipo_selec?.value ?? '' }}</p>
                    </td>
                    <td class="p-2 whitespace-nowrap mx-auto text-center min-w-[100px] max-w-[650px] dark:text-white">
                        <!--                 descripcion-->
                        <vSelect
                            v-model="data.equipos[index].equipo_selec"
                            :options="data.equiposOptions"
                            label="title"
                            :filterable="false"
                            append-to-body
                            placeholder="Buscar equipo..."
                            class="print:hidden mt-1 block w-full min-w-[250px] fixed zilefvs"
                            @search="(q) => { data.searchEquipo = q; buscarEquipos(q) }"
                            @update:modelValue="handleEquipoChange(index, $event)"
                        />

                        <div class="hidden print:block text-sm w-full">
                            {{ data.equipos[index]?.equipo_selec?.title ?? 'Sin selección' }}
                        </div>
                    </td>
                    <!-- fin descripcion-->
                    <!-- cantidad-->
                    <td class="mx-auto px-0 py-2 whitespace-nowrap text-center">
                        <input
                            type="number" min=0
                            :value="data.equipos[index].cantidad"
                            @input="event => data.equipos[index].cantidad = Math.max(0, event.target.valueAsNumber || 0)"
                            :class="clasetablaCantidad + clasetablaCantidad2"
                        />
                    </td>
                    <!-- fin cantidad-->
                    
                    <!-- tipo_fabricante-->
                    <td class="mx-2 py-2 whitespace-nowrap text-center">
                        <input v-if="data.equipos[index]?.equipo_selec"
                            type="text" disabled
                            :value="data.equipos[index]?.equipo_selec.tipo_fabricante"
                            :class="clasetablatresDatos"
                        /> <p v-else>...</p>
                    </td>
                    <!-- fin tipo_fabricante-->
                    <!-- referencia_fabricante-->
                    <td class="mx-2 py-2 whitespace-nowrap text-center">
                        <input v-if="data.equipos[index] && data.equipos[index].equipo_selec"
                            type="text" disabled
                            :value="data.equipos[index].equipo_selec.referencia_fabricante"
                            :class="clasetablatresDatos + 'w-72'"
                        /> <p v-else>...</p>
                    </td>
                    <!-- fin referencia_fabricante-->
                    <!-- marca-->
                    <td class="mx-2 py-2 whitespace-nowrap text-center">
                        <input v-if="data.equipos[index]?.equipo_selec"
                            type="text" disabled
                            :value="data.equipos[index]?.equipo_selec.marca"
                            :class="clasetablatresDatos"
                        /> <p v-else>...</p>
                    </td>
                    <!-- fin marca-->


                    <!-- precio de lista -->
                    <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0"
                        class="px-1 py-2 whitespace-nowrap mx-auto text-center">
                        <p class="w-full dark:text-white ">
                            {{
                                data.equipos[index]?.equipo_selec ?
                                    number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
                            }}
                            <Button type="button"
                                    v-if="data.equipos[index] && data.equipos[index].equipo_selec"
                                    @click="data.equipos[index].equipo_selec.precio_de_lista2 = 0"
                                    class="items-center py-2 bg-green-700 text-center
                                     border rounded-lg border-green-800 text-white
                                     hover:bg-green-500
                                      cursor-pointer h-8 w-8 ml-2"
                                    v-tooltip="'Editar'"
                            >
                                <PencilIcon class="w-4 mx-auto"/>
                            </Button>
                        </p>
                    </td>
                    <!--  si no hay precio en la BD-->
                    <td v-else-if="data.equipos[index]?.equipo_selec"
                        class="py-2 whitespace-nowrap mx-auto text-center ">
                        <input
                            type="text"
                            :value="formatPesosCol(data.equipos[index].equipo_selec.precio_de_lista)"
                            @input="onInputPrecio($event, index,data)"
                            class="max-w-[140px] border-gray-50/75 dark:border-gray-700 dark:bg-gray-900
                         dark:text-gray-300 rounded-md mt-1 block w-full 
                         bg-gradient-to-r from-yellow-400 to-orange-400"
                        />
                        <div class="hidden print:block text-sm">
                            {{ data.equipos[index]?.equipo_selec?.precio_de_lista }}
                        </div>
                        <div v-if="data.equipos[index]?.equipo_selec?.precio_de_lista == 0"
                             :id="'valor-nulo' + indexItem + '_' + index"
                             class="bg-red-600 mx-1 mt-2 max-w-[150px] rounded-lg">
                            Valor nulo!
                        </div>
                    </td>
                    <!-- fin precio de lista-->


                    <!--  show both discounts -->
                    <td class="table-cell text-xs md:text-md px-3 py-2 whitespace-nowrap mx-auto text-center">
                        <p v-if="data.equipos[index].equipo_selec"
                           class="max-w-[150px] border-gray-50/75 text-sm 
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block 
                            w-full border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
                        >
                            Basico: {{ truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_basico * 100) }} %<br>
                            Proyectos: {{ truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_proyectos * 100) }} %<br>
                        </p>
                    </td>
                    <!--                    descuento mayor -->
                    <td class="p-2 whitespace-nowrap align-middle">
                        <div :class="'flex items-center justify-start h-full' + clasetablaPorcentajes2">
                            <input
                                type="number"
                                min="0"
                                :value="getPorcentaje(data.equipos[index])"
                                @input="event => setPorcentaje(data.equipos[index], event.target.valueAsNumber)"
                                class="w-24 border rounded-md"
                            /> <span class="mx-2 w-1/6 "> %</span>
                        </div>
                    </td>

                    <!--  costo -->
                    <td class="px-3 py-2 whitespace-nowrap">
                        <p v-if="data.equipos[index].equipo_selec">{{
                                number_format(data.equipos[index].costounitario, 0, 1)
                            }}</p>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <p v-if="data.equipos[index].equipo_selec">{{
                                number_format(data.equipos[index].costototal, 0, 1)
                            }}</p>
                    </td>

                    <!-- factor -->
                    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        <input
                            type="number" step="0.01"
                            v-model.number="data.equipos[index].factor_final"
                            class="w-24 border-gray-50/75
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block
                                border-[0.5px] border-indigo-200
                                focus:border-indigo-700"
                        />
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <p v-if="data.equipos[index].equipo_selec">{{
                                number_format(data.equipos[index].valorunitario, 0, 1)
                            }}</p>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <p v-if="data.equipos[index].equipo_selec">{{
                                number_format(data.equipos[index].subtotalequip, 0, 1)
                            }}</p>
                    </td>

                    <!--                ultima columna-->
                    <td class="px-3 py-2 whitespace-nowrap">
                        <p v-if="data.equipos[index].equipo_selec">
                            {{ data.equipos[index].equipo_selec.alerta_mano_obra }}
                        </p>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <button @click.prevent="eliminarEquipo(index,data)"
                                type="button" @keydown.enter.prevent="false"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </td>

                </template>

                <!-- === MODELO 2 (texto libre) === -->
                <template v-else-if="equipo.tipoFila === 'texto'">
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <button @click="alternarTipoFila(equipo)"
                                type="button"
                                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
                            ♻️
                        </button>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <input type="text"
                               :value="equipo.orden"
                               class="w-14 border rounded text-center"
                               @keyup.enter="moverYReindexar(equipo, $event.target.value)"
                               @blur="verificarIndices(equipo, $event)"
                        >
                    </td>
                    <td colspan="15" class="p-2">
                        <input
                            type="text"
                            v-model="equipo.textoCategoria"
                            class="w-full border bg-gray-100 rounded p-2"
                            placeholder="Digite la categoria aquí..."
                        />
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <button @click.prevent="eliminarEquipo(index,data)"
                                type="button" @keydown.enter.prevent="false"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </td>
                </template>

                <!-- === MODELO 3 (cobre) === -->
                <template v-else-if="equipo.tipoFila === 'cobre'">
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <button @click="alternarTipoFila(equipo)" type="button"
                                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
                            ♻️
                        </button>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <input type="text"
                               :value="equipo.orden"
                               class="w-14 border rounded text-center"
                               @keyup.enter="moverYReindexar(equipo, $event.target.value)"
                               @blur="verificarIndices(equipo, $event)"
                        >
                    </td>
                    <td colspan="15" class="text-center">
                        <PrimaryButton type="button" @click="data.showModalcobre = true; data.indicemodelo = index">
                            Calcular cobre
                        </PrimaryButton>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <button @click.prevent="eliminarEquipo(index,data)"
                                type="button" @keydown.enter.prevent="false"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </td>
                </template>

                <!-- === MODELO 4 (cableado) === -->
                <template v-else-if="equipo.tipoFila === 'cableado'">
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <button @click="alternarTipoFila(equipo)"
                                type="button"
                                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
                            ♻️
                        </button>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
                        <input type="text"
                               :value="equipo.orden"
                               class="w-14 border rounded text-center"
                               @keyup.enter="moverYReindexar(equipo, $event.target.value)"
                               @blur="verificarIndices(equipo, $event)"
                        >
                    </td>
                    <td colspan="15" class="text-center">
                        <PrimaryButton type="button" @click="data.showModalcableado = true">
                            Calcular cableado
                        </PrimaryButton>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <button @click.prevent="eliminarEquipo(index,data)"
                                type="button" @keydown.enter.prevent="false"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Eliminar
                        </button>
                    </td>
                </template>
                <template v-else>
                    <td colspan="14" class="px-3 py-2 whitespace-nowrap text-center text-red-600">
                        <button @click="alternarTipoFila(equipo)"
                                type="button"
                                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
                            ♻️
                        </button>
                    </td>
                </template>
            </tr>

            <!--  fila totales-->
            <tr class="text-gray-900 text-lg border-t-2 border-gray-400">
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap">{{ number_format(data.valorItemUnitario, 0, 1) }}</th>
                <th class="px-3 py-2 whitespace-nowrap">
                    <TextInput type="number"
                               class="min-w-[40px] max-w-[80px] pl-5 border rounded-xl print:hidden"
                               :modelValue="data.cantidadItem"
                               @update:modelValue="newValue => data.cantidadItem = Math.max(0, Number(newValue) || 0)"
                               required
                               :placeholder="lang().placeholder.cantidad"
                    />
                    <div class="hidden print:block text-sm text-center mx-auto">
                        {{ data.cantidadItem }}
                    </div>
                </th>
                <th class="px-3 py-2 whitespace-nowrap">{{ formattedTotalItem }}</th>
            </tr>
            </tbody>
        </table>


        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>
        <Add_Sub_equipos v-if="props.mostrarDetalles"
                         :initialEquipos="data.equipos.length"
                         @updatEquipos="actualizarEquipos(
                            data.equipos.length + 1,
                            data,
                            props,
                            props.factorSeleccionado
                        )"
                         class=" mt-4 mb-10 mx-auto w-fit"
        />
        <FactorModal :show="data.showFactorModal" @close="data.showFactorModal = false"
                     @confirm="(factor) => actualizarTodosLosFactores(factor, data)"/>

        <Ccobre :show="data.showModalcobre"
                @close="data.showModalcobre = false"
                :indicemodelo="data.indicemodelo"
                @confirm="(mts,index) => actualizarFilaCobre(mts, data,index)"
        />
        <Ccableado :show="data.showModalcableado"
                   @close="data.showModalcableado = false"
                   :indicemodelo="data.indicemodelo"

                   @confirm="(mts,index) => actualizarFilaCable(mts, data,index)"
        />
        <PrimaryButton type="button" @click="data.showFactorModal = true" class="mt-4">Actualizar Factores
        </PrimaryButton>
    </div>

</template>

<script setup>
import TextInput from '@/Components/TextInput.vue';
import {computed, nextTick, onMounted, reactive, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import {formatPesosCol, number_format} from '@/global.ts';
import "vue-select/dist/vue-select.css";
import pkg from 'lodash';
import vSelect from "vue-select";
import InputError from "@/Components/InputError.vue";
import {PlantillaUno} from '@/Pages/Oferta/Plantillacontroller';
import {Plantilla_facil} from '@/Pages/Oferta/PlantillaTEST';
import {PencilIcon} from '@heroicons/vue/24/solid';
import FactorModal from "@/Components/FactorModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {focusStore} from '@/focusStore.js';

//perate
import {
    seleccionarDescuentoMayor,
    buscarEquipos2,
    actualizarEquipos,
    onInputPrecio,
    clasetablaCantidad2, clasetablaCantidad, clasetablaPorcentajes2, tableheaders, CorrejirrEquiposSinTipoYOrden,
    clasetablatresDatos
} from './commonFunctionsItem';
import {
    actualizarTodosLosFactores, truncarADosDecimales, useEquipos,
    eliminarEquipo
} from './commonFunctionsItem';
import {getPorcentaje, setPorcentaje} from './commonFunctionsItem';
import {actualizarFilaCobre, actualizarFilaCable} from './commonFunctionsItem';
import Ccobre from "@/Pages/parametro/ccobre.vue";
import Ccableado from "@/Pages/parametro/ccableado.vue";


const {_, debounce, pickBy} = pkg


// --------------------------- ** -------------------------
const emit = defineEmits(['upd_itemname', 'updateItem', 'checkzero', 'deleteItem', 'CallOne_planti', 'copyItem']);

function copyitem() {
    emit('copyItem', props.indexItem);
}


// <!--<editor-fold desc="props and data">-->
const props = defineProps({
    item: {
        type: Object,
        required: true
    },
    indexItem: {
        type: Number,
        required: true
    },
    mostrarDetalles: true,
    plantilla: Number,
    CallOnce_Plantilla: Boolean,
    factores: {
        type: Array,
        default: () => ({})
    },
    factorSeleccionado: Number,
});

/*
ITEM =
nombre
 descripcion


EQUIPO =
descuento_final: Un número para el descuento.
      costounitario: Un número que representa el costo unitario.
      costototal: Un número para el costo total.
      factor_final: Un número para el factor.
      valorunitario: Un número para el valor unitario.
 equipo_selec es un objeto que a su vez contiene:
      value: El código del equipo.
      title: La descripción del equipo.
      precio_de_lista: El precio de lista del equipo.
      descuento_basico: Descuento básico en porcentaje.
      descuento_proyectos: Descuento para proyectos en porcentaje.
      alerta_mano_obra: Un string con una alerta.
*/
//fin

/*
commonfunctionsitem.js  -->  actualizarEquipos


//temporal - mientras se decide como estructurar la plantilla
.map((equipt, i) => ({
        ...equipt,
        orden: i + 1
    }))
 */
const data = reactive({
    equipos: props.item.equipos,
    daitem: {
        nombre: '',
    },

    equiposOptions: [], //usado unicamente para el vselect
    searchEquipo: '', //usado unicamente para el vselect

    keysort: [],

    //valores para la suma
    subtotal: 0,
    valorItemUnitario: 0,
    cantidadItem: props.item.cantidad,
    valorItemtotal: 0,

    //visualizers
    EquipsOnZero: false,
    showFactorModal: false,
    showSomereindexar: false,
    showModalcobre: false,
    showModalcableado: false,
    indicemodelo: -1, //indice para cobre y cable

}, {deep: true})
// <!--</editor-fold>-->
//import consts and functions
const {
    moverYReindexar,
    verificarIndices
} = useEquipos(data)


/*
A - colocar aqui hasta que se pasen a edititem
 */
const tipos = ['modelo1', 'texto', 'cobre', 'cableado']
const alternarTipoFila = (equipo) => {
    const idx = tipos.indexOf(equipo.tipoFila)
    equipo.tipoFila = tipos[(idx + 1) % tipos.length]
}

watch(() => data.equipos, (lista) => {
    lista.forEach(e => {
        if (e.tipoFila === 'texto') {
            e.cantidad = 0
            e.factor_final = 1
            e.descuento_final = 0
        }
        if (['cobre', 'cableado'].includes(e.tipoFila)) {
            e.cantidad = 1 // fijo
        }
    })
}, {deep: true})

/*
B - colocar aqui hasta que se pasen a edititem
 */




//the most value function
function buscarEquipos(search) {
    if (!search || search.length < 2) return;

    // debounce(buscarEquipos2(search,data), 300);
    debounce(() => buscarEquipos2(search, data), 300)();

}

// <!--<editor-fold desc="onmounted">-->
onMounted(() => {
    if (props.CallOnce_Plantilla) {
        nextTick()
        if (props.plantilla === "1") {
            PlantillaUno(data, props.indexItem);
        }
        if (props.plantilla === "2") {
            PlantillaUno(data, props.indexItem);
        }

        if (props.plantilla === "99") {
            Plantilla_facil(data, props.indexItem);
        }
        emit('upd_itemname', props.indexItem, data.daitem.nombre);

        emit('CallOne_planti')
        // console.log(JSON.stringify(toRaw(props.item.equipos), null, 2));

        CorrejirrEquiposSinTipoYOrden(data)
        
    }

    // data.daitem.nombre = data.equipos[0]?.nombre_item || ''
    data.daitem = props.item
    SeleccionarDescuentos()
    AsignarFactores()
});


function AsignarFactores() {

    let fs = props.factorSeleccionado
    if (!fs || data.equipos.length < 1) return
    const isinteger = Number.isInteger(props.factorSeleccionado);
    if (!isinteger) return
    //fin validaciones
    fs = fs - 1
    let equipo = data.equipos[data.equipos.length - 1];
    equipo.factor_final = props.factores[fs].value ?? 1;

}

//once (onmounted)
function SeleccionarDescuentos() {
    data.equipos.forEach((equipo, index) => {
        if (equipo.equipo_selec) {
            seleccionarDescuentoMayor(index, data);
            data.equipos[index].equipo_selec.alerta_mano_obra =
                equipo.equipo_selec.alerta_mano_obra ?? 'No aplica';
        } else {
            equipo.descuento_final = 0; // Si no hay equipo seleccionado, el descuento final es 0
        }
    });
}

// <!--</editor-fold>-->


const handleEquipoChange = (changedIndex, newValue) => {
    nextTick();
    // console.log("🚀 ~ handleEquipoChange ~ data: ", data);
    seleccionarDescuentoMayor(changedIndex, data)

}


// <!--<editor-fold desc="eliminarequipo">-->
function deleteAndOk() {
    if (confirm("⚠️ ¿Está seguro de eliminar este item?")) {
        emit('checkzero', {
            index: props.indexItem,
            isZero: false,
        });
        nextTick()
        emit('deleteItem', props.indexItem);
    }
}


// <!--</editor-fold>-->


// <!--<editor-fold desc="computed">-->
// Validar que el orden digitado esté dentro de los límites
function ajustarOrden(equipo, data) {
    const total = data.equipos.length
    console.log("🚀 ~ ajustarOrden ~ total: ", total);
    if (equipo.orden < 1) equipo.orden = 1
    if (equipo.orden > total) equipo.orden = total
}


const rawTotalItem = computed(() => {
    if (!data.valorItemUnitario || !data.cantidadItem) return 0;
    return data.valorItemUnitario * data.cantidadItem;
});

const formattedTotalItem = computed(() => {
    if (!rawTotalItem.value) return "";
    return formatPesosCol(rawTotalItem.value);
});
// <!--</editor-fold>-->


// <!--<editor-fold desc="zouna watchers">-->

// hijodel( watch(() => data.equipos) && s(watch(() => data.cantidadItem)
function ActualizarTotalEquipo(new_cantidadItem) {
    data.valorItemUnitario = 0;
    data.equipos.forEach((equipo) => {
        if (equipo.equipo_selec && equipo.cantidad > 0) {

            if (equipo.descuento_final > 1 || equipo.descuento_final < 0) alert('Descuento invalido. Codigo: ' + equipo.equipo_selec.value);

            //primero costo
            const desFinal = (equipo.descuento_final ? (1 - equipo.descuento_final) : 1)
            equipo.costounitario = desFinal * equipo.equipo_selec.precio_de_lista;
            equipo.costototal = equipo.costounitario * equipo.cantidad;

            //despues factor
            equipo.valorunitario = equipo.costounitario * equipo.factor_final ?? 1;
            equipo.subtotalequip = equipo.cantidad * equipo.valorunitario;

        } else {
            equipo.subtotalequip = 0;
            equipo.costounit = 0;
        }
        data.valorItemUnitario += equipo.subtotalequip;


    })

    emit('updateItem', props.indexItem, {
        ...props.item,
        nombre: data.daitem.nombre,
        cantidad: new_cantidadItem,
        equipos: data.equipos,
        valor_total: rawTotalItem.value,
    });
}

// hijodel( watch(() => data.equipos)
const ValidarValorCero = (new_equipos) => {
    data.EquipsOnZero = false
    new_equipos.forEach((equipo) => {
        if (equipo.equipo_selec) {

            if (equipo.equipo_selec?.precio_de_lista == 0 || typeof (equipo.equipo_selec.precio_de_lista) === 'string') {
                data.EquipsOnZero = true
                emit('checkzero', {
                    index: props.indexItem,
                    isZero: true,
                });
            }
        }
    })
    if (!data.EquipsOnZero)
        emit('checkzero', {index: props.indexItem, isZero: false});
};

watch(() => data.equipos, (new_equipos, old_eq) => {
    if (new_equipos && old_eq) {
        nextTick();
        ActualizarTotalEquipo(data.cantidadItem);
        ValidarValorCero(new_equipos)
    }

}, {deep: true, immediate: true})


watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true, immediate: true})

watch(() => data.daitem, (daite) => {

    emit('upd_itemname', props.indexItem, daite.nombre);

}, {deep: true, immediate: true})

// <!--</editor-fold>-->


window.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key.toLowerCase() === 'p') {
        event.preventDefault();
        if (focusStore.focusedItemIndex === props.indexItem) {
            actualizarEquipos(
                data.equipos.length + 1,
                data,
                props,
                props.factorSeleccionado
            );
        }
    }
});
</script>

<style>
.zilefvs .vs__search::placeholder,
.zilefvs .vs__dropdown-toggle,
.zilefvs .vs__dropdown-menu {
    border: 1px solid #d1d5db; /* gray-300 */
    font-size: 0.7rem;
    color: rgb(0, 0, 0);
}

/* Oscuro usando Tailwind (clase "dark") o tu propio selector */
.dark .vs__dropdown-menu {
    --vs-dropdown-bg: #1e1e1e;
    --vs-dropdown-color: #d72020; /* color del texto en dropdown */
    --vs-dropdown-option-color: #f6f3f3;
    border: 1px solid #000000; /* gray-300 */

}

.dark .vs__selected {
    color: #ffffff;
    --vs-selected-color: #c4c4c4; /* texto del valor seleccionado */
}

</style>