<template>
    <div v-if="props.mostrarDetalles"
         class=" text-center mx-auto mt-6 mb-2 relative drop-shadow-xl min-w-[680px] h-12 overflow-hidden rounded-xl bg-gray-800">
        <div :id="'itemN' + props.indexItem"
             class="absolute flex items-center justify-center text-white z-[1] rounded-xl inset-0.5 bg-gray-800 py-1">
            <p class="text-center text-lg mx-2 w-32">Item {{ indexItem + 1 }}</p>
            <input
                type="text"
                v-model="daitemInternal.nombre"
                class="max-w-[880px] min-w-[480px] text-center border-0 py-0
                 dark:bg-gray-900  bg-gray-800
                 dark:text-gray-300  rounded-md mt-1 block w-full
                 text-xl"
            />

        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>

    <div class="p-4 mb-6 grid-cols-2 gap-4 overflow-x-scroll xs:min-w-[700px] md:min-w-[1500px] 2xl:min-w-[1800px]
     bg-gray-50 dark:bg-gray-900
     border-x-[2px] border-gray-300 dark:border-indigo-700 rounded-xl
     hover:shadow-indigo-300/50 dark:hover:shadow-indigo-700/50
     
     transition-all duration-500 ease-in-out">

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>


        <table class="overflow-x-auto divide-y-1 divide-gray-200 w-full dark:text-gray-100">
            <thead class="ltr:text-left rtl:text-right w-full">
            <tr class="*:font-medium bg-gray-900 text-white shadow-md rounded-xl dark:text-gray-100">
                <th class="px-3 py-2 whitespace-nowrap rounded-l-2xl dark:text-gray-100">#</th>
                <th class="px-3 py-2 mx-2 min-w-[10px] dark:text-gray-100">Código</th>
                <th class="px-3 py-2 mx-2 whitespace-nowrap min-w-[150px] max-w-[850px] dark:text-gray-100">
                    Descripción
                </th>
                <th class="-px-1 py-2 whitespace-nowrap max-w-[110px] dark:text-gray-100">Cantidad</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Precio de lista</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Descuentos</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Descuento final %</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Costo</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Costo total</th>
                <th class="px-3 py-2 min-w-[60px] whitespace-nowrap dark:text-gray-100">Factor</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Valor unitario</th>
                <th class="px-3 py-2 whitespace-nowrap  dark:text-gray-100">Subtotal</th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100">Alerta mano de obra</th>
                <th class="px-3 py-2 whitespace-nowrap rounded-r-2xl dark:text-gray-100">Acciones</th>
            </tr>
            </thead>

            <tbody v-for="(equipo, index) in equiposInternal" :key="index"
                   class="divide-y divide-gray-200 w-full">
            <tr class="*:text-gray-900 *:first:font-medium dark:text-gray-100"
                :class="{ 'bg-gray-200 dark:bg-gray-700': index % 2 !== 0 }"
            >
                <td class="px-3 py-2 whitespace-nowrap">{{ index + 1 }}°</td>
                <!-- codigo -->
                <td class="p-2 whitespace-nowrap mx-auto text-center max-w-[50px]">
                    {{ equipo?.equipo_selec?.value ?? '' }}
                </td>

                <!--                    descripcion-->
                <td class="p-2 whitespace-nowrap xs:min-w-[100px] md:min-w-[500px] max-w-[1450px]">
                    <vSelect
                        v-model="equiposInternal[index].equipo_selec"
                        :options="data.equiposOptions"
                        label="title"
                        :filterable="false"
                        append-to-body
                        placeholder="Buscar equipo..."
                        class="mt-1 block xs:min-w-[150px] md:min-w-[400px] w-full fixed"
                        @search="(q) => { data.searchEquipo = q; buscarEquipos(q) }"
                        @update:modelValue="handleEquipoChange(index, $event)" 
                        
                    />
                </td>
                <!-- fin descripcion-->

                <!-- cantidad-->
                <td class="mx-auto px-0 py-2 whitespace-nowrap text-center">
                    <input
                        type="number" min=0
                        v-model.number="equiposInternal[index].cantidad"
                        class="dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md 
                            mt-1 block pl-3  max-w-[110px] mx-auto
                            border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
                    />
                </td>
                <!-- fin cantidad-->


                <!-- precio de lista -->

                <td v-if="equiposInternal[index]?.equipo_selec?.precio_de_lista2 !== 0"
                    class="px-3 py-2 whitespace-nowrap mx-auto text-center dark:text-gray-100">
                    {{
                        equipo?.equipo_selec ?
                            number_format(equipo?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
                    }}
                    <PrimaryButton v-if="equipo"
                                   @click="equiposInternal[index].equipo_selec.precio_de_lista2 = 0"
                                   class="cursor-pointer p-0.5 h-5 w-5 inline-flex items-center rounded-full text-white bg-blue-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-600 ease-in-out"
                                   v-tooltip="'Editar'"
                    >
                        <PencilIcon class="w-5 h-5"/>
                    </PrimaryButton>
                </td>
                <!--  si no hay precio en la BD-->
                <td v-else-if="equiposInternal[index]?.equipo_selec"
                    class="px-3 py-2 whitespace-nowrap mx-auto text-center dark:text-gray-100">
                    <input
                        type="number"
                        v-model.number="equiposInternal[index].equipo_selec.precio_de_lista"
                        class="no-print max-w-[120px] border-gray-50/75 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"
                    />
                    <div class="hidden print:block text-sm">
                        {{ equiposInternal[index]?.equipo_selec?.precio_de_lista }}
                    </div>
                    <div v-if="equiposInternal[index]?.equipo_selec?.precio_de_lista == 0"
                         :id="'valor-nulo' + indexItem + '_' + index"
                         class="bg-red-600">
                        Valor nulo!
                    </div>
                </td>
                <!-- fin precio de lista-->


                <!--  show both discounts -->
                <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                    <p v-if="equiposInternal[index].equipo_selec"
                       class="max-w-[150px] border-gray-50/75 text-sm 
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block 
                            w-full border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
                    >
                        Basico: {{ equiposInternal[index]?.equipo_selec.descuento_basico * 100 }}%<br>
                        Proyectos: {{ equiposInternal[index]?.equipo_selec.descuento_proyectos * 100 }}%<br>
                    </p>
                </td>
                <!--                    descuento final -->
                <td class="p-2 whitespace-nowrap align-middle dark:text-gray-100">
                    <div class="inline-flex items-center justify-center w-full h-full">

                        <input
                            type="number" min=0 max="100"
                            :value="equiposInternal[index].descuento_final * 100"
                            @input="event => equiposInternal[index].descuento_final = Math.max(0, event.target.valueAsNumber / 100 || 0)"
                            class="border-gray-50/75 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md
                                max-w-[80px] border-[0.5px] border-indigo-200
                                focus:border-indigo-700 "
                        /> <span class="mx-2 w-1/6 "> %</span>
                    </div>
                </td>

                <!--  costo -->
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="equiposInternal[index].equipo_selec">{{
                            number_format(equiposInternal[index].costounitario, 0, 1)
                        }}</p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="equiposInternal[index].equipo_selec">{{
                            number_format(equiposInternal[index].costototal, 0, 1)
                        }}</p>
                </td>

                <!-- factor -->
                <td class="px-3 py-2 whitespace-nowrap mx-auto text-center dark:text-gray-100">
                    <input
                        type="number" step="0.01"
                        v-model.number="equiposInternal[index].factor_final" min=0
                        class=" min-w-[75px] max-w-32 border-gray-50/75
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block
                                border-[0.5px] border-indigo-200
                                focus:border-indigo-700"
                    />
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="equiposInternal[index].equipo_selec">{{
                            number_format(equiposInternal[index].valorunitario, 0, 1)
                        }}</p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="equiposInternal[index].equipo_selec">{{
                            number_format(equiposInternal[index].subtotalequip, 0, 1)
                        }}</p>
                </td>

                <!--                ultima columna-->
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <p v-if="equiposInternal[index].equipo_selec">
                        {{ equiposInternal[index].equipo_selec.alerta_mano_obra }}
                    </p>
                </td>
                <td class="px-3 py-2 whitespace-nowrap dark:text-gray-100">
                    <button @click.prevent="eliminarEquipo(index)"
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
                               v-model.number="cantidadItemInternal"
                               required
                               :placeholder="lang().placeholder.cantidad"
                    />
                </th>
                <th class="px-3 py-2 whitespace-nowrap dark:text-gray-100"> {{ formattedTotalItem }}</th>
            </tr>
        </table>

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>
        <Add_Sub_equipos v-if="props.mostrarDetalles" :initialEquipos="equiposInternal.value.length"
                         @updatEquipos="actualizarEquipos"
                         class="no-print mt-4 mb-10 mx-auto w-fit"
        />
    </div>
    <!--    <Add_Sub_equipos v-if="data.equipos.length > 6 && props.mostrarDetalles"-->
    <!--                     :initialEquipos="data.equipos.length"-->

    <!--                     @updatEquipos="actualizarEquipos"-->
    <!--                     class="no-print"-->
    <!--    />-->

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
import {PlantillaUno, PlantillaminiDebugmini} from '@/Pages/Oferta/Plantillacontroller';
import {PencilIcon} from '@heroicons/vue/24/solid';

// --------------------------- ** testing ai function ** -------------------------

const {_, debounce, pickBy} = pkg

const buscarEquipos = debounce(async (search) => {
    if (!search || search.length < 2) return;

    try {
        const res = await fetch(route('api.select.equipos') + '?q=' + encodeURIComponent(search), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        data.equiposOptions = await res.json();
    } catch (error) {
        alert('Error al buscar equipos:', error);
    }
}, 300);

const fetchEquipoByValue = async (searchValue) => {
    if (!searchValue) return null;
    try {
        const response = await fetch(route('api.select.equipos') + '?q=' + encodeURIComponent(searchValue));
        if (!response.ok) alert('Error de red: ' + response.statusText);

        const results = await response.json();
        return results.length > 0 ? results[1] : null; //el cero es para el input select
    } catch (error) {
        console.error('Error buscando equipo, error:  ', error);
        return null;
    }
};

// --------------------------- ** -------------------------
const emit = defineEmits(['updatiItems', 'checkzero']);


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
    equipos: {
        type: Array,
        required: true
    },

    mostrarDetalles: true,
    plantilla: Number,
    CallOnce_Plantilla: true,
    factores: {
        type: Array,
        default: () => ({})
    },
    factorSeleccionado: Number,
});


