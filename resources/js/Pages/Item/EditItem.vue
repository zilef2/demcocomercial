<template>
    <div v-if="props.mostrarDetalles"
         class=" text-center mx-auto mt-6 mb-2 relative drop-shadow-xl min-w-[680px] h-12 overflow-hidden rounded-xl bg-gray-800">
        <div :id="'itemN' + props.indexItem"
             class="absolute flex items-center justify-center text-white z-[1] rounded-xl inset-0.5 bg-gray-800 py-1">
            <p class="text-center text-lg mx-2 w-32">Item {{ indexItem + 1 }}</p>
            <input
                type="text"
                :value="props.item.nombre"
                @input="$emit('upd_itemname', props.indexItem, $event.target.value)"
                class="max-w-[880px] min-w-[480px] text-center border-0 py-0
                 dark:bg-gray-900  bg-gray-800
                 dark:text-gray-300  rounded-md mt-1 block w-full
                 text-xl"
            />
            <button @click.prevent="copyitem"
                    type="button" @keydown.enter.prevent="false"
                    class="ml-4 bg-gray-900 hover:bg-red-900 text-white font-bold py-2 px-4 rounded">
                Copiar item
            </button>
            <button @click.prevent="deleteAndOk" type="button"
                    @keydown.enter.prevent="false"
                    class="ml-4 bg-gray-900 hover:bg-red-900 text-white font-bold py-2 px-4 rounded">
                ¡Eliminar item!
            </button>

        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>

    <div class="p-4 mb-6 grid-cols-2 gap-4 overflow-x-auto xs:min-w-[700px] md:min-w-[1500px] 2xl:min-w-[1800px]
     bg-gray-50 dark:bg-gray-900
     border-x-[2px] border-gray-300 dark:border-indigo-700 rounded-xl
     hover:shadow-indigo-300/50 dark:hover:shadow-indigo-700/50
     
     transition-all duration-500 ease-in-out"
         @focusin="focusStore.setFocusedItem(props.indexItem)"
         @focusout="focusStore.clearFocusedItem()"
    >

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>


        <table class="overflow-x-auto divide-y-1 divide-gray-200 w-full dark:text-gray-100">
            <thead class="ltr:text-left rtl:text-right w-full">
            <tr class="*:font-medium dark:text-gray-900 bg-gray-900 text-white shadow-md rounded-xl"
                v-html="tableheaders"></tr>
            </thead>

            <tbody v-for="(equipo, index) in data.equipos" :key="index"
                   class="divide-y divide-gray-200 w-full">
            <tr class="*:text-gray-900 *:first:font-medium dark:text-gray-100"
                :class="{ 'bg-gray-200 dark:bg-gray-700': index % 2 !== 0 }"
            >
                <td class="px-3 py-2 whitespace-nowrap dark:text-white">{{ index + 1 }}°</td>
                 <!-- codigo -->
                <td class="p-2 whitespace-nowrap min-w-[100px] max-w-[750px] text-center">
                <!--                <td class="p-2 whitespace-nowrap mx-auto text-center max-w-[50px] dark:text-white">-->
                     <p class="mx-auto">{{ data.equipos[index]?.equipo_selec?.value ?? '' }}</p> 
                <!--                </td>-->
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
                <td :class="'mx-auto px-0 py-2 whitespace-nowrap text-center'+clasetablaCantidad2">
                    <input
                        type="number" min=0
                        v-model.number="data.equipos[index].cantidad"
                        :class="clasetablaCantidad + clasetablaCantidad2"
                    />
                </td>
                <!-- fin cantidad-->


                <!-- precio de lista -->

                <!-- precio de lista -->
                <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0"
                    class="px-1 py-2 whitespace-nowrap mx-auto text-center">
                    <p class="w-full dark:text-white ">
                        {{
                            data.equipos[index]?.equipo_selec ?
                                number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
                        }}
                        <Button type="button"
                                v-if="data.equipos[index]"
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
                    class="py-2 whitespace-nowrap mx-auto text-center">
                    <input
                        type="text"
                        :value="formatPesosCol(data.equipos[index].equipo_selec.precio_de_lista)"
                        @input="onInputPrecio($event, index,data)"
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
                <td class="text-xs md:text-md lg:table-cell px-3 py-2 whitespace-nowrap mx-auto text-center">
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
                <!--                    descuento mayor -->
                <td class=" p-2 whitespace-nowrap align-middle">
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
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="data.equipos[index].equipo_selec">{{
                            number_format(data.equipos[index].costounitario, 0, 1)
                        }}</p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
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
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="data.equipos[index].equipo_selec">{{
                            number_format(data.equipos[index].valorunitario, 0, 1)
                        }}</p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="data.equipos[index].equipo_selec">{{
                            number_format(data.equipos[index].subtotalequip, 0, 1)
                        }}</p>
                </td>

                <!--                ultima columna-->
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="data.equipos[index].equipo_selec">
                        {{ data.equipos[index].equipo_selec.alerta_mano_obra }}
                    </p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <button @click.prevent="eliminarEquipo(index)"
                            type="button" @keydown.enter.prevent="false"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar
                    </button>
                </td>
            </tr>
            </tbody>


            <!--  fila totales-->
            <tr class="text-gray-900 text-lg">
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap">-</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    {{ number_format(data.valorItemUnitario, 0, 1) }}
                </th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <TextInput type="number"
                               class="min-w-[40px] max-w-[80px] pl-5 border rounded-xl print:hidden"
                               v-model.number="data.cantidadItem"
                               required
                               :placeholder="lang().placeholder.cantidad"
                    />
                </th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100"> {{ formattedTotalItem }}</th>
            </tr>
        </table>
        <PrimaryButton type="button" @click="data.showFactorModal = true" class="mt-4">Actualizar Factores
        </PrimaryButton>
        <FactorModal :show="data.showFactorModal" @close="data.showFactorModal = false"
                     @confirm="actualizarTodosLosFactores"/>
        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>
        <Add_Sub_equipos v-if="props.mostrarDetalles"
                         :initialEquipos="data.equipos?.length"
                         @updatEquipos="actualizarEquipos(
                            data.equipos.length + 1,
                            data,
                            props,
                            props.factorSeleccionado
                        )"
                         class="no-print mt-4 mb-10 mx-auto w-fit"
        />
    </div>

