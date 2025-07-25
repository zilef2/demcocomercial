<script setup>
import {useForm} from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import '@vuepic/vue-datepicker/dist/main.css'
import "vue-select/dist/vue-select.css";
import EditItem from "@/Pages/Item/EditItem.vue";
import CerrarYguardar from "@/Pages/Oferta/CerrarYguardar.vue";
import Add_Sub_items from "@/Pages/Item/Add_Sub_items.vue";
import formOfertaEdit from "@/Pages/Oferta/formOfertaEdit.vue";
import {pushObj, popObj, number_format} from '@/global.ts';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ErroresNuevaOferta from '@/Components/errores/ErroresNuevaOferta.vue';
import {forEach} from "lodash";
import {watchEffect, computed, onMounted, reactive, watch, nextTick} from 'vue';

// --------------------------- ** -------------------------


// <!--<editor-fold desc="abuelos : props form y data">-->
const props = defineProps({
    numberPermissions: Number,
    ultimoIdMasUno: Number,
    oferta: Object,
})
const form = useForm({

    dataOferta: {
        codigo_oferta: '',
        descripcion: '',
        cargo: '',
        empresa: '',
        ciudad: '',
        proyecto: '',
    },
    equipos: [], // Array de equipos independiente de los items
    daItems: [], // Array de items, por ejemplo el item 1 esta en daItems[0]
    valores_total_items: [],
    cantidadesItem: [],
    ultra_valor_total: 0,

})

const data = reactive({
    params: {
        pregunta: ''
    },
    isReady: false, // <--- 1. Bandera de control
    mostrarDetalles: true,

    EquipsOnZero: false,
    CallOnce_Plantilla: true,
    hijosZeroFlags: [],
    factores: [
        {title: 'Factor Suministro', value: 1.33},
        {title: 'Factor MT', value: 1.5},
        {title: 'Factor BT', value: 1.6},
        {title: 'Factor Cobre', value: 1.55},
        {title: 'Factor por Ingenieria Adicional', value: 1},
    ],
    factorSeleccionado: 1,
}, {deep: true})
// <!--</editor-fold>-->

onMounted(() => {
    // Initialize form.daItems, form.equipos, etc., based on props.oferta.items
    form.daItems = props.oferta.items.map(item => ({
        nombre: item.nombre,
        descripcion: item.descripcion,
    }));

    form.equipos = props.oferta.items.map(item => {
        if (item.equipos && item.equipos.length > 0) {
            return item.equipos.map(equipo => {
                const equipo_selec = {
                    value: equipo.pivot.codigoGuardado,
                    label: `${equipo.codigo} - ${equipo.descripcion}`,
                    precio_de_lista: equipo.pivot.precio_de_lista,
                    descuento_basico: equipo.pivot.descuento_basico,
                    descuento_proyectos: equipo.pivot.descuento_proyectos,
                    alerta_mano_obra: equipo.pivot.alerta_mano_obra,
                    pivot: equipo.pivot
                };
                return {
                    equipo_selec: equipo_selec,
                    nombre_item: item.nombre,
                    cantidad: equipo.pivot.cantidad_equipos,
                    factor_final: equipo.pivot.factor,
                    descuento_final: equipo.pivot.descuento_final,
                    costounitario: parseFloat(equipo.pivot.costo_unitario),
                    costototal: parseFloat(equipo.pivot.costo_total),
                    valorunitario: parseFloat(equipo.pivot.valorunitarioequip),
                    subtotalequip: parseFloat(equipo.pivot.subtotalequip),
                };
            });
        }
        return []; // Return an empty array if no equipment
    });

    form.cantidadesItem = props.oferta.items.map(item => item.cantidad);
    form.valores_total_items = props.oferta.items.map(item => parseFloat(item.valor_total_item));

    actualizarNumericamenteTotal();
    data.isReady = true;
});


// <!--<editor-fold desc="Watchers">-->

// watchEffect(() => {})

// <!--</editor-fold>-->


// <!--<editor-fold desc="Padres e hijos">-->

function actualizarNumericamenteTotal() {
    nextTick();
    form.ultra_valor_total = 0
    form.valores_total_items.forEach((valortotalitem) => {
        form.ultra_valor_total += valortotalitem || 0;
    });
}

