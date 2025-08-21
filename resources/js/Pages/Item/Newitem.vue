<template>
    <div v-if="props.mostrarDetalles"
         class=" text-center mx-auto mt-6 mb-2 relative drop-shadow-xl min-w-[680px] h-12 overflow-hidden rounded-xl bg-gray-800">
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
            <button @click.prevent="deleteAndOk" 
                    type="button" @keydown.enter.prevent="false"
                    class="ml-4 bg-gray-900 hover:bg-red-900 text-white font-bold py-2 px-4 rounded">
                ¡Eliminar item!
            </button>
        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>

    <div class="p-4 mb-6 grid-cols-2 gap-4 overflow-x-scroll xs:min-w-[700px] md:min-w-[1500px] 2xl:min-w-[1800px]
     bg-gray-50 dark:bg-gray-900
     border-x-[2px] border-gray-300 dark:border-indigo-700 rounded-xl
     hover:shadow-indigo-300/50 dark:hover:shadow-indigo-700/50
     
     transition-all duration-300 ease-in-out"
         @focusin="focusStore.setFocusedItem(props.indexItem)"
         @focusout="focusStore.clearFocusedItem()">

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>


        <table class="divide-y-1 divide-gray-200 w-full">
            <thead class="ltr:text-left rtl:text-right">
            <tr class="*:font-medium dark:text-gray-900 bg-gray-900 text-white shadow-md rounded-xl">
                <th class="px-3 py-2 whitespace-nowrap rounded-l-2xl">#</th>
                <th class="px-3 py-2 mx-2 min-w-[10px]">Código</th>
                <th class="px-3 py-2 mx-2 whitespace-nowrap min-w-[150px] max-w-[700px]">Descripción</th>
                <th class="-px-1 py-2 whitespace-nowrap max-w-[110px]">Cantidad</th>
                <th class="px-3 py-2 min-w-[180px] max-w-[400px] whitespace-nowrap">Precio de lista</th>
                <th class="px-3 py-2 whitespace-nowrap">Descuentos</th>
                <th class="px-3 py-2 whitespace-nowrap">Descuento final %</th>
                <th class="px-3 py-2 whitespace-nowrap">Costo</th>
                <th class="px-3 py-2 whitespace-nowrap">Costo total</th>
                <th class="px-3 py-2 min-w-[60px] whitespace-nowrap">Factor</th>
                <th class="px-3 py-2 whitespace-nowrap">Valor unitario</th>
                <th class="px-3 py-2 whitespace-nowrap ">Subtotal</th>
                <th class="px-3 py-2 whitespace-nowrap">Alerta mano de obra</th>
                <th class="px-3 py-2 whitespace-nowrap rounded-r-2xl">Acciones</th>
            </tr>
            </thead>

            <tbody v-for="(equipo, index) in data.equipos" :key="index"
                   class="divide-y divide-gray-200">
            <tr class="*:text-gray-900 *:first:font-medium dark:text-white"
                :class="{ 'bg-gray-200 dark:bg-gray-700': index % 2 !== 0 }">
                <td class="px-3 py-2 whitespace-nowrap dark:text-white">{{ index + 1 }}°</td>
                <!-- codigo -->
                <td class="p-2 whitespace-nowrap mx-auto text-center max-w-[50px] dark:text-white">
                    {{ data.equipos[index]?.equipo_selec?.value ?? '' }}
                </td>

                <!--                    descripcion-->
                <td class="p-2 whitespace-nowrap min-w-[100px] max-w-[750px]">
                    <vSelect
                        v-model="data.equipos[index].equipo_selec"
                        :options="data.equiposOptions"
                        label="title"
                        :filterable="false"
                        append-to-body
                        placeholder="Buscar equipo..."
                        class="print:hidden mt-1 block w-full min-w-[250px] fixed"
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
                        class="dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md 
                            mt-1 block pl-3  max-w-[110px] mx-auto
                            border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
                    />
                </td>
                <!-- fin cantidad-->


                <!-- precio de lista -->

                <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0"
                    class="px-1 py-2 whitespace-nowrap mx-auto text-center">
                    <p class="w-full">
                        {{
                            data.equipos[index]?.equipo_selec ?
                                number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
                        }}
                        <Button type="button"
                                v-if="data.equipos[index]"
                                @click="data.equipos[index].equipo_selec.precio_de_lista2 = 0"
                                class="items-center py-2 bg-indigo-500 text-center
                                     border rounded-lg border-indigo-600 text-white
                                     hover:bg-indigo-700
                                      cursor-pointer h-8 w-8 ml-2"
                                v-tooltip="'Editar'"
                        >
                            <PencilIcon class="w-4 mx-auto"/>
                        </Button>
                    </p>
                </td>
                <!--  si no hay precio en la BD-->
                <td v-else-if="data.equipos[index]?.equipo_selec"
                    class="py-2 whitespace-nowrap mx-auto text-center">
                    <input
                        type="number"
                        v-model.number="data.equipos[index].equipo_selec.precio_de_lista"
                        class="max-w-[140px] border-gray-50/75 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"
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
                <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                    <p v-if="data.equipos[index].equipo_selec"
                       class="max-w-[150px] border-gray-50/75 text-sm 
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block 
                            w-full border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
                    >
                        Basico: {{ truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_basico * 100) }}
                        %<br>
                        Proyectos: {{
                            truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_proyectos * 100)
                        }} %<br>
                    </p>
                </td>
                <!--                    descuento menor -->
                <td class="p-2 whitespace-nowrap align-middle">
                    <div class="inline-flex items-center justify-center w-full h-full">
                        <input
                            type="number" min=0
                            :value="data.equipos[index].descuento_final * 100"
                            @input="event => data.equipos[index].descuento_final = Math.max(0, (event.target.valueAsNumber.toFixed(2)) / 100)"
                            class="border-gray-50/75 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md
                                max-w-[80px] border-[0.5px] border-indigo-200
                                focus:border-indigo-700 "
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
                        type="number"
                        v-model.number="data.equipos[index].factor_final"
                        class=" min-w-[75px] max-w-32 border-gray-50/75
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
                    <button @click.prevent="eliminarEquipo(index)"
                            type="button" @keydown.enter.prevent="false"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar
                    </button>
                </td>
            </tr>
            </tbody>
            <tbody>


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
                         @updatEquipos="actualizarEquipos"
                         class=" mt-4 mb-10 mx-auto w-fit"
        />
        <FactorModal :show="data.showFactorModal" @close="data.showFactorModal = false"
                     @confirm="actualizarTodosLosFactores"/>
        <PrimaryButton type="button" @click="data.showFactorModal = true"
                       class="mt-4">
            Actualizar Factores
        </PrimaryButton>
    </div>
    <!--    <Add_Sub_equipos v-if="data.equipos.length > 6 && props.mostrarDetalles"-->
    <!--                     :initialEquipos="data.equipos.length"-->

    <!--                     @updatEquipos="actualizarEquipos"-->
    <!--                     class=""-->
    <!--    />-->