</template>

<script setup>
import TextInput from '@/Components/TextInput.vue';
import {computed, nextTick, onMounted, reactive, ref, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import {dd, formatPesosCol, number_format} from '@/global.ts';
import {
    seleccionarDescuentoMayor,
    buscarEquipos2,
    actualizarEquipos,
    onInputPrecio,
    clasetablaCantidad2, clasetablaCantidad, clasetablaPorcentajes2, tableheaders, CorrejirrEquiposSinTipoYOrden,
} from './commonFunctionsItem';
import {actualizarTodosLosFactores, truncarADosDecimales} from './commonFunctionsItem';
import {getPorcentaje, setPorcentaje} from './commonFunctionsItem';

import "vue-select/dist/vue-select.css";
import pkg from 'lodash';
import vSelect from "vue-select";
import InputError from "@/Components/InputError.vue";
import {PencilIcon} from '@heroicons/vue/24/solid';
import FactorModal from "@/Components/FactorModal.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {focusStore} from '@/focusStore.js';

// --------------------------- ** testing ai function ** -------------------------

const {_, debounce, pickBy} = pkg

const fetchEquipoByValue = async (searchValue) => {
    if (!searchValue) return null;
    try {
        const response = await fetch(route('api.select.equips2') + '?q=' + encodeURIComponent(searchValue));
        if (!response.ok) alert('Error de red: ' + response.statusText);

        const results = await response.json();
        return results.length > 0 ? results[1] : null; //el cero es para el input select
    } catch (error) {
        console.error('Error buscando equipo, error:  ', error);
        return null;
    }
};

// --------------------------- ** -------------------------
const emit = defineEmits(['upd_itemname', 'updateItem', 'checkzero', 'deleteItem', 'copyItem']);

function copyitem() {
    emit('copyItem', props.indexItem);
}

// <!--<editor-fold desc="props and data">-->
const props = defineProps({
    item: { //:sin la info de los equipos
        type: Object,
        required: true
    },
    indexItem: {
        type: Number,
        required: true
    },
    equipos: {
        type: Array,
        required: true
    },

    mostrarDetalles: true,
    plantilla: Number,
    factores: {
        type: Array,
        default: () => ({})
    },
    factorSeleccionado: Number,
    onmountedisOk: Boolean,
});


const data = reactive({
    equipos: props.item.equipos,

    equiposOptions: [],
    searchEquipo: '',
    subtotal: 0,
    valorItemUnitario: 0,
    cantidadItem: 0,
    valorItemtotal: 0,
    EquipsOnZero: false,

    //visual
    showFactorModal: false,

}, {deep: true})
// <!--</editor-fold>-->

//the most value function
function buscarEquipos(search) {
    if (!search || search.length < 2) return;

    // debounce(buscarEquipos2(search,data), 300);
    debounce(() => buscarEquipos2(search, data), 300)();

}

// <!--<editor-fold desc="Onmounted">-->
onMounted(async () => {
    if (props.onmountedisOk) {
        await nextTick()
        data.equipos = props.equipos || [];
        data.cantidadItem = props.item.cantidad;
        data.valorItemUnitario = props.item.valor_unitario_item;
        data.valorItemtotal = props.item.valor_total_item;
        await nextTick()
        await RecuperarValueEquipos1()
        await nextTick()
        CorrejirrEquiposSinTipoYOrden(data)
    }
});

const RecuperarValueEquipos1 = async () => {
    if (props.equipos) {
        await Promise.all(props.equipos.map(async (equipo, index) => {
            if (equipo.codigo) {
                const IntCode = parseInt(equipo.codigo)
                if (IntCode) {

                    data.equipos[index].cantidad = equipo.pivot.cantidad_equipos;
                    data.equipos[index].factor_final = parseFloat(equipo.pivot.factor)
                    data.equipos[index].costounitario = parseFloat(equipo.pivot.costo_unitario)
                    data.equipos[index].costototal = parseFloat(equipo.pivot.costo_total)
                    data.equipos[index].subtotalequip = parseFloat(equipo.pivot.subtotalequip)
                    data.equipos[index].valorunitario = parseFloat(equipo.pivot.valorunitarioequip)
                    data.equipos[index].descuento_final = parseFloat(equipo.pivot.descuento_final)


                    if (!equipo.pivot.precio_de_lista) {
                        const equipoAPI = await fetchEquipoByValue(IntCode);
                        if (equipoAPI) {
                            data.equipos[index].equipo_selec = {
                                value: IntCode,
                                title: equipoAPI.title,
                                precio_de_lista: equipo.pivot.precio_de_lista ?? equipoAPI.precio_de_lista,
                                alerta_mano_obra: equipo.pivot.alerta_mano_obra ?? equipoAPI.alerta_mano_obra,
                                descuento_basico: parseFloat(equipo.pivot.descuento_basico) ?? equipoAPI.descuento_basico,
                                descuento_proyectos: parseFloat(equipo.pivot.descuento_proyectos) ?? equipoAPI.descuento_proyectos,
                                descripcion: equipo.pivot.descripcion ?? equipoAPI.descripcion,
                                precio_ultima_compra: equipo.pivot.precio_ultima_compra ?? equipoAPI.precio_ultima_compra,
                                precio_con_descuento: equipo.pivot.precio_con_descuento ?? equipoAPI.precio_con_descuento,
                                precio_con_descuento_proyecto: equipo.pivot.precio_con_descuento_proyecto ?? equipoAPI.precio_con_descuento_proyecto,
                                nombrefactor: equipo.pivot.nombrefactor ?? equipoAPI.nombrefactor,
                                equipo_id: equipo.pivot.equipo_id ?? equipoAPI.equipo_id,
                                fecha_actualizacion: equipo.pivot.fecha_actualizacion ?? equipoAPI.fecha_actualizacion,
                            };
                        }
                    } else {
                        /*
                        descuento_basico : "0.690000"
                        descuento_final : "0.220"
                        descuento_proyectos : "0.690000"
                     */
                        data.equipos[index].equipo_selec = {
                            value: IntCode,
                            title: equipo.pivot.descripcion,
                            precio_de_lista: equipo.pivot.precio_de_lista,
                            // precio_de_lista: equipo.pivot.precio_de_lista ?? equipoAPI.precio_de_lista,
                            // alerta_mano_obra: equipo.pivot.alerta_mano_obra ?? equipoAPI.alerta_mano_obra,
                            descuento_basico: parseFloat(equipo.pivot.descuento_basico),
                            descuento_proyectos: parseFloat(equipo.pivot.descuento_proyectos),
                            descuento_final: parseFloat(equipo.pivot.descuento_final),
                            // descripcion: equipo.pivot.descripcion ?? equipoAPI.descripcion,
                            // precio_ultima_compra: equipo.pivot.precio_ultima_compra ?? equipoAPI.precio_ultima_compra,
                            // precio_con_descuento: equipo.pivot.precio_con_descuento ?? equipoAPI.precio_con_descuento,
                            // precio_con_descuento_proyecto: equipo.pivot.precio_con_descuento_proyecto ?? equipoAPI.precio_con_descuento_proyecto,
                            // nombrefactor: equipo.pivot.nombrefactor ?? equipoAPI.nombrefactor,
                            // equipo_id: equipo.pivot.equipo_id ?? equipoAPI.equipo_id,
                            // fecha_actualizacion: equipo.pivot.fecha_actualizacion ?? equipoAPI.fecha_actualizacion,
                        };
                    }

                    data.cantidadItem = props.item.cantidadItem;
                }
            }
        }));
    }
    await nextTick();
}

const handleEquipoChange = (changedIndex, newValue) => { //toduoo
    nextTick();
    seleccionarDescuentoMayor(changedIndex, data)
}

// <!--</editor-fold>-->


// <!--<editor-fold desc="eliminarequipo">-->

function eliminarEquipo(index) {
    data.equipos.splice(index, 1);
}

function deleteAndOk() {
    if (confirm("¿Está seguro de eliminar este item?")) {
        emit('checkzero', {
            index: props.indexItem,
            isZero: false,
        });
        emit('deleteItem', props.indexItem);
    }
}

// <!--</editor-fold>-->


// Cálculo reactivo
const rawTotalItem = computed(() => {
    if (!data.valorItemUnitario || !data.cantidadItem) return 0;
    return data.valorItemUnitario * data.cantidadItem;
});

const formattedTotalItem = computed(() => {
    if (!rawTotalItem.value) return "";
    return formatPesosCol(rawTotalItem.value);
});


// <!--<editor-fold desc="watchers">-->

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
        // nombre: data.daitem.nombre,
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

            if (isNaN(Number(equipo.equipo_selec?.precio_de_lista))) { //dif from nuevaoferta
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

}, {deep: true})


watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true})


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
    color: #e5e5e5;
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