const daitemInternal = ref({});
const equiposInternal = ref([]);
const cantidadItemInternal = ref(0);

const data = reactive({
    equiposOptions: [],
    searchEquipo: '',
    subtotal: 0,
    valorItemUnitario: 0,
    valorItemtotal: 0,
    EquipsOnZero: false,
});
// <!--</editor-fold>-->


onMounted(async () => {
    daitemInternal.value = props.item;
    equiposInternal.value = props.equipos || [];
    cantidadItemInternal.value = props.item.cantidad;
    await nextTick();
    await RecuperarValueEquipos();
});

watch(() => props.item, (newItem) => {
    daitemInternal.value = newItem;
}, { deep: true });

watch(() => props.equipos, (newEquipos) => {
    equiposInternal.value = newEquipos || [];
}, { deep: true });

watch(() => props.item.cantidad, (newCantidad) => {
    cantidadItemInternal.value = newCantidad;
});

const RecuperarValueEquipos = async () => {

    await Promise.all(equiposInternal.value.map(async (equipo, index) => {
        if (equipo.equipo_selec && equipo.equipo_selec.value) {
            const equipoAPI = await fetchEquipoByValue(equipo.equipo_selec.value);
            if (equipoAPI) {
                equipo.equipo_selec.title = equipoAPI.title;
                equipo.equipo_selec.value = equipoAPI.value;
            }
        }
    }));
    await nextTick();
}


