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
    data.valorunidad =  Math.floor(data.metros * data.valor * data.precioequipo) + 5480.475
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
        <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
            <div class="layout-container">
                <main class="px-4 sm:px-8 md:px-16 lg:px-24 xl:px-40 flex flex-1 py-8">
                    <div class="flex w-full max-w-5xl">
                        <div class="mb-8">
                            <h1 class="text-slate-800 text-3xl sm:text-4xl font-bold tracking-tight"> CABLEADO DE POTENCIA </h1>
<!--                            <p class="text-sm mt-4"> (CABLE THHN/THWN 12 600V NEGRO)</p>-->
                        </div>
                    </div>
                </main>
                </div>

                <div class="grid grid-cols-2 px-0 py-2 text-center w-full gap-2">
                    <div class="px-2">
                        <label for="precioequipo" class="w-full">Precio equipo: (CABLE THHN/THWN 12 600V NEGRO)</label>
                        <p class="w-full text-xs">Se obtiene de una tabla</p>
                        <input type="number" min=0 v-model="data.precioequipo"
                            class="mt-1 max-w-32 pl-3  rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                </div>
            
                <div class="grid grid-cols-6 px-0 py-2 text-center w-full gap-2">
                    <div class="px-2">
                        <label for="cantidad">cantidad</label>
                        <input type="number" min=0 v-model="data.cantidad"
                            class="mt-1 max-w-32 pl-3 rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                    <div class="px-2">
                        <label for="metros">metros</label>
                        <input type="number" min=0 v-model="data.metros"
                            class="mt-1 max-w-32 pl-3 rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                    <div class="px-2">
                        <label for="valor">valor</label>
                        <input type="number" min=0 v-model="data.valor"
                            class="mt-1 max-w-32 pl-3  rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                    
                    <div class="px-2">
                        <label for="corriente">corriente</label>
                        <input type="number" min=0 v-model="data.corriente"
                            class="mt-1 max-w-32 pl-3  rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                    <div class="px-2">
                        <label for="calibre">calibre</label>
                        <input type="number" min=0 v-model="data.calibre" disabled
                            class="mt-1 max-w-32 pl-3 bg-gray-400 rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                    <div class="px-2">
                        <label for="valorunidad">valor unidad</label>
                        <input type="number" min=0 v-model="data.valorunidad" disabled
                            class="mt-1 max-w-32 pl-3 rounded-md bg-gray-400 mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                <!-- fin grid-->
                </div>
                    <div class="px-2 w-full">
                        <p class="w-full mt-4 text-lg font-bold">Total</p>
                        <input type="number" min=0 v-model="data.total" disabled
                            class="mt-1 max-w-32 pl-4 bg-gray-400 text-lg text-red-800 rounded-md mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700"/>
                    </div>
                
                
            </div>
    </AuthenticatedLayout>
</template>

