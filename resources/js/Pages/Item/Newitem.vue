<template>
    <div v-if="props.mostrarDetalles"
         class=" text-center mx-auto mt-6 mb-2 relative drop-shadow-xl w-[500px] h-12 overflow-hidden rounded-xl bg-gray-800">
        <div :id="'itemN' + props.indexItem"
            class="absolute flex items-center justify-center text-white z-[1] rounded-xl inset-0.5 bg-gray-800 py-1">
            <p class="text-center text-lg mx-2 w-32">Item {{ indexItem + 1 }}</p>
            <input
                type="text"
                v-model="data.daitem.nombre"
                class="max-w-[480px] text-center border-0 py-0
                 dark:bg-gray-900  bg-gray-800
                 dark:text-gray-300  rounded-md mt-1 block w-full
                 text-xl"
            />
        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>
    <div class="p-4 mb-6 grid-cols-2 gap-4 overflow-x-scroll xs:min-w-[900px] md:min-w-[1600px]
     bg-gray-100 dark:bg-gray-900
     border-x-[2px] border-indigo-300 dark:border-indigo-700 rounded-xl
     hover:shadow-indigo-300/50 dark:hover:shadow-indigo-700/50
     hover:bg-gray-200 dark:hover:bg-gray-800
     transition-all duration-300 ease-in-out">

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>

        <div
            class="xs:max-w-[900px] md:max-w-[1600px] mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 print-container">
            <table class="min-w-full divide-y-2 divide-gray-200 xs:max-w-[900px] md:max-w-[1600px]">
                <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium dark:text-gray-900 bg-gray-900
                 text-white shadow-md 
                 rounded-xl">
                    <th class="px-3 py-2 whitespace-nowrap rounded-l-2xl">#</th>
                    <th class="px-3 py-2 mx-2 max-w-[500px]">Código</th>
                    <th class="px-3 py-2 mx-2 whitespace-nowrap min-w-[400px]">Descripción</th>
                    <th class="px-3 py-2 whitespace-nowrap">Valor Unitario</th>
                    <th class="px-3 py-2 whitespace-nowrap">Cantidad</th>
                    <th class="px-3 py-2 whitespace-nowrap rounded-r-2xl">Total Equipo:</th>
                </tr>
                </thead>

                <tbody v-for="(equipo, index) in data.equipos" :key="index"
                       class="divide-y divide-gray-200">
                <tr class="*:text-gray-900 *:first:font-medium">
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ index + 1 }}°
                    </td>
                    <td
                        class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        {{ data.equipos[index]?.equipo_selec?.value ?? '' }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap min-w-[500px]">
                        <vSelect
                            v-model="data.equipos[index].equipo_selec"
                            :options="data.equiposOptions"
                            label="title"
                            :filterable="false"
                            append-to-body
                            placeholder="Buscar equipo..."
                            class="print:hidden mt-1 block w-full min-w-[500px] fixed"
                            @search="(q) => { data.searchEquipo = q; buscarEquipos(q) }"
                        />


                        <div class="hidden print:block text-sm">
                            {{ data.equipos[index]?.equipo_selec?.title ?? 'Sin selección' }}
                        </div>
                    </td>
                    
                    <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0"
                        class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        {{
                            data.equipos[index]?.equipo_selec ?
                                number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
                        }}
                        <PrimaryButton
                            @click="data.equipos[index].equipo_selec.precio_de_lista2 = 0"
                            class="cursor-pointer p-0.5 h-5 w-5 inline-flex items-center rounded-full text-white bg-blue-300 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-600 ease-in-out"
                            v-tooltip="'Editar'"
                        >
                            <PencilIcon class="w-4 h-4"/>
                        </PrimaryButton>
                    </td>
                    <!--  si no hay precio en la BD-->
                    <td v-else class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        <input
                            type="number"
                            v-model.number="data.equipos[index].equipo_selec.precio_de_lista"
                            class="no-print max-w-[120px] border-gray-50/75 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"
                        />
                        <div class="hidden print:block text-sm">
                            {{ data.equipos[index]?.equipo_selec?.precio_de_lista }}
                        </div>
                        <div v-if="data.equipos[index]?.equipo_selec?.precio_de_lista == 0"
                             :id="'valor-nulo' + indexItem + '_' + index"
                             class="bg-red-600">
                            Valor nulo!
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        <input
                            type="number"
                            v-model.number="data.equipos[index].cantidad"
                            class="no-print max-w-[120px] 
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md 
                            mt-1 block w-full  pl-5
                            border-[0.5px] border-indigo-200
                            focus:border-indigo-700" 
                        />
                        
                        <p class="print mx-auto text-center">{{ data.equipos[index].cantidad }}</p>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">{{
                            number_format(data.equipos[index].subtotalequip, 0, 1)
                        }}
                    </td>
                </tr>
                </tbody>
                <tr class="text-gray-900 text-lg">
                    <th class="px-3 py-2 whitespace-nowrap">-</th>
                    <th class="px-3 py-2 whitespace-nowrap">-</th>
                    <th class="px-3 py-2 whitespace-nowrap">-</th>
                    <th class="px-3 py-2 whitespace-nowrap">{{ number_format(data.valorItemUnitario, 0, 1) }}</th>
                    <th class="px-3 py-2 whitespace-nowrap">
                        <TextInput type="number"
                                   class="min-w-[40px] max-w-[80px] pl-5 border rounded-xl print:hidden"
                                   v-model.number="data.cantidadItem"
                                   required
                                   :placeholder="lang().placeholder.cantidad"
                        />
                        <div class="hidden print:block text-sm text-center mx-auto">
                            {{ data.cantidadItem }}
                        </div>
                    </th>
                    <th class="px-3 py-2 whitespace-nowrap">{{ formattedTotalItem }}</th>
                </tr>
            </table>
        </div>

        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>
        <Add_Sub_equipos v-if="props.mostrarDetalles" :initialEquipos="data.equipos.length"
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
import {computed, onMounted, reactive, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import {formatPesosCol, number_format} from '@/global.ts';
import "vue-select/dist/vue-select.css";
import pkg from 'lodash';
import vSelect from "vue-select";
import InputError from "@/Components/InputError.vue";
import {PlantillaUno, PlantillaDebug} from '@/Pages/Oferta/Plantillacontroller';
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
        console.error('Error al buscar equipos:', error);
    }
}, 300);

