<script setup type="module">
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {reactive, watchEffect} from 'vue';
import {formatDate, formatPesosCol, number_format} from '@/global.ts';

const props = defineProps({
    show: Boolean,
    title: String,
    eldetalle: Object,
    maintitle: String,
})

const emit = defineEmits(["close"]);
const data = reactive({
    mostrarGeneral: 1,
})

watchEffect(() => {
    if (props.show) {
        if (!props.eldetalle?.length)
            data.mostrarGeneral = 1
    }
})
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl8'">

            <section class="text-gray-600 body-font overflow-hidden">
                <div class="m-6 flex justify-end">
                    <SecondaryButton @click="emit('close')"> {{ lang().button.close }}</SecondaryButton>
                </div>
                <div class="container max-w-[1400px] xl:max-w-[3100px] px-4 pb-8 mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                        <!-- Oferta - Columna Principal (1 de 4) -->
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col col-span-1">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-base font-semibold text-indigo-700 tracking-wide">Oferta</h2>
                                <span class="text-xs text-gray-400">{{ formatDate(props.eldetalle.fecha) }}</span>
                            </div>
                             <div class="flex mt-4">
                                <button
                                    @click="data.mostrarGeneral = 0"
                                    :class="['flex-grow py-2 text-lg transition', data.mostrarGeneral === 0 ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold' : 'text-gray-400 border-b-2 border-gray-200']">
                                    Oferta
                                </button>
                                <button
                                    @click="data.mostrarGeneral = 1"
                                    :class="['flex-grow py-2 text-lg transition', data.mostrarGeneral === 1 ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold' : 'text-gray-400 border-b-2 border-gray-200']">
                                    Items
                                </button>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ props.eldetalle?.codigo_oferta }} - {{ props.eldetalle?.proyecto }}
                            </h1>
                            <div class="mb-4">
                                <span class="text-sm text-gray-600">Total de la oferta:</span>
                                <span class="ml-2 text-lg font-semibold text-indigo-800">{{
                                        formatPesosCol(props.eldetalle.TotalOferta)
                                    }}</span>
                            </div>
                            <div class="flex border-b border-gray-200 pb-2 mb-2">
                                <div class="w-1/2 text-gray-500 capitalize">Cargo</div>
                                <div class="w-1/2 text-right text-gray-700">{{ props.eldetalle.cargo }}</div>
                            </div>
                            <div class="flex border-b border-gray-200 pb-2 mb-2">
                                <div class="w-1/2 text-gray-500 capitalize">Empresa</div>
                                <div class="w-1/2 text-right text-gray-700">{{ props.eldetalle.empresa }}</div>
                            </div>
                            <div class="flex border-b border-gray-200 pb-2 mb-2">
                                <div class="w-1/2 text-gray-500 capitalize">Ciudad</div>
                                <div class="w-1/2 text-right text-gray-700">{{ props.eldetalle.ciudad }}</div>
                            </div>
                            <div class="flex border-b border-gray-200 pb-2 mb-2">
                                <div class="w-1/2 text-gray-500 capitalize">Usuario</div>
                                <div class="w-1/2 text-right text-gray-700">{{ props.eldetalle.Userino }}</div>
                            </div>
                           
                            <div class="mb-4">
<!--                                <h3 class="text-sm text-gray-600 mb-1">Descripción</h3>-->
                                <p class="text-sm text-gray-800 leading-relaxed text-justify">
                                    {{ props.eldetalle.descripcion }}
                                </p>
                            </div>
                        </div>

                        <!-- Items y Equipos - 3 columnas (col-span-3) -->
                        <div v-if="data.mostrarGeneral === 1" class="col-span-1 lg:col-span-2">
                            <h2 class="text-lg font-semibold text-indigo-700 mb-6 text-center border-b pb-2">Items de la
                                Oferta</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
                                <div v-for="(item, index) in props.eldetalle.items" :key="index"
                                     class="bg-white rounded-lg shadow-sm p-4 flex flex-col mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <span class="text-black text-lg">Item {{ item.numero + 1 }}</span>
                                            <h3 class="text-xl font-bold text-gray-800 mt-1">{{ item.descripcion }}</h3>
                                        </div>
                                        <div class="flex flex-col text-right text-sm text-gray-500">
                                            <span>Cantidad: <span class="text-gray-800">{{
                                                    item.cantidad
                                                }}</span></span>
                                            <span>Unitario: <span class="text-gray-800">{{
                                                    formatPesosCol(item.valor_unitario_item)
                                                }}</span></span>
                                            <span class="font-semibold">Total: <span class="text-indigo-600">{{
                                                    formatPesosCol(item.valor_total_item)
                                                }}</span></span>
                                        </div>
                                    </div>

                                    <!-- Equipos para este Item -->
                                    <div v-if="item.codigoDes && item.codigoDes.length" class="mt-4">
                                        <h4 class="text-md font-semibold text-gray-500 tracking-wide mb-2 text-center">
                                            Equipos Asociados</h4>
                                        <div v-for="(equipo, eqIdx) in item.codigoDes" :key="eqIdx"
                                             class="hover:bg-amber-50 bg-gray-100 rounded-md p-3 mb-2 flex flex-col">
                                            <div class="text-gray-600 font-medium mb-1">Equipo N° {{ eqIdx + 1 }}</div>
                                            <div v-if="equipo.codigo" class="text-gray-800 mb-1">Código: <span
                                                class="font-mono">{{ equipo.codigo }}</span></div>
                                            <div v-if="equipo.cantidad_equipos" class="text-gray-800 mb-1">Cantidad: <span
                                                class="font-mono">{{ equipo.cantidad_equipos }}</span></div>
                                            <div v-if="equipo.precio_de_lista" class="text-gray-800 mb-1">precio lista: <span
                                                class="font-mono">{{ equipo.precio_de_lista }}</span></div>
                                            <div v-if="equipo.descripcion" class="text-gray-700">{{
                                                    equipo.descripcion
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Solo Oferta móvil -->
                        <div v-else class="bg-white rounded-lg shadow p-6 flex flex-col lg:hidden col-span-3 mt-4">
                            <h2 class="text-lg font-semibold text-indigo-700 mb-6 text-center border-b pb-2">Resumen de
                                la Oferta</h2>
                            <!-- Puedes añadir aquí un resumen para móviles si lo necesitas -->
                        </div>
                    </div>
                </div>
            </section>


        </Modal>
    </section>
</template>