function AsignarFactores() {

    let fs = props.factorSeleccionado
    if (!fs) return
    const isinteger = Number.isInteger(props.factorSeleccionado);
    if (!isinteger) return
    //fin validaciones
    fs = fs - 1
    let equipo = equiposInternal.value[equiposInternal.value.length - 1];
    equipo.factor_final = props.factores[fs].value ?? 1;

}

//once (onmounted)
function SeleccionarDescuentos() {
    equiposInternal.value.forEach((equipo, index) => {
        if (equipo.equipo_selec) {
            seleccionarDescuentoMayor(index);
            equiposInternal.value[index].equipo_selec.alerta_mano_obra = equipo.equipo_selec.alerta_mano_obra ?? 'No aplica';
        } else {
            equipo.descuento_final = 0; // Si no hay equipo seleccionado, el descuento final es 0
        }
    });
}

const handleEquipoChange = (changedIndex, newValue) => { //toduoo
    nextTick();
    seleccionarDescuentoMayor(changedIndex)
}

function seleccionarDescuentoMayor(index) {

    const equipo = equiposInternal.value[index];
    const descuentoBasico = equipo.equipo_selec.descuento_basico ?? 0;
    const descuentoProyectos = equipo.equipo_selec.descuento_proyectos ?? 0;

    equiposInternal.value[index].descuento_final = (descuentoBasico >= descuentoProyectos) ? descuentoBasico : descuentoProyectos;

}

