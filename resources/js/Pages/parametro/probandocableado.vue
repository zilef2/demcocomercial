<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {nextTick, reactive, watch} from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import pkg from 'lodash';
import {router, usePage} from '@inertiajs/vue3';
import {formatPesosCol, number_format} from '@/global.ts';
import {ChevronUpDownIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/solid';


const {_, debounce, pickBy} = pkg
const props = defineProps({
    fromController: Object,

})

const data = reactive({
    // params: {
    //     search: props.filters.search,
    //     field: props.filters.field,
    //     order: props.filters.order,
    // },
    selectedId: [],
    createOpen: false,
    editOpen: false,
    deleteOpen: false,


    cantidad: 0,
    metros: 10,
    valor: 1,
    calibre: 6,
    precioequipo: 8583.75,
    corriente: 60,
    valorunidad: 0,
    total: 0,
})


// watch(() => _.cloneDeep(data.params), debounce(() => {
//     let params = pickBy(data.params)
//     router.get(route("parametro.index"), params, {
//         replace: true,
//         preserveState: true,
//         preserveScroll: true,
//     })
// }, 150))

function calvalorunidad() {
    nextTick()
    data.valorunidad = (Math.floor(data.metros * data.valor * data.precioequipo) + 3832.5) * 1.43
    data.total = data.valorunidad * data.cantidad


}

function calcularCalibre(amperaje) {
    if (amperaje <= 25) return 12;
    if (amperaje <= 35) return 10;
    if (amperaje <= 50) return 8;
    if (amperaje <= 65) return 6;
    if (amperaje <= 85) return 4;
    if (amperaje <= 115) return 2;
    return null; // fuera de rango
}


watch([
    () => data.cantidad,
    () => data.metros,
    () => data.valor,
    () => data.corriente,
], () => {
    calvalorunidad()
})

watch(() => data.corriente, (new_corriente) => {
    data.calibre = calcularCalibre(new_corriente)
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 flex flex-col items-center py-10 px-4">
  <!-- Encabezado -->
  <header class="mb-10 text-center max-w-2xl">
    <h1 class="text-slate-800 text-3xl sm:text-4xl font-bold tracking-tight">
      Dudas de la fórmula <span class="text-indigo-600">Cableado de Potencia</span>
    </h1>
    <p class="text-md mt-2 text-gray-600">Ejemplo ilustrativo para calibre 6</p>
    <p class="text-sm mt-1 text-gray-500">Referencias: 1.1 y 1.3</p>
  </header>

  <!-- Card principal -->
  <div class="w-full max-w-5xl bg-white rounded-2xl shadow-md p-6 space-y-8">

    <!-- Sección: Precio -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">
        Precio equipo: <span class="text-gray-500">(CABLE THHN/THWN 12 600V NEGRO)</span>
      </label>
      <p class="text-xs text-gray-400 mb-2">Se obtiene de una tabla</p>
      <input type="number" min="0" v-model="data.precioequipo"
        class="w-full max-w-xs pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"/>
    </div>

    <!-- Sección: Datos de entrada -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700">Cantidad</label>
        <input type="number" min="0" v-model="data.cantidad"
          class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Metros</label>
        <input type="number" min="0" v-model="data.metros"
          class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Valor</label>
        <input type="number" min="0" v-model="data.valor"
          class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Corriente</label>
        <input type="number" min="0" v-model="data.corriente"
          class="w-full pl-3 py-2 rounded-md border border-indigo-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600"/>
      </div>
    </div>

    <!-- Sección: Resultados -->
    <div class="grid grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700">Calibre</label>
        <input type="number" min="0" v-model="data.calibre" disabled
          class="w-full pl-3 py-2 rounded-md bg-gray-100 border border-gray-300 text-gray-600"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Valor unidad</label>
        <input type="number" min="0" v-model="data.valorunidad" disabled
          class="w-full pl-3 py-2 rounded-md bg-gray-100 border border-gray-300 text-gray-600"/>
      </div>
    </div>

    <!-- Total -->
    <div class="text-center">
      <p class="text-lg font-bold text-gray-800">Total</p>
      <input type="number" min="0" v-model="data.total" disabled
        class="mt-2 w-full max-w-xs pl-4 py-2 rounded-md bg-gray-100 text-lg font-semibold text-red-700 border border-gray-300"/>
    </div>

  </div>
</div>

    </AuthenticatedLayout>
</template>

