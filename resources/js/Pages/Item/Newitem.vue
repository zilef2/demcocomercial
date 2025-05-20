<template>
    <h2 class="mt-6 -mb-4 underline hover:bg-green-300/25 text-3xl text-center mx-auto py-2 font-medium text-gray-900 dark:text-gray-100">
        Item N° {{ indexItem + 1 }}
    </h2>
    <div>
        <Add_Sub_equipos v-if="props.mostrarDetalles" :initialEquipos="data.equipos.length" @updatEquipos="actualizarEquipos"/>

        <!-- Grilla de selección de equipos -->
        <!--        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-16 my-4">-->
        <div class="flex flex-nowrap gap-x-8 overflow-x-auto overflow-y-hidden my-4">
            <div v-for="(equipo, index) in data.equipos" :key="index" id="SelectVue"

                 class="col-span-2 xl:col-span-2 min-w-[440px]">

                <label v-if="props.mostrarDetalles" :name="'labelSelectVue_' + index">Equipo {{ index + 1 }}</label>
                <vSelect
                    :options="props.losSelect['Equipo']"
                    v-model="data.equipos[index].equipo_id"
                    label="title"
                    class="mt-1 block w-full col-span-2"
                />

                <!-- Cantidad y total por equipo -->
                <div class="grid mt-2" :class="props.mostrarDetalles ? 'grid-cols-2' : 'grid-cols-3'">
                    <div class="inline-block">
                        <label class="mx-1 mt-4 text-lg"><b>Val Unitario:</b></label>
                        <p class="mt-2 text-lg">
                            {{ data.equipos[index]?.equipo_id ? number_format(data.equipos[index]?.equipo_id.Precio_de_Lista, 0, 1) : 'Sin valor' }}
                        </p>
                    </div>

                    <div class="inline-block">
                        <label class="font-semibold">Cantidad:</label>
                        <input
                            type="number"
                            v-model.number="data.equipos[index].cantidad"
                            class="max-w-[120px] border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1 block w-full"
                        />
                    </div>

                    <div class="inline-block" :class="props.mostrarDetalles ? 'col-span-full' : 'col-span-1 ml-2 mt-6'">
                        <label v-if="props.mostrarDetalles" class="font-semibold ">Total Equipo:</label>
                        <input
                            type="number"
                            disabled
                            v-model.number="data.equipos[index].subtotalequip"
                            class="border-gray-300 dark:border-gray-700 bg-gray-300 dark:bg-amber-200 dark:text-gray-300 
                            rounded-md shadow-sm mt-1 block w-full"
                        />
                    </div>
                    <hr v-if="props.mostrarDetalles" class="border-[1px] border-gray-300 my-1 col-span-full"/>
                    <Menudropdown v-if="props.mostrarDetalles"
                        :textoArray="data.equipos[index]?.equipo_id"
                        class="w-full col-span-full"
                    ></Menudropdown>

                    <!--                    <div class="flex flex-wrap text-sm">-->
                    <!--                        <label class="inline-block mx-1"><b>Tipo:</b> {{-->
                    <!--                                data.equipos[index]?.equipo_id?.Tipo ?? ''-->
                    <!--                            }}</label>-->
                    <!--                        <label class="inline-block mx-1"><b>Ref:</b> {{-->
                    <!--                                data.equipos[index]?.equipo_id?.Referencia ?? ''-->
                    <!--                            }}</label>-->
                    <!--                        <label class="inline-block mx-1"><b>Marca:</b> {{ data.equipos[index]?.equipo_id?.Marca ?? '' }}</label>-->
                    <!--                        <label class="inline-block mx-1"><b>Unidad:</b> {{ data.equipos[index]?.equipo_id?.Uni ?? '' }}</label>-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
    
    

    <Add_Sub_equipos v-if="data.equipos.length > 6 && props.mostrarDetalles" :initialEquipos="data.equipos.length"
                     @updatEquipos="actualizarEquipos"/>
    
    <div class="grid grid-cols-1 md:grid-cols-3 2xl:grid-cols-5 gap-8 my-8 hover:bg-gray-50">
        <div class="col-span-1">
            <InputLabel :value="lang().label['cantidad'] + ' del Item'" class="p-1 text-xl"/>
            <TextInput type="number"
                       class="mt-1 block w-full"
                       v-model.number="data.cantidadItem"
                       required
                       :placeholder="lang().placeholder.cantidad"
            />
<!--            <InputError class="mt-2"/>-->
        </div>

        <div class="col-span-1">
            <InputLabel :value="lang().label['valor_unitario_item']" class="p-1 text-xl"/>
            <TextInput type="number"
                       class="mt-1 block w-full bg-gray-300"
                       v-model="data.valorItemUnitario"
                       disabled
                       :placeholder="lang().placeholder.valor_unitario_item"
            />
<!--            <InputError class="mt-2"/>-->
        </div>

        <div class="col-span-1">
            <InputLabel :value="lang().label['valor_total_item']" class="rounded-3xl p-1 text-xl"/>
            <TextInput type="text"
                       class="mt-1 block w-full bg-amber-200"
                       v-model="formattedTotalItem"
                       disabled
                       :placeholder="lang().placeholder.valor_total_item"
            />
<!--            <InputError class="mt-2"/>-->
        </div>
    </div>
    <!-- Sección de total -->
    <hr class="border-collapse border border-b-2 border-gray-300 my-3"/>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { reactive, watch, computed} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import Menudropdown from "@/Pages/Item/Menudropdown.vue";
import {formatPesosCol, number_format} from '@/global.ts';
import vSelect from "vue-select";import "vue-select/dist/vue-select.css";

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
    mostrarDetalles:false,
});   


const data = reactive({
    subtotal: 0,
    equipos: [
        {equipo_id: null, cantidad: 1, subtotalequip: 0}
    ],
    valorItemUnitario:0,
    cantidadItem:1,
    valorItemtotal:0,
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
        TotalItem:rawTotalItem,
        indexItem: props.indexItem,
        cantidadItem: new_cantidadItem,
        valor_total_item: data.valorItemUnitario * new_cantidadItem
    });
}

// Watchers para comunicar cambios
watch(() => data.equipos, (new_equipos) => {
    ActualizarTotalEquipo(data.cantidadItem);
}, { deep: true })
watch(() => data.cantidadItem, (new_cantidadItem) => {
    ActualizarTotalEquipo(new_cantidadItem);
}, { deep: true })

</script>
