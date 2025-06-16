<template>
    <!--    <h2 class="mt-6 mb-2 hover:bg-green-300/25 text-3xl text-center mx-auto py-2 font-medium text-gray-900 dark:text-gray-100">-->
    <!--        Item N° {{ indexItem + 1 }}-->
    <!--    </h2>-->

    <div v-if="props.mostrarDetalles"
        class="text-3xl text-center mx-auto mt-6 mb-2 relative drop-shadow-xl w-64 h-12 overflow-hidden rounded-xl bg-gray-800">
        <div
            class="absolute flex items-center justify-center text-white z-[1] opacity-90 rounded-xl inset-0.5 bg-gray-800">
            Item N° {{ indexItem + 1 }}
        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>
    <div class="hover:border-x-[4px] border-indigo-300 dark:border-indigo-700 rounded-xl p-4 mb-6">
       
        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>


        <div class="xs:max-w-[900px] md:max-w-[1600px] mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 print-container">
            <table class="min-w-full divide-y-2 divide-gray-200">
                <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium dark:text-gray-900 bg-gray-900
                 text-white shadow-md 
                 rounded-xl">
                    <th class="px-3 py-2 whitespace-nowrap rounded-l-2xl">#</th>
                    <th class="px-3 py-2 mx-2 whitespace-nowrap min-w-[500px]">Código</th>
                    <th class="px-3 py-2 whitespace-nowrap">Valor Unitario</th>
                    <th class="px-3 py-2 whitespace-nowrap">Cantidad</th>
                    <th class="px-3 py-2 whitespace-nowrap rounded-r-2xl">Total Equipo:</th>
                </tr>
                </thead>

                <tbody v-for="(equipo, index) in data.equipos" :key="index"
                       class="divide-y divide-gray-200">
                <tr class="*:text-gray-900 *:first:font-medium">
                    <td class="px-3 py-2 whitespace-nowrap">
                        Equipo {{ index + 1 }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap min-w-[500px]">
                        <!--                           <vSelect-->
                        <!--                               :options="props.losSelect['Equipo']"-->
                        <!--                               v-model="data.equipos[index].equipo_selec"-->
                        <!--                               label="title"-->
                        <!--                               class="print:hidden mt-1 block w-full min-w-[500px] fixed" append-to-body-->
                        <!--                           />-->

                        
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
                    <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0" class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        {{ data.equipos[index]?.equipo_selec ?
                            number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor' }}
                    </td>
                    <td v-else class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        <input 
                                type="number"
                                v-model.number="data.equipos[index].equipo_selec.precio_de_lista"
                                class="no-print max-w-[120px] border-white dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"
                            />
                        <div class="hidden print:block text-sm">
                            {{ data.equipos[index]?.equipo_selec?.precio_de_lista }}
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                            <input 
                                type="number"
                                v-model.number="data.equipos[index].cantidad"
                                class="no-print max-w-[120px] border-white dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"
                            />
                        <p class="print mx-auto text-center">
                            {{ data.equipos[index].cantidad }}
                        </p>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">{{ data.equipos[index].subtotalequip }}</td>
                </tr>
                </tbody>
                <tr class="text-gray-900 text-xl">
                    <th class="px-3 py-2 whitespace-nowrap">-</th>
                    <th class="px-3 py-2 whitespace-nowrap">-</th>
                    <th class="px-3 py-2 whitespace-nowrap">{{ number_format(data.valorItemUnitario, 0, 1) }}</th>
                    <th class="px-3 py-2 whitespace-nowrap">
                        <TextInput type="number"
                                   class="min-w-[40px] max-w-[80px] pl-4 border rounded-xl"
                                   v-model.number="data.cantidadItem"
                                   required
                                   :placeholder="lang().placeholder.cantidad"
                        />
                    </th>
                    <th class="px-3 py-2 whitespace-nowrap">{{ formattedTotalItem }}</th>
                </tr>
            </table>
        </div>
        
        <input-error v-if="data.EquipsOnZero" message="Hay equipos sin precio"></input-error>
         <Add_Sub_equipos v-if="props.mostrarDetalles && !data.EquipsOnZero" :initialEquipos="data.equipos.length"
                         @updatEquipos="actualizarEquipos"
                         class="no-print mx-36 mt-4 mb-10"
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
        console.log("🚀 ~ buscarEquipos ~ data.equiposOptions: ", data.equiposOptions);
    } catch (error) {
        console.error('Error al buscar equipos:', error);
    }
}, 300);


// --------------------------- ** -------------------------
const emit = defineEmits(['updatiItems']);

const props = defineProps({

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
    losSelect: Object,
    mostrarDetalles: true,
});


const data = reactive({
    equiposOptions: [],
    searchEquipo: '',
    subtotal: 0,
    equipos: [
        {equipo_selec: null, cantidad: 1, subtotalequip: 0}
    ],
    valorItemUnitario: 0,
    cantidadItem: 1,
    valorItemtotal: 0,
    EquipsOnZero: false
    
}, {deep: true})

onMounted(() => {
    // data.equiposOptions.value = [{title: 'Selecciona un Equipo', value: 0}];

    data.equipos[0].equipo_selec = {
        precio_de_lista: 123,
        precio_de_lista2: 0,
        title: "29196 - DPS Tipo II 110 KA 8/20, Vp<1400 VAC 3F 335 VAC CON SEÑALIZACION",
        value: 9034
    };
});

//para el padre
function actualizarEquipos(cantidad) {
    if (cantidad < 0) cantidad = 0;
    while (data.equipos.length < cantidad) {
        data.equipos.push({equipo_selec: null, cantidad: 1, subtotalequip: 0});
    }
    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }
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
        valor_total_item: data.valorItemUnitario * new_cantidadItem
    });
}


const ValidarValorCero = (new_equipos) => {
    data.EquipsOnZero = false
    new_equipos.forEach((equipo)=>{
        if(equipo.equipo_selec?.precio_de_lista == 0){
          console.log("🚀 ~ ValidarValorCero ~ equipo.equipo_selec?.precio_de_lista: ", equipo.equipo_selec?.precio_de_lista);
            
            data.EquipsOnZero = true
        } 
    })
};
// Watchers para comunicar cambios
watch(() => data.equipos, (new_equipos) => {
    ActualizarTotalEquipo(data.cantidadItem);
    ValidarValorCero(new_equipos)
}, {deep: true})


watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true})

</script>
<style>
/* 👇 Oculta elementos con clase .print en pantalla */
.print {
    display: none;
}

/* 👇 Reglas para impresión */
@media print {
    body {
        font-size: 10px !important;
    }

    table {
        width: 100% !important;
        font-size: 9px !important;
    }

    th, td {
        padding: 2px 4px !important;
        white-space: normal !important;
    }

    select,
    input,
    .v-select,
    .v-select .dropdown-toggle {
        font-size: 9px !important;
        padding: 2px !important;
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