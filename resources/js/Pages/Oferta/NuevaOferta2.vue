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
import ErroresNuevaOferta from '@/Components/errores/ErroresNuevaOferta.vue';
import {usePage} from '@inertiajs/vue3'; // Importa usePage
import {rellenarDemoOfertaSuper} from '@/Pages/Oferta/Plantillacontroller';

const page = usePage(); // Obtén el objeto page
// --------------------------- ** -------------------------


// <!--<editor-fold desc="props - form y data">-->
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

    dataOferta: {
        codigo_oferta: 'CD250',
        descripcion: 'DEMCO INGENIERÍA, es una empresa dinámica dedicada al diseño, construcción y puesta en servicio de subestaciones y tableros eléctricos en media y baja tensión, desarrollando proyectos con altas especificaciones en ingeniería, en alianza con reconocidas empresas del sector eléctrico. Entregamos a nuestros clientes soluciones completas e integrales respaldados por procesos de ingeniería y automatización, ágiles y con importantes alianzas con reconocidas empresas del sector. Somos una empresa Colombiana con proyección hacia el futuro, contamos con productos de calidad, precios competitivos, recurso humano calificado, capacidad operativa y respuesta oportuna a nuestros cliente.',
        cargo: 'ANALISTA DE OFERTA',
        empresa: '',
        ciudad: '',
        proyecto: '',
    },
    equipos: [],
    daItems: [],
    valores_total_items: [],
    cantidadesItem: [],
    ultra_valor_total: 0,

})

const data = reactive({
    params: {
        pregunta: ''
    },
    mostrarDetalles: true,
    
    EquipsOnZero: false,
    hijosZeroFlags: {},
}, {deep: true})
    // <!--</editor-fold>-->


onMounted(() => {
    
    if (props.numberPermissions > 9) {
       rellenarDemoOfertaSuper(form);
        // Object.assign(form.dataOferta, generarDataOfertaDemo());
        form.dataOferta.empresa = 'empresa ejemplo'
        form.dataOferta.ciudad = 'ciudad ejemplo'
        form.dataOferta.proyecto = 'proyecto ejemplo'
    }
});


watchEffect(() => {
    if (props.show) {
        // form.errors = {}
    }
})


// <!--<editor-fold desc="muchas funciones">-->
function actualizarNumericamenteTotal() {
    form.ultra_valor_total = 0
    // console.table(form.valores_total_items)
    form.valores_total_items.forEach((valortotalitem) => {
        form.ultra_valor_total += valortotalitem || 0;
    });
}

//viene del hijo: Newitem.vue (updatiItems)
function actualizarValoresItems({equipos, valorItemUnitario, TotalItem, indexItem, cantidadItem, valor_total_item,daitem}) {

    form.daItems[indexItem] = daitem || {equipo_selec: null, cantidad: 1};
    form.equipos[indexItem] = equipos
    form.valorItemUnitario = valorItemUnitario
    form.TotalItem = TotalItem

    //peque validacion
    let totalvalidacion = 0
    equipos.forEach((equipo) => {
        if (equipo.equipo_selec) {
            totalvalidacion = equipo.cantidad * equipo.equipo_selec.precio_de_lista;
            if (totalvalidacion !== equipo.subtotalequip) {
                console.warn("🚀 ~ actualizarValoresItems ~ equipo.equipo_selec.precio_de_lista: ", equipo.equipo_selec);
            }
        }
    })

    if (indexItem >= form.valores_total_items.length) {
        form.valores_total_items.length = indexItem + 1;
    }
    form.cantidadesItem[indexItem] = cantidadItem;
    form.valores_total_items[indexItem] = valor_total_item || 0;

    actualizarNumericamenteTotal() /* form.ultra_valor_total form.valores_total_items*/
}

//cuando se añaden o quitan items
function actualizarItems(cantidad) {
    while (form.daItems.length < cantidad) {
        form.daItems.push({equipo_selec: null, cantidad: 1});
    }
    while (form.daItems.length > cantidad) {
        form.daItems.pop();
        form.valores_total_items.pop();
    }
    actualizarNumericamenteTotal()
}
// <!--</editor-fold>-->

//funcion que controla si hay boton de guardar o no
function actualizarEquipsOnZero({ index, isZero }) {
    data.hijosZeroFlags[index] = isZero;
    console.log("🚀 ~ actualizarEquipsOnZero ~ data.hijosZeroFlags: ", data.hijosZeroFlags);
    data.EquipsOnZero = Object.values(data.hijosZeroFlags).includes(true);
}
// <!--<editor-fold desc="post form">-->

const vectoresNoNulos = [ //colocar los valores a validar por null frontend
    'daItems',
    'valores_total_items',
    'cantidadesItem'
];

const cadenasNoNulas = [
    'ultra_valor_total'
];

const formOfertaRef = ref(null);



function ValidarFormInicial() {
    if (!form.dataOferta.cargo || !form.dataOferta.empresa) {
        return false
    }
    return true
}

function ValidarVacios() {
    let result = true
    cadenasNoNulas.forEach(element => {
        if (!form[element]) {
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
                return false
            }
        } else {
            return false

        }
    });
    return true
}

const create = () => {
    console.log('Vacios:: ', ValidarVacios());
    console.log('VectoresVacios:: ', ValidarVectoresVacios());
    console.log('FormInicial:: ', ValidarFormInicial());

    if (ValidarVacios() && ValidarVectoresVacios() && ValidarFormInicial()) {
        form.post(route('GuardarNuevaOferta'), {
            preserveScroll: true,
            onSuccess: () => {
                // emit("close")
                // form.reset()
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
                :initialItems="form.daItems.length"
                @updateItems="actualizarItems"
                class=" no-print"
            />

            <Newitem
                v-for="(item, indexItem) in form.daItems" :key="indexItem"
                :valorUnitario="item.equipo_selec?.Valor_Unit ?? 0"
                :initialCantidad="item.cantidad ?? 1"
                :daitem="item"
                :indexItem="indexItem"
                :losSelect="losSelect"
                :mostrarDetalles="data.mostrarDetalles"
                @updatiItems="actualizarValoresItems"
                @checkzero="actualizarEquipsOnZero"
                class="grid grid-cols-2 gap-4 mb-4"
            />
            <ErroresNuevaOferta :errors =Object.values($page.props.errors) />
            <Add_Sub_items v-if="form.daItems.length > 2"
                           :initialItems="form.daItems.length"
                           @updateItems="actualizarItems"
                           class=" no-print text-center mx-auto w-fit"
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

            <CerrarYguardar v-if="!data.EquipsOnZero"
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
            <CerrarYguardar v-if="!data.EquipsOnZero"
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