</template>

<script setup>
import TextInput from '@/Components/TextInput.vue';
import {computed, nextTick, onMounted, reactive, ref, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import {formatPesosCol, number_format} from '@/global.ts';
import "vue-select/dist/vue-select.css";
import pkg from 'lodash';
import vSelect from "vue-select";
import InputError from "@/Components/InputError.vue";
import {PlantillaUno, PlantillaminiDebugmini2} from '@/Pages/Oferta/Plantillacontroller';
import {PencilIcon} from '@heroicons/vue/24/solid';
import FactorModal from "@/Components/FactorModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {focusStore} from '@/focusStore.js';

//perate
import { seleccionarDescuentoMayor,buscarEquipos2 } from './commonFunctionsItem';

const {_, debounce, pickBy} = pkg



// --------------------------- ** -------------------------
const emit = defineEmits(['upd_itemname','updateItem', 'checkzero', 'deleteItem', 'CallOne_planti']);


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
const data = reactive({
    daitem: {
        nombre: '',
    },
    equipos: props.item.equipos,
    equiposOptions: [],
    searchEquipo: '',
    subtotal: 0,
    valorItemUnitario: 0,
    cantidadItem: props.item.cantidad,
    valorItemtotal: 0,
    EquipsOnZero: false,
    showFactorModal: false,
}, {deep: true})
// <!--</editor-fold>-->


//the most value function
function buscarEquipos(search){
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
            PlantillaminiDebugmini2(data, props.indexItem);
        }
        emit('upd_itemname', props.indexItem, data.daitem.nombre);

        emit('CallOne_planti')
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
            seleccionarDescuentoMayor(index,data);
            data.equipos[index].equipo_selec.alerta_mano_obra = equipo.equipo_selec.alerta_mano_obra ?? 'No aplica';
        } else {
            equipo.descuento_final = 0; // Si no hay equipo seleccionado, el descuento final es 0
        }
    });
}

