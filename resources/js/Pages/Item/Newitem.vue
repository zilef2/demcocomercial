<template>
    <!--    <h2 class="mt-6 mb-2 hover:bg-green-300/25 text-3xl text-center mx-auto py-2 font-medium text-gray-900 dark:text-gray-100">-->
    <!--        Item N° {{ indexItem + 1 }}-->
    <!--    </h2>-->

    <div
        class="text-3xl text-center mx-auto mt-6 mb-2 relative drop-shadow-xl w-64 h-12 overflow-hidden rounded-xl bg-gray-800">
        <div
            class="absolute flex items-center justify-center text-white z-[1] opacity-90 rounded-xl inset-0.5 bg-gray-800">
            Item N° {{ indexItem + 1 }}
        </div>
        <div class="absolute w-56 h-48 bg-white blur-[50px] -left-1/2 -top-1/2"></div>
    </div>
    <div>
        <Add_Sub_equipos v-if="props.mostrarDetalles" :initialEquipos="data.equipos.length"
                         @updatEquipos="actualizarEquipos"
                         class="no-print"
        />


        <div class="my-2 overflow-visible rounded border border-gray-300 shadow-sm print-container">
            <table class="min-w-full divide-y-2 divide-gray-200">
                <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900 bg-gray-900 text-white">
                    <th class="px-3 py-2 whitespace-nowrap">#</th>
                    <th class="px-3 py-2 mx-2 whitespace-nowrap min-w-[500px]">Código</th>
                    <th class="px-3 py-2 whitespace-nowrap">Valor Unitario</th>
                    <th class="px-3 py-2 whitespace-nowrap">Cantidad</th>
                    <th class="px-3 py-2 whitespace-nowrap">Total Equipo:</th>
                </tr>
                </thead>

                <tbody v-for="(equipo, index) in data.equipos" :key="index"
                       class="divide-y divide-gray-200">
                <tr class="*:text-gray-900 *:first:font-medium">
                    <td class="px-3 py-2 whitespace-nowrap">
                        Equipo {{ index + 1 }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap min-w-[500px]">
                        <vSelect
                            :options="props.losSelect['Equipo']"
                            v-model="data.equipos[index].equipo_id"
                            label="title"
                            class="print:hidden mt-1 block w-full min-w-[500px] fixed"
                        />
                        <div class="hidden print:block text-sm">
                            {{ data.equipos[index]?.equipo_id?.title ?? 'Sin selección' }}
                        </div>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
                        {{ data.equipos[index]?.equipo_id ? number_format(data.equipos[index]?.equipo_id.Precio_de_Lista, 0, 1) : 'Sin valor' }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
<!--                        <input-->
<!--                            type="number"-->
<!--                            v-model.number="data.equipos[index].cantidad"-->
<!--                            class="print:hidden max-w-[120px] border-white dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block w-full"-->
<!--                        />-->
                        <p class="print:flex mx-auto text-center">
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
                                   class="mt-1 block w-1/3"
                                   v-model.number="data.cantidadItem"
                                   required
                                   :placeholder="lang().placeholder.cantidad"
                        />
                    </th>
                    <th class="px-3 py-2 whitespace-nowrap">{{ formattedTotalItem }}</th>
                </tr>

            </table>
        </div>

        <!--            <InputError class="mt-2"/>-->

    </div>


    <Add_Sub_equipos v-if="data.equipos.length > 6 && props.mostrarDetalles"
                     :initialEquipos="data.equipos.length"

                     @updatEquipos="actualizarEquipos"
                     class="no-print"
    />

</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {reactive, watch, computed} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import Menudropdown from "@/Pages/Item/Menudropdown.vue";
import {formatPesosCol, number_format} from '@/global.ts';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

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
    subtotal: 0,
    equipos: [
        {equipo_id: null, cantidad: 1, subtotalequip: 0}
    ],
    valorItemUnitario: 0,
    cantidadItem: 1,
    valorItemtotal: 0,
}, {deep: true})

//para el padre
function actualizarEquipos(cantidad) {
    if (cantidad < 0) cantidad = 0;
    while (data.equipos.length < cantidad) {
        data.equipos.push({equipo_id: null, cantidad: 1, subtotalequip: 0});
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
// const formattedTotalItem = computed(() => {
//     if (!data.valorItemUnitario || !data.cantidadItem) return "";
//     return formatPesosCol(data.valorItemUnitario * data.cantidadItem);
// });


function ActualizarTotalEquipo(new_cantidadItem) {
    data.valorItemUnitario = 0;
    data.equipos.forEach((equipo) => {
        if (equipo.equipo_id) {
            equipo.subtotalequip = equipo.cantidad * equipo.equipo_id.Precio_de_Lista;
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

// Watchers para comunicar cambios
watch(() => data.equipos, (new_equipos) => {
    ActualizarTotalEquipo(data.cantidadItem);
}, {deep: true})
watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, {deep: true})

</script>
<style>
@media print {
    body {
        font-size: 10px !important; /* Tamaño general más pequeño */
    }

    table {
        width: 100% !important;
        font-size: 9px !important; /* Texto de tabla más compacto */
    }

    th, td {
        padding: 2px 4px !important; /* Reduce espacios dentro de celdas */
        white-space: normal !important; /* Permite que el texto haga salto de línea */
    }

    select,
    input,
    .v-select,
    .v-select .dropdown-toggle {
        font-size: 9px !important;
        padding: 2px !important;
    }

    .no-print {
        display: none !important; /* Oculta botones o secciones innecesarias */
    }

    .print-container {
        zoom: 0.75; /* Escala visual general */
        margin: 0 !important;
    }
}
</style>