<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {formatDate, formatPesosCol} from '@/global.ts';

defineProps({
    show: Boolean,
    eldetalle: Object,
});

const emit = defineEmits(["close"]);
</script>

<template>
    <section class="space-y-6">
        <Modal :show="show" @close="emit('close')" maxWidth="7xl">
            <div class="bg-gray-50 text-gray-800">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ eldetalle?.codigo_oferta }}</h2>
                        <p class="text-sm text-gray-600">{{ eldetalle?.proyecto }}</p>
                    </div>
                    <SecondaryButton @click="emit('close')">Cerrar</SecondaryButton>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- Columna de Información General (Izquierda) -->
                        <div class="lg:col-span-1 space-y-4 bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
                            <h3 class="text-lg font-semibold text-indigo-700 border-b pb-2 mb-3">Detalles de la Oferta</h3>

                            <div class="flex justify-between items-baseline">
                                <span class="text-sm font-medium text-gray-500">Total:</span>
                                <span class="text-xl font-bold text-indigo-800">{{ formatPesosCol(eldetalle.TotalOferta) }}</span>
                            </div>

                            <div class="text-sm space-y-2 mt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Empresa:</span>
                                    <span class="font-medium text-right">{{ eldetalle.empresa }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Ciudad:</span>
                                    <span class="font-medium text-right">{{ eldetalle.ciudad }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Fecha:</span>
                                    <span class="font-medium text-right">{{ formatDate(eldetalle.fecha) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Responsable:</span>
                                    <span class="font-medium text-right">{{ eldetalle.Userino }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Cargo:</span>
                                    <span class="font-medium text-right">{{ eldetalle.cargo }}</span>
                                </div>
                            </div>

                            <div v-if="eldetalle.descripcion" class="pt-4 mt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Descripción</h4>
                                <p class="text-sm text-gray-700 leading-relaxed text-justify">
                                    {{ eldetalle.descripcion }}
                                </p>
                            </div>
                        </div>

                        <!-- Columna de Items y Equipos (Derecha) -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-indigo-700 mb-4">Items y Equipos</h3>
                            <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                                <div v-for="(item, index) in eldetalle.items" :key="index"
                                     class="bg-white rounded-lg shadow-sm border border-gray-200 transition-shadow hover:shadow-md">
                                    
                                    <!-- Cabecera del Item -->
                                    <div class="p-4 border-b border-gray-100">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="text-sm font-semibold text-indigo-600">Item {{ item.numero + 1 }}</span>
                                                <h4 class="text-lg font-bold text-gray-800">{{ item.descripcion }}</h4>
                                            </div>
                                            <div class="text-right flex-shrink-0 ml-4">
                                                <div class="text-sm text-gray-500">
                                                    {{ item.cantidad }} x {{ formatPesosCol(item.valor_unitario_item) }}
                                                </div>
                                                <div class="text-base font-semibold text-gray-900">
                                                    {{ formatPesosCol(item.valor_total_item) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Equipos Asociados -->
                                    <div v-if="item.codigoDes && item.codigoDes.length" class="p-4 bg-gray-50/50">
                                        <h5 class="text-sm font-semibold text-gray-600 mb-3">Equipos Asociados</h5>
                                        <ul class="space-y-2">
                                            <li v-for="(equipo, eqIdx) in item.codigoDes" :key="eqIdx"
                                                class="bg-white border border-gray-200 rounded-md p-3 text-sm">
                                                <div class="flex justify-between items-center font-mono text-xs mb-2">
                                                    <span class="font-bold text-gray-700">Equipo #{{ eqIdx + 1 }}</span>
                                                    <span v-if="equipo.codigo" class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded">{{ equipo.codigo }}</span>
                                                </div>
                                                <p v-if="equipo.descripcion" class="text-gray-800 mb-2">{{ equipo.descripcion }}</p>
                                                <div class="flex justify-between text-xs text-gray-600">
                                                    <span v-if="equipo.cantidad_equipos">Cantidad: <strong class="text-gray-800">{{ equipo.cantidad_equipos }}</strong></span>
                                                    <span v-if="equipo.precio_de_lista">P. Lista: <strong class="text-gray-800">{{ formatPesosCol(equipo.precio_de_lista) }}</strong></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                     <div v-else class="p-4 bg-gray-50/50 text-center">
                                        <p class="text-sm text-gray-500">No hay equipos asociados a este item.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </section>
</template>