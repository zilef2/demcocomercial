<script setup>
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, ref, watchEffect} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import "vue-select/dist/vue-select.css";
import Newitem from "@/Pages/Item/Newitem.vue";
import CerrarYguardar from "@/Pages/Oferta/CerrarYguardar.vue";
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import Add_Sub_items from "@/Pages/Item/Add_Sub_items.vue";
import formOferta from "@/Pages/Oferta/formOferta.vue";
import {formatDate, formatPesosCol, number_format} from '@/global.ts';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import {usePage} from '@inertiajs/vue3'; // Importa usePage
const page = usePage(); // Obtén el objeto page
// --------------------------- ** -------------------------

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    titulos: Object, //parametros de la clase principal
    losSelect: Object,
    numberPermissions: Number,
    ultimoIdMasUno: Number,
})
const form = useForm({

    // codigo_oferta: '',
    // descripcion: '',
    // cargo: '',
    // empresa: '',
    // ciudad: '',
    // proyecto: '',
    // fecha: '',
    // user_id: '',
    dataOferta: {
        descripcion: '',
        cargo: 'ANALISTA DE OFERTA',
        empresa: 'ABC Corp',
        ciudad: 'Medellín',
        proyecto: 'XYZ Project',
    },
    equipos: [],
    items: [],
    valores_total_items: [],
    cantidadesItem: [],
    ultra_valor_total: 0,

})

const data = reactive({
    params: {
        pregunta: ''
    },
    mostrarDetalles: true,

})
onMounted(() => {
    form.items.push({equipo_selec: null, cantidad: 1});

    if (props.numberPermissions > 9) {

        // const valueRAn = Math.floor(Math.random() * (9) + 1)
        // form.nombre = 'nombre genenerico '+ (valueRAn);
        // form.codigo = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'


    }
});


watchEffect(() => {
    if (props.show) {
        // form.errors = {}
    }
})

function actualizarNumericamenteTotal() {
    form.ultra_valor_total = 0
    // console.table(form.valores_total_items)
    form.valores_total_items.forEach((valortotalitem) => {
        // console.log('foreach:: ' + valortotalitem)
        form.ultra_valor_total += valortotalitem || 0;
    });
    // console.log('total 2:: ' + form.ultra_valor_total)
}

//viene del hijo: Newitem.vue (updatiItems)
function actualizarValoresItems({equipos, valorItemUnitario, TotalItem, indexItem, cantidadItem, valor_total_item}) {

    form.equipos[indexItem] = equipos
    form.valorItemUnitario = valorItemUnitario
    form.TotalItem = TotalItem

    //peque validacion
    let totalvalidacion = 0
    equipos.forEach((equipo) => {
        if (equipo.equipo_selec) {
            totalvalidacion = equipo.cantidad * equipo.equipo_selec.precio_de_lista;
            if (totalvalidacion !== equipo.subtotalequip) {
                // console.log("🚀 ~ actualizarValoresItems ~ equipo.equipo_selec.precio_de_lista: ", equipo.equipo_selec);
                // console.log("🚀");
                // console.error('los3', equipo.cantidad, equipo.equipo_selec.precio_de_lista, equipo.subtotalequip)
            }
            // console.log('CCCant, precio y total', equipo.cantidad, equipo.equipo_selec.precio_de_lista, equipo.subtotalequip)
        }
    })

    if (indexItem >= form.valores_total_items.length) {
        form.valores_total_items.length = indexItem + 1;
    }
    form.cantidadesItem[indexItem] = cantidadItem;
    form.valores_total_items[indexItem] = valor_total_item || 0;

    actualizarNumericamenteTotal()
}

//cuando se añaden o quitan items
function actualizarItems(cantidad) {
    while (form.items.length < cantidad) {
        form.items.push({equipo_selec: null, cantidad: 1});
    }
    while (form.items.length > cantidad) {
        form.items.pop();
        form.valores_total_items.pop();
    }
    actualizarNumericamenteTotal()
}


// <!--<editor-fold desc="post form">-->
const vectoresNoNulos = [ //colocar los valores a validar por null frontend
    'items',
    'valores_total_items',
    'cantidadesItem'
];
const cadenasNoNulas = [ //colocar los valores a validar por null frontend
    'ultra_valor_total'
];

const formOfertaRef = ref(null);


function ValidarFormInicial() {
    if (!form.dataOferta.cargo || !form.dataOferta.empresa) {
        console.log("🚀.empresa: ", form.dataOferta.empresa);
        console.log("cargo: ", form.dataOferta.cargo);
        return false
    }
    return true
}

function ValidarVacios() {
    let result = true
    cadenasNoNulas.forEach(element => {
        if (!form[element]) {
            console.log("=>(Create.vue:70) falta esto papa element", element);
            result = false
            return result
        }
    });
    return result
}

function ValidarVectoresVacios() {
    vectoresNoNulos.forEach(element => {
        if (form[element]) {

            if (form[element].length === 0) {
                console.log("=>(Create.vue:70) el vector esta vacio = ", element);
                return false
            }
        } else {
            console.log("=>(Create.vue:70) el vector no existe = ", element);
            return false

        }
    });
    return true
}