// <!--</editor-fold>-->

function deleteAndOk() {
    if (confirm("⚠️ ¿Está seguro de eliminar este item?")) {
        emit('checkzero', {
            index: props.indexItem,
            isZero: false,
        });
        emit('deleteItem', props.indexItem);
    }
}


const handleEquipoChange = (changedIndex, newValue) => {
    nextTick();
        console.log("🚀 ~ handleEquipoChange ~ data: ", data);
        seleccionarDescuentoMayor(changedIndex,data)

}

function eliminarEquipo(index) {
    data.equipos.splice(index, 1);
}


//para el padre, cuando llaman a "añadir equipo" desde Add_Sub_equipos.vue
function actualizarEquipos(cantidad) {
    if (cantidad < 0) cantidad = 0;

    const initialLength = data.equipos.length;

    while (data.equipos.length < cantidad) {
        data.equipos.push({
            nombre_item: data.daitem.nombre ?? '',
            equipo_selec: null,
            cantidad: 1,
            descripcion: '',
            descuento_final: 0,
            factor_final: 1,
            costounitario: 0,
            costototal: 0,
            valorunitario: 0,
            subtotalequip: 0,
        });
    }
    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }

    if (data.equipos.length > initialLength) {
        AsignarFactores();
    }
}//todo: esto esta diferente a edititem


// Cálculo reactivo
const rawTotalItem = computed(() => {
    if (!data.valorItemUnitario || !data.cantidadItem) return 0;
    return data.valorItemUnitario * data.cantidadItem;
});

const formattedTotalItem = computed(() => {
    if (!rawTotalItem.value) return "";
    return formatPesosCol(rawTotalItem.value);
});

// <!--<editor-fold desc="zouna watchers">-->

// s( watch(() => data.equipos) && s(watch(() => data.cantidadItem)
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

// s( watch(() => data.equipos)
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


function truncarADosDecimales(numero) { //newis
    return Math.trunc(numero * 100) / 100;
}

function actualizarTodosLosFactores(nuevoFactor) {
    if (typeof nuevoFactor !== 'number' || nuevoFactor < 0) {
        alert("El factor debe ser un número positivo.");
        return;
    }
    data.equipos.forEach(equipo => {
        equipo.factor_final = nuevoFactor;
    });
}


window.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key.toLowerCase() === 's') {
        event.preventDefault();
        if (focusStore.focusedItemIndex === props.indexItem) {
            actualizarEquipos(data.equipos.length + 1);
        }
    }
});
</script>
<style>
/* 👇 Oculta elementos con clase .print en pantalla */
.print {
    display: none;
}

/* 👇 Reglas para impresión */
@media print {
    body {
        font-size: 11px !important;
    }

    table {
        width: 105% !important;
        font-size: 9px !important;
    }

    th, td {
        padding: 2px 1px !important;
        white-space: normal !important;
    }

    select,
    input,
    .v-select,
    .v-select .dropdown-toggle {
        font-size: 9px !important;
        padding: 4px 6px !important;
    }

    .print {
        display: block !important; /* O inline / inline-block según el caso */
    }

    .print-container {
        zoom: 0.75;
        margin: 0 !important;
    }
}

</style>