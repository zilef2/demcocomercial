<script setup>
import {useForm} from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
import '@vuepic/vue-datepicker/dist/main.css'
import "vue-select/dist/vue-select.css";
import Newitem from "@/Pages/Item/Newitem.vue";
import CerrarYguardar from "@/Pages/Oferta/CerrarYguardar.vue";
import Add_Sub_items from "@/Pages/Item/Add_Sub_items.vue";
import formOferta from "@/Pages/Oferta/formOferta.vue";
import {number_format} from '@/global.ts';
import ErroresNuevaOferta from '@/Components/errores/ErroresNuevaOferta.vue';
import {forEach} from "lodash";
import {onMounted, reactive, nextTick} from 'vue';

//perate
import {deleteItemCommun} from '../Item/commonFunctionsItem';
import SwitchDarkModeNavbar from "@/Components/SwitchDarkModeNavbar.vue";

// --------------------------- ** -------------------------
let itemIdCounter = 0;

// <!--<editor-fold desc="abuelos : props form y data">-->
const props = defineProps({
    numberPermissions: Number,
    plantilla: Number, //se planea usar varias plantillas para el futuro (22jul)
    ultimaCD: Number, //codigo_oferta generado autoincremental
    theuser: Object,
    dataccobre: Object,
})

const form = useForm({
    dataOferta: {
        cliente: '',
        codigo_oferta: 'CD' + props.ultimaCD,
        descripcion: 'DEMCO INGENIERÍA, es una empresa dinámica dedicada al diseño, construcción y puesta en servicio de subestaciones y tableros eléctricos en media y baja tensión, desarrollando proyectos con altas especificaciones en ingeniería, en alianza con reconocidas empresas del sector eléctrico. Entregamos a nuestros clientes soluciones completas e integrales respaldados por procesos de ingeniería y automatización, ágiles y con importantes alianzas con reconocidas empresas del sector. Somos una empresa Colombiana con proyección hacia el futuro, contamos con productos de calidad, precios competitivos, recurso humano calificado, capacidad operativa y respuesta oportuna a nuestros cliente.',
        cargo: '',
        empresa: '',
        ciudad: 'Medellín',
        proyecto: '',
    },
    items: [], //definee_1A =>> actualizarItems
    ultra_valor_total: 0,
});

/*
 items  @type {Array<{
   *   id: number,
   *   nombre: string,
   *   cantidad: number,
   *   valor_total: number,
   *   equipos: Array<any> 
   * }>} 
 */

const data = reactive({
    params: {
        pregunta: ''
    },
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
    nextTick()
    form.dataOferta.cargo = props.theuser.cargo || ' El usuario no tiene cargo asignado';

    // La lógica de la plantilla ahora crea items completos
    if (props.plantilla === "1") {
        actualizarItems(9);
        // actualizarItems(20);
    }
    if (props.plantilla === "2") {
        actualizarItems(10);
    }
    if (props.plantilla === "99") {
        actualizarItems(2);
    }

});

const CallOne_planti = () => data.CallOnce_Plantilla = false; // no se vuelve a llamar para el hijo 

// <!--<editor-fold desc="Padres e hijos">-->
function actualizarNumericamenteTotal() {
    form.ultra_valor_total = form.items.reduce((acc, item) => acc + (item.valor_total || 0), 0);
}

// Reemplaza a actualizarValoresItems
function actualizarItem(index, updatedItem) {
    if (form.items[index]) {
        form.items[index] = updatedItem;
        actualizarNumericamenteTotal();
    }
}

function upd_itemname(index, name) {
    if (form.items[index]) {
        form.items[index].nombre = name;
    }
}

function deleteItemOP(index) {
    let isok = false;
    actualizarEquipsOnZero({index, isok})
    deleteItemCommun(index, form, data, actualizarNumericamenteTotal)
}

function copyItem(index) {
    const itemToCopy = form.items[index];
    // Deep copy
    const newItem = JSON.parse(JSON.stringify(itemToCopy));
    // Assign a new unique ID
    newItem.id = itemIdCounter++;
    // Insert the new item right after the original one
    form.items.splice(index + 1, 0, newItem);
    // Update totals
    actualizarNumericamenteTotal();
}

//cuando se añaden o quitan items
function actualizarItems(cantidad) {
    while (form.items.length < cantidad) {
        form.items.push({
            id: itemIdCounter++, // ID único para el :key
            nombre: `Item ${form.items.length + 1}`,
            cantidad: 1,
            equipos: [], //definee_2A =>> Plantilla_facil
            valor_total: 0,
        });
    }
    while (form.items.length > cantidad) {
        form.items.pop();
    }
    actualizarNumericamenteTotal()
}

// <!--</editor-fold>-->

// <!--<editor-fold desc="funciones visuales">-->
//funcion que controla si hay boton de guardar o no
function actualizarEquipsOnZero({index, isZero}) {
    data.hijosZeroFlags[index] = isZero;
    data.EquipsOnZero = (data.hijosZeroFlags).includes(true);
}