function actualizarValoresItems({
                                    equipos,
                                    valorItemUnitario,
                                    TotalItem,
                                    indexItem,
                                    cantidadItem,
                                    valor_total_item,
                                    daitem
                                }) {

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
        form.daItems.push({nombre: '', descripcion: ''}); // Inicializar con propiedades básicas
        form.equipos.push([]); // Inicializar como un array vacío para los equipos del nuevo ítem
        data.hijosZeroFlags.push(false); // Inicializar con un valor booleano
        form.valores_total_items.push(0); // Inicializar con 0
        form.cantidadesItem.push(1); // Inicializar con 1
    }
    while (form.daItems.length > cantidad) {
        form.daItems.pop();
        form.equipos.pop();
        data.hijosZeroFlags.pop();
        form.valores_total_items.pop();
        form.cantidadesItem.pop();
    }
    actualizarNumericamenteTotal()
    data.CallOnce_Plantilla = false
}

// <!--</editor-fold>-->


// <!--<editor-fold desc="funciones visuales">-->
//funcion que controla si hay boton de guardar o no
function actualizarEquipsOnZero({index, isZero}) {
    data.hijosZeroFlags[index] = isZero;
    data.EquipsOnZero = Object.values(data.hijosZeroFlags).includes(true);
}

function scrollToValorNulo() {
    if (props.numberPermissions > 9) setPrecioLista()
    const elements = document.querySelectorAll('[id^="valor-nulo"]');
    if (elements.length === 0) {
        window.scrollTo(0, document.body.scrollHeight);
        return;
    }
    for (const el of elements) {

        if (el.offsetParent !== null) { // visibilidad real
            el.scrollIntoView({behavior: 'smooth', block: 'center'});
            break;
        }
    }
}

function scrollToNextItem2() { //para estudio
    // Busca el siguiente elemento con id="itemN{currentIndex+1}"
    const nextEl = document.getElementById('itemN' + 1);
    if (nextEl && nextEl.offsetParent !== null) { // visible
        nextEl.scrollIntoView({behavior: 'smooth', block: 'center'});
    }
}

function scrollToNextItem() {
    const elements = Array.from(document.querySelectorAll('[id^="itemN"]'));
    let lastVisibleIndex = -1;
    const windowHeight = window.innerHeight;

    elements.forEach((el, i) => {
        const rect = el.getBoundingClientRect();
        // Considera visible si al menos parte está en viewport
        if (rect.bottom > 0 && rect.top < windowHeight) {
            lastVisibleIndex = i;
        }
    });

    if (lastVisibleIndex >= 0 && lastVisibleIndex < elements.length - 1) {
        elements[lastVisibleIndex + 1].scrollIntoView({behavior: 'smooth', block: 'center'});
    }
}

function scrollToPreviousItem() {
    const elements = Array.from(document.querySelectorAll('[id^="itemN"]'));
    let lastVisibleIndex = -1;
    const windowHeight = window.innerHeight;

    elements.forEach((el, i) => {
        const rect = el.getBoundingClientRect();
        // Considera visible si al menos parte está en viewport
        if (rect.bottom > 0 && rect.top < windowHeight) {
            lastVisibleIndex = i;
        }
    });

    if (lastVisibleIndex >= 0 && lastVisibleIndex < elements.length - 1 && lastVisibleIndex > 0) {
        elements[lastVisibleIndex - 1].scrollIntoView({behavior: 'smooth', block: 'center'});
    } else {
        window.scrollTo(0, 0);
    }
}

function setPrecioLista() { //quenotaparce
    forEach(form.equipos, (item) => {
        forEach(item, (equipo) => {
            if (equipo && equipo.equipo_selec &&
                (equipo.equipo_selec.precio_de_lista == 0 || equipo.equipo_selec.precio_de_lista == null)) {
                equipo.equipo_selec.precio_de_lista = 111; // Asignar un valor de ejemplo
            }
        });
    });
}

// <!--</editor-fold>-->

// <!--<editor-fold desc="post form">-->

const vectoresNoNulos = [ //colocar los valores a validar por null frontend
    'daItems',
    'valores_total_items',
    'cantidadesItem'
];

const cadenasNoNulas = [
    'ultra_valor_total'
];


