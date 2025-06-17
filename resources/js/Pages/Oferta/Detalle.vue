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
    mostrarGeneral: 0,
})

watchEffect(() => {
    if (props.show) {
        if (!props.eldetalle?.length)
            data.mostrarGeneral = 0
    }
})
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl8'">

            <section class="text-gray-600 body-font overflow-hidden">
                <div class="m-4 flex justify-end">
                    <SecondaryButton @click="emit('close')"> {{ lang().button.close }}</SecondaryButton>
                </div>
                <div class="container px-5 pb-8 mx-auto">
                    <div class="lg:w-11/12 mx-auto flex flex-wrap">
                        <div v-if="data.mostrarGeneral === 0"
                             class="lg:w-1/2 w-full lg:pr-10 lg:py-6 mb-6 lg:mb-0">
                            <h2 class="text-sm title-font text-gray-500 tracking-widest">
                                Oferta
                            </h2>
                            <h1 class="text-gray-900 text-2xl title-font font-medium mb-4">
                                {{ props.eldetalle?.codigo_oferta }} - {{ props.eldetalle?.proyecto }}
                            </h1>
                            <span class="text-sm">{{ formatDate(props.eldetalle.fecha) }}</span>
                            <h2 class="text-sm title-font text-gray-500 tracking-widest">
                                Total de la oferta {{ formatPesosCol(props.eldetalle.TotalOferta) }}
                            </h2>
                            <div class="flex mb-4">
                                <a @click="data.mostrarGeneral = 0"
                                   class="flex-grow  py-2 text-lg px-1"
                                   :class="{ 'text-indigo-500 border-b-2 border-indigo-500': data.mostrarGeneral === 0 }">
                                    Oferta
                                </a>
                                <a
                                    @click="data.mostrarGeneral = 1"
                                    class="flex-grow border-b-2 border-gray-300 py-2 text-lg px-1"
                                    :class="{ 'text-indigo-500 border-b-2 border-indigo-500': data.mostrarGeneral === 1 }">
                                    Items
                                </a>
                            </div>
                            <div v-show="data.mostrarGeneral === 0" class="flex border-t border-gray-200 py-2">
                                <span class="text-gray-500 capitalize">descripcion</span>
                                <span class="ml-auto text-gray-900">{{ props.eldetalle.descripcion }}</span>
                            </div>
                            <div v-show="data.mostrarGeneral === 0" class="flex border-t border-gray-200 py-2">
                                <span class="text-gray-500 capitalize">cargo</span>
                                <span class="ml-auto text-gray-900">{{ props.eldetalle.cargo }}</span>
                            </div>
                            <div v-show="data.mostrarGeneral === 0"
                                 class="flex border-t border-b mb-6 border-gray-200 py-2">
                                <span class="text-gray-500 mr-8 capitalize">empresa </span>
                                <span class="ml-auto text-sm text-gray-900">{{ props.eldetalle.empresa }}</span>
                            </div>
                            <div v-if="index === 0" class="flex">
                                <span class="title-font font-medium text-2xl text-gray-900 capitalize">ciudad {{
                                        props.eldetalle.ciudad
                                    }}</span>
                            </div>
                            <div v-if="index === 0" class="flex">
                                <span class="title-font font-medium text-2xl text-gray-900 capitalize">Userino {{
                                        props.eldetalle.Userino
                                    }}</span>
                            </div>
                        </div>

                        <div v-if="data.mostrarGeneral === 1" v-for="(item, index) in props.eldetalle.items"
                             :key="index"
                             class="lg:w-1/2 w-full lg:pr-10 lg:py-6 mb-6 lg:mb-0">
                            <div v-if="index === 0" class="">

                                <h2 class="text-sm title-font text-gray-500 tracking-widest">
                                    Oferta
                                </h2>
                                <h2 class="text-gray-900 text-2xl title-font font-medium mb-4">
                                    {{ props.eldetalle?.codigo_oferta }} - {{ props.eldetalle?.proyecto }}
                                </h2>
                                <span class="text-sm">{{ formatDate(props.eldetalle.fecha) }}</span>
                                <h2 class="text-sm title-font text-gray-500 tracking-widest">
                                    Total de la oferta {{ formatPesosCol(props.eldetalle.TotalOferta) }}
                                </h2>

                                <div class="flex mb-4">
                                    <a @click="data.mostrarGeneral = 0"
                                       class="flex-grow  py-2 text-lg px-1"
                                       :class="{ 'text-indigo-500 border-b-2 border-indigo-500': data.mostrarGeneral === 0 }">
                                        Oferta
                                    </a>
                                    <a @click="data.mostrarGeneral = 1"
                                       class="flex-grow border-b-2 border-gray-300 py-2 text-lg px-1"
                                       :class="{ 'text-indigo-500 border-b-2 border-indigo-500': data.mostrarGeneral === 1 }">
                                        Items
                                    </a>
                                </div>
                            </div>
                            <div v-else-if="index === 1" class="mt-40">
                            </div>

                            <div class="flex flex-col border-t border-gray-200 py-2 space-y-2">

                                <!-- Descripción (solo si existe) -->
                                <div class="flex" v-if="item.descripcion">
                                    <span class="text-gray-500">Item: {{ item.numero + 1 }} / {{
                                            item.conteo_items
                                        }}</span>
                                    <span class="ml-auto text-gray-900">{{ item.descripcion }}</span>
                                </div>

                                <!-- Valor unitario (formateado) -->
                                <div class="flex">
                                    <span class="text-gray-500">Valor unitario:</span>
                                    <span class="ml-auto text-gray-900">{{
                                            formatPesosCol(item.valor_unitario_item)
                                        }}</span>
                                </div>
                                <!-- Cantidad -->
                                <div class="flex">
                                    <span class="text-gray-500">Cantidad:</span>
                                    <span class="ml-auto text-gray-900">{{ item.cantidad }}</span>
                                </div>
                                <!-- Valor total (formateado) -->
                                <div class="flex font-semibold">
                                    <span class="text-gray-500">Valor total:</span>
                                    <span class="ml-auto text-gray-900">{{
                                            formatPesosCol(item.valor_total_item)
                                        }}</span>
                                </div>
                            </div>
                            <h2 class="mx-auto mt-6  text-lg
                                        title-font text-gray-500 tracking-widest text-center w-fit">
                                Equipos
                            </h2>
                            <div v-for="(codigoDes, itemIndex) in item.codigoDes" :key="itemIndex"
                                 class="flex flex-col border border-gray-300 p-2 m-1 hover:bg-amber-50 space-y-2">
                                <div class="flex" v-if="codigoDes.codigo">
                                    <span class="text-gray-500 capitalize">Equipo N°: {{ itemIndex + 1 }}</span>
                                    <span class="ml-auto text-gray-900">{{ codigoDes.codigo }}</span>
                                </div>
                                <div class="flex" v-if="codigoDes.descripcion">
                                    <span class="text-black">{{ codigoDes.descripcion }}</span>
                                </div>
                            </div>
                            <!--fin for-->
                        </div>

                        <!--                        <img alt="ecommerce" class="xs:mx-1 lg:mx-24 2xl:mx-48 w-full lg:h-auto h-64 object-cover object-center rounded"-->
                        <!--                             src="https://dummyimage.com/350x150/cccccc/000000&text=Comprobante">-->
                    </div>
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="emit('close')"> {{ lang().button.close }}</SecondaryButton>
                    </div>
                </div>
            </section>


        </Modal>
    </section>
</template>