function eliminarEquipo(index) {
    equiposInternal.value.splice(index, 1);
}

//para el padre, cuando llaman a "añadir equipo" desde Add_Sub_equipos.vue
function actualizarEquipos(cantidad) {
    if (cantidad < 0) cantidad = 0;

    while (equiposInternal.value.length < cantidad) {
        equiposInternal.value.push({
            nombre_item: daitemInternal.value.nombre ?? '',
            equipo_selec: null,
            cantidad: 1,
            subtotalequip: 0,
        });
    }
    while (equiposInternal.value.length > cantidad) {
        equiposInternal.value.pop();
    }
    AsignarFactores();
}


// Cálculo reactivo
const rawTotalItem = computed(() => {
    if (!data.valorItemUnitario || !cantidadItemInternal.value) return 0;
    return data.valorItemUnitario * cantidadItemInternal.value;
});

const formattedTotalItem = computed(() => {
    if (!rawTotalItem.value) return "";
    return formatPesosCol(rawTotalItem.value);
});


// <!--<editor-fold desc="watchers">-->

// s( watch(() => data.equipos) && s(watch(() => data.cantidadItem)
function ActualizarTotalEquipo(new_cantidadItem) {
    data.valorItemUnitario = 0;
    equiposInternal.value.forEach((equipo) => {
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

    emit('updatiItems', {
        equipos: equiposInternal.value,
        valorItemUnitario: data.valorItemUnitario,
        TotalItem: rawTotalItem,
        indexItem: props.indexItem,
        cantidadItem: new_cantidadItem,
        valor_total_item: data.valorItemUnitario * new_cantidadItem,
        daitem: daitemInternal.value,
    });
}

// s( watch(() => data.equipos)
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

watch(() => equiposInternal.value, (new_equipos, old_eq) => {
    if (new_equipos && old_eq) {
        nextTick();
        ActualizarTotalEquipo(cantidadItemInternal.value);
        ValidarValorCero(new_equipos)
    }

}, {deep: true})


watch(() => cantidadItemInternal.value, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true})
// <!--</editor-fold>-->

</script>