const ValidarFormInicial = () => !(!form.dataOferta.cargo || !form.dataOferta.empresa);

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
    if (ValidarVacios() && ValidarVectoresVacios() && ValidarFormInicial()) {
        form.post(route('GuardarEditOferta'), {
            preserveScroll: true,
            onSuccess: () => {
                // emit("close")
                // form.reset()
            },
            onError: () => null,
            onFinish: () => null,
        })
    } else {
        alert('Hay campos vacios')
    }
}

// <!--</editor-fold>-->
</script>


<template>
    <Toast :flash="$page.props.flash"/>
    <button
        @click="scrollToValorNulo"
        class="fixed top-4 left-4 z-50 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-3 rounded-full shadow-lg"
        aria-label="Ir a Valor nulo!"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"/>
        </svg>
    </button>
    <button
        @click="scrollToNextItem"
        class="fixed top-24 left-4 z-50 bg-amber-500 hover:bg-orange-700 text-white font-bold py-3 px-3 rounded-full shadow-lg"
        aria-label="Siguiente item"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"/>
        </svg>
    </button>
    <button
        @click="scrollToPreviousItem"
        class="fixed top-4 right-4 z-50 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-3 rounded-full shadow-lg"
        aria-label="Anterior item"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"/>
        </svg>
    </button>


    <section class="space-y-3">
        <div v-if="data.mostrarDetalles" class="flex justify-center mt-6 mb-2">
            <img src="/demco-logo-ultimo.png" alt="Logo Demco" class="h-12"/>
        </div>
        <form @submit.prevent="create" class="px-6 py-1 2xl:px-10 2xl:py-8">

            <formOfertaEdit
                v-model="form.dataOferta"
                :dataOferta="props.oferta"
                class=" no-print"
            />

            <!--            factores-->
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-6 p-4">
                <div
                    v-for="(factor, indexfac) in data.factores"
                    :key="indexfac"
                    class="relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out overflow-hidden"
                >
                    <div
                        :class="{ 'bg-indigo-100' : indexfac == data.factorSeleccionado - 1 }"
                        class="p-4">
                        <label :for="`factor-input-${indexfac}`"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ factor.title }}
                        </label>
                        <input
                            :id="`factor-input-${indexfac}`"
                            type="text"
                            v-model="data.factores[indexfac].value"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                               text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700
                               placeholder-gray-400 dark:placeholder-gray-500
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            :placeholder="`Ingresa ${factor.title.toLowerCase()}`"
                        />
                    </div>
                </div>

                <div
                    class="col-span-1 relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out overflow-hidden">
                    <div class="p-4">
                        <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Factor seleccionado
                        </label>
                        <input
                            type="number" min=0 max=5
                            v-model.number="data.factorSeleccionado"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                               text-base text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700
                               placeholder-gray-400 dark:placeholder-gray-500
                               focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        />
                    </div>
                </div>
            </div>

            <template v-if="data.isReady"> <!-- 2. Envolver los componentes -->
                <Add_Sub_items
                    :initialItems="form.daItems.length"
                    @updateItems="actualizarItems"
                    class=" no-print"
                />

                <EditItem
                    v-for="(item, indexItem) in form.daItems" :key="indexItem"
                    :item="{
                        ...item,
                        equipos: form.equipos[indexItem],
                        cantidad: form.cantidadesItem[indexItem]
                    }"
                    :indexItem="indexItem"

                    :equipos="form.equipos[indexItem]"
                    :pivot="form.equipos[indexItem]"

                    :CallOnce_Plantilla="data.CallOnce_Plantilla"
                    :factores="data.factores"
                    :factorSeleccionado="data.factorSeleccionado"
                    :mostrarDetalles="data.mostrarDetalles"
                    :plantilla="props.plantilla"


                    @updatiItems="actualizarValoresItems"
                    @checkzero="actualizarEquipsOnZero"
                    class="mb-4"
                />
                <ErroresNuevaOferta :errors=Object.values($page.props.errors)></ErroresNuevaOferta>
                <Add_Sub_items
                    :initialItems="form.daItems.length"
                    @updateItems="actualizarItems"
                    class=" no-print text-center mx-auto w-fit"
                />
            </template>


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
                            class=" no-print mb-20 pb-10"
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