// --------------------------- ** -------------------------
const emit = defineEmits(['updatiItems', 'checkzero']);

const props = defineProps({

    daitem: {
        type: Object,
        required: true
    },
    valorUnitario: {
        type: Number,
        required: true
    },
    initialCantidad: {
        type: Number,
        default: 1
    },
    indexItem: {
        type: Number,
        required: true
    },
    mostrarDetalles: true,
    plantilla: Number,
    CallOnce_Plantilla: true,
});


const data = reactive({
    daitem: {
        nombre: props.daitem.nombre,
    },
    equiposOptions: [],
    searchEquipo: '',
    subtotal: 0,
    equipos: [],
    valorItemUnitario: 0,
    cantidadItem: 1,
    valorItemtotal: 0,
    EquipsOnZero: false,

}, {deep: true})

onMounted(() => {
    if (props.CallOnce_Plantilla) {

        setTimeout(() => {
            console.log("🚀 ~  ~ props.plantilla: ", props.plantilla);
            if (props.plantilla === "1") {
                PlantillaUno(data, props.indexItem);
            }
            if (props.plantilla === "2") {

                PlantillaDebug(data);
                console.log("🚀 ~  ~ data: ", data);
            }
            data.daitem.nombre = data.equipos[0]?.nombre_item || ''
        }, 300);
        data.CallOnce_Plantilla = false; // no se vuelve a llamar
    }
});


//para el padre, cuando llaman a "añadir equipo" desde Add_Sub_equipos.vue
function actualizarEquipos(cantidad) {
    if (cantidad < 0) cantidad = 0;

    while (data.equipos.length < cantidad) {
        data.equipos.push({
            nombre_item: data.daitem.nombre ?? '',
            equipo_selec: null,
            cantidad: 1,
            subtotalequip: 0
        });
    }
    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }
    console.log("🚀 ~ actualizarEquipos ~ data.equipos: ", data.equipos);
}



// Cálculo reactivo
const rawTotalItem = computed(() => {
    if (!data.valorItemUnitario || !data.cantidadItem) return 0;
    return data.valorItemUnitario * data.cantidadItem;
});

const formattedTotalItem = computed(() => {
    if (!rawTotalItem.value) return "";
    return formatPesosCol(rawTotalItem.value);
});


// <!--<editor-fold desc="Padres e hijos">-->
function ActualizarTotalEquipo(new_cantidadItem) {
    data.valorItemUnitario = 0;
    data.equipos.forEach((equipo) => {
        if (equipo.equipo_selec) {
            equipo.subtotalequip = equipo.cantidad * equipo.equipo_selec.precio_de_lista;
        } else {
            equipo.subtotalequip = 0;
        }
        data.valorItemUnitario += equipo.subtotalequip;
    })

    // console.log('valor unitario',  data.valorItemUnitario * new_cantidadItem);
    emit('updatiItems', {
        equipos: data.equipos,
        valorItemUnitario: data.valorItemUnitario,
        TotalItem: rawTotalItem,
        indexItem: props.indexItem,
        cantidadItem: new_cantidadItem,
        valor_total_item: data.valorItemUnitario * new_cantidadItem,
        daitem: data.daitem,
    });
}
// <!--</editor-fold>-->


// <!--<editor-fold desc="watchers y validacion">-->
const ValidarValorCero = (new_equipos) => {
    data.EquipsOnZero = false
    new_equipos.forEach((equipo) => {
        if (equipo.equipo_selec) {

            if (equipo.equipo_selec?.precio_de_lista == 0 || typeof (equipo.equipo_selec.precio_de_lista) === 'string') {
                // console.log("🚀 ~ ValidarValorCero ~ equipo.equipo_selec?.precio_de_lista: ", equipo.equipo_selec?.precio_de_lista);

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
// Watchers para comunicar cambios
watch(() => data.equipos, (new_equipos) => {
    ActualizarTotalEquipo(data.cantidadItem);
    ValidarValorCero(new_equipos)
}, {deep: true, immediate: true})


watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true})
// <!--</editor-fold>-->

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

    .no-print {
        display: none !important;
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