const create = () => {
    console.log('ValidarVacios:: ', ValidarVacios());
    console.log('ValidarVectoresVacios:: ', ValidarVectoresVacios());
    console.log('ValidarFormInicial:: ', ValidarFormInicial());

    if (ValidarVacios() && ValidarVectoresVacios() && ValidarFormInicial()) {
        form.post(route('GuardarNuevaOferta'), {
            preserveScroll: true,
            onSuccess: () => {
                // emit("close")
                form.reset()
            },
            onError: () => null,
            onFinish: () => null,
        })
    } else {
        console.log('Hay campos vacios')
    }
}

// <!--</editor-fold>-->

</script>

<template>
    <section class="space-y-6">
        <div v-if="data.mostrarDetalles" class="flex justify-center mt-6 mb-2">
            <img src="/demco-logo-ultimo.png" alt="Logo Demco" class="h-12"/>
        </div>
        <form @submit.prevent="create" class="px-16 py-1 2xl:px-36 2xl:pb-2 print-container">
            
            <div v-if="data.mostrarDetalles" class="flex flex-col text-center w-full mb-1">
                <!--                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900 uppercase">Oferta # {{props.ultimoIdMasUno}}</h1>-->
                <!--                <p v-if="data.mostrarDetalles" class="lg:w-2/3 mx-auto leading-relaxed text-base no-print">-->
                <!--                    Agrege tantos items necesite para la oferta-->
                <!--                </p>-->
            </div>

            <formOferta
                :textoIntroducturio="textoIntroducturio"
                v-model="form.dataOferta"
                class=" no-print"
            />

            <Add_Sub_items
                :initialItems="form.items.length"
                @updateItems="actualizarItems"
                class=" no-print"
            />

            <Newitem
                v-for="(item, indexItem) in form.items" :key="indexItem"
                :valorUnitario="item.equipo_selec?.Valor_Unit ?? 0"
                :initialCantidad="item.cantidad ?? 1"
                :indexItem="indexItem"
                :losSelect="losSelect"
                :mostrarDetalles="data.mostrarDetalles"
                @updatiItems="actualizarValoresItems"

            />

            <Add_Sub_items v-if="form.items.length > 2"
                           :initialItems="form.items.length"
                           @updateItems="actualizarItems"
                           class=" no-print"
            />


            <section class="text-gray-600 body-font">
                <div class="container mx-auto">
                    <div
                        class="flex flex-col text-center mx-auto w-full max-w-[300px] bg-white py-4 mt-12 mb-20 rounded-xl border border-collapse border-green-400">
                        <h1 class="sm:text-xl text-lg font-medium title-font mb-4 text-gray-900">
                            Valor total de la oferta
                        </h1>
                        <p class="text-2xl lg:w-2/3 mx-auto leading-relaxed">
                            {{ number_format(form.ultra_valor_total, 0, 1) }}</p>
                    </div>
                </div>
            </section>
            <hr class="border-[1px] border-black my-8 col-span-full"/>
            <div class="flex justify-center text-center my-4">

                <PrimaryButton type="button"
                               class="px-4 py-2  rounded-2xl no-print"
                               @click="data.mostrarDetalles = !data.mostrarDetalles">
                    Alternar detalles
                </PrimaryButton>
            </div>


            <CerrarYguardar
                :ruta="'Oferta.index'" :formProcessing="form.processing" @create="create"
                class=" no-print"
            />

            <h2 class="mx-12 text-center text-2xl font-medium text-gray-900 dark:text-gray-100 mt-36 no-print">
                Últimas actualizaciones de equipos (Sin precio de lista)
            </h2>
            <!--            la tabla de actualizaciones-->
            <div class="w-full my-8 px-2 2xl:px-16 max-h-[330px] overflow-y-scroll no-print">
                <div class="overflow-x-scroll">
                    <table class="w-full divide-y-2 divide-gray-200">
                        <thead class="ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white">
                            <th class="px-3 py-2 whitespace-nowrap">Código</th>
                            <th class="px-3 py-2 whitespace-normal">Descripción</th>
                            <th class="px-3 py-2 whitespace-nowrap">Precio de Lista</th>
                            <th class="px-3 py-2 whitespace-nowrap">Tipo Fabricante</th>
                            <th class="px-3 py-2 whitespace-nowrap">Referencia Fabricante</th>
                            <th class="px-3 py-2 whitespace-nowrap">Marca</th>
                            <th class="px-3 py-2 whitespace-nowrap">Unidad de Compra</th>
                            <th class="px-3 py-2 whitespace-nowrap">Última Actualización</th>
                        </tr>
                        </thead>

                        <tbody v-for="(equipo,index) in props.losSelect?.ultimosEquipos" :key="index"
                               class="divide-y divide-gray-200">
                        <tr
                            class="*:text-gray-900 first:sticky first:left-0 first:bg-white first:font-medium
                             hover:bg-red-300 hover:dark:bg-gray-900/20"
                            :class="index % 2 === 0 ? 'bg-gray-200' : 'bg-white'"
                        >
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.codigo }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.descripcion }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{
                                    number_format(equipo['precio_de_lista'], 0, 1)
                                }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['tipo_fabricante'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['referencia_fabricante'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['marca'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['unidad_de_compra'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ formatDate(equipo['fecha_actualizacion']) }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <CerrarYguardar
                :ruta="'Oferta.index'"
                :formProcessing="form.processing"
                @create="create"
                class=" no-print"
            />

        </form>
    </section>
</template>
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