function scrollToValorNulo() {
    if (props.numberPermissions > 9) setPrecioLista();
    window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'});
}

function scrollToNextItem() {
    const elements = Array.from(document.querySelectorAll('[id^="itemN"]'));
    let lastVisibleIndex = -1;
    const windowHeight = window.innerHeight;

    elements.forEach((el, i) => {
        const rect = el.getBoundingClientRect();
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
    forEach(form.items, (item) => {
        forEach(item.equipos, (equipo) => {
            if (equipo && equipo.equipo_selec &&
                (equipo.equipo_selec.precio_de_lista == 0 || equipo.equipo_selec.precio_de_lista == null)) {
                equipo.equipo_selec.precio_de_lista = 111;
            }
        });
    });
}

// <!--</editor-fold>-->

// <!--<editor-fold desc="post form">-->

function ValidarFormInicial() {
    const esValido = !(!form.dataOferta.cargo || !form.dataOferta.empresa);
    if (!esValido) alert('Los campos cargo y empresa son obligatorios');
    return esValido
}

function ValidarVectoresVacios() {
    let esValido = form.items.length > 0;
    if (!esValido) alert('Debe haber al menos un item en la oferta');
    return esValido
}

const create = () => {
    if (ValidarVectoresVacios() && ValidarFormInicial()) {
        form.post(route('GuardarNuevaOferta'), {
            preserveScroll: true,
            onSuccess: () => {
            },
            onError: () => null,
            onFinish: () => null,
        })
    } else {
        alert('Hay campos vacios o no hay items')
    }
}

// <!--</editor-fold>-->


window.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key.toLowerCase() === 'a') {
        event.preventDefault();
        const addItemLength = form.items.length + 1
        actualizarItems(addItemLength);
    }
});
</script>
<template>
    <Toast :flash="$page.props.flash"/>
<!--    <div class="ml-24">-->

<!--        <SwitchDarkModeNavbar/>-->
<!--    </div>-->

    <button type="button"
            @click="scrollToValorNulo"
            class="fixed top-4 left-4 z-50 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-3 rounded-full shadow-lg"
            aria-label="Ir a Valor nulo!"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"/>
        </svg>
    </button>


    <button type="button"
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
    <section class="space-y-6">
        <div v-if="data.mostrarDetalles" class="flex justify-center mt-4 mb-1">
            <img src="/demco-logo-ultimo.png" alt="Logo Demco" class="h-12"/>
        </div>
        <form @submit.prevent="create" class="px-16 py-1 2xl:px-8 2xl:py-4 print-container">

            <formOferta
                v-model="form.dataOferta"
                :numberPermissions="props.numberPermissions"
                class=" "
            />

            <!--           los factores-->
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-6 p-4">
                <div
                    v-for="(factor, indexfac) in data.factores"
                    :key="indexfac"
                    class="relative bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out overflow-hidden"
                >
                    <div
                        :class="{ 'bg-indigo-100 dark:bg-indigo-900' : indexfac == data.factorSeleccionado - 1 }"
                        class="p-4">
                        <label :for="`factor-input-${indexfac}`"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ factor.title }}
                        </label>
                        <input
                            :id="`factor-input-${indexfac}`"
                            type="text"
                            v-model="data.factores[indexfac].value"
                            class="block w-full px-3 py-2 border border-gray-300 
                                dark:border-gray-600 dark:text-gray-100 dark:bg-gray-700 dark:placeholder-gray-500
                                rounded-md shadow-sm text-base text-gray-900  bg-white placeholder-gray-400 
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
            <!--          fin los factores-->

            <Add_Sub_items
                :initialItems="form.items.length"
                @updateItems="actualizarItems"
                class=" "
            />
            <Newitem
                v-for="(item, indexItem) in form.items" :key="item.id"
                :item="item"
                :indexItem="indexItem"
                
                :plantilla="props.plantilla"
                :factores="data.factores"
                :factorSeleccionado="data.factorSeleccionado"
                :dataccobre="props.dataccobre"
                
                @updateItem="actualizarItem"
                @upd_itemname="upd_itemname"
                @checkzero="actualizarEquipsOnZero"
                @deleteItem="deleteItemOP"
                @copyItem="copyItem"
                @CallOne_planti="CallOne_planti"
                
                :CallOnce_Plantilla="data.CallOnce_Plantilla"
                :mostrarDetalles="data.mostrarDetalles"
                class="mb-4"
            />

            <ErroresNuevaOferta :errors=Object.values($page.props.errors)></ErroresNuevaOferta>
            <Add_Sub_items
                :initialItems="form.items.length"
                @updateItems="actualizarItems"
                class="text-center mx-auto w-fit"
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

            <CerrarYguardar
                v-if="!data.EquipsOnZero"
                :ruta="'Oferta.index'" :formProcessing="form.processing" @create="create"
                class="mb-20 pb-10"
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


    .print-container {
        zoom: 0.75; /* Escala visual general */
        margin: 0 !important;
    }
}
</style>
