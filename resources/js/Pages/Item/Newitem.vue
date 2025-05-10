<template>
    <h2 class="mt-6 -mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
        Item N° {{ index + 1 }}
    </h2>
    <div>
        <Add_Sub_equipos :initialEquipos="data.equipos.length" @updatEquipos="actualizarEquipos"/>

        <!-- Grilla de selección de equipos -->
        <!--        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-16 my-4">-->
        <div class="flex flex-nowrap gap-x-8 overflow-x-scroll my-4">
            <div v-for="(equipo, index) in data.equipos" :key="index" id="SelectVue"

                 class="col-span-2 xl:col-span-2 min-w-[440px]">

                <label :name="'labelSelectVue_' + index">Equipo {{ index + 1 }}</label>
                <vSelect
                    :options="props.losSelect['Equipo']"
                    v-model="data.equipos[index].equipo_id"
                    label="title"
                    class="mt-1 block w-full col-span-2"
                />

                <!-- Cantidad y total por equipo -->
                <div class="grid grid-cols-2 mt-2">
                    <label class="mx-1 mt-6 text-lg">
                        <b>Val Unitario:</b> {{ data.equipos[index]?.equipo_id?.Valor_Unit ?? '' }}
                    </label>

                    <div class="inline-block">
                        <label class="font-semibold">Cantidad:</label>
                        <input
                            type="number"
                            min="1"
                            v-model.number="data.equipos[index].cantidad"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1 block w-full"
                        />
                    </div>

                    <div class="inline-block col-span-full">
                        <label class="font-semibold bg-amber-300 dark:bg-amber-200">Total Equipo:</label>
                        <input
                            type="number"
                            disabled
                            v-model.number="data.equipos[index].subtotalequip"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                            bg-gray-200 rounded-md shadow-sm mt-1 block w-full"
                        />
                    </div>

                    <hr class="border-[1px] border-gray-300 my-1 col-span-full"/>
                    <Menudropdown
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

    <Add_Sub_equipos v-if="data.equipos.length > 6" :initialEquipos="data.equipos.length"
                     @updatEquipos="actualizarEquipos"/>

    <!-- Sección de total -->
    <hr class="border-collapse border border-b-2 border-gray-300 my-4"/>


    <div class="grid grid-cols-1 md:grid-cols-3 2xl:grid-cols-5 gap-8 my-8 hover:bg-gray-50">
        <div class="col-span-1">
            <InputLabel :value="lang().label['cantidad'] + ' del Item'" class=" text-xl"/>
            <TextInput type="number"
                       class="mt-1 block w-full"
                       v-model="localCantidad"
                       required
                       :placeholder="lang().placeholder.cantidad"
                       max="10000000"
            />
            <!--                       :error="errors.cantidad"-->
            <InputError class="mt-2"/>
            <!--                        :message="errors.cantidad"-->
        </div>

        <div class="col-span-1">
            <InputLabel :value="lang().label['valor_unitario_item']" class=" text-xl"/>
            <TextInput type="number"
                       class="mt-1 block w-full bg-gray-300"
                       v-model="localValorUnitario"
                       disabled
                       :placeholder="lang().placeholder.valor_unitario_item"
            />
            <!--                       :error="errors.valor_unitario_item"-->
            <!--                        :message="errors.valor_unitario_item" -->
            <InputError class="mt-2"/>
        </div>

        <div class="col-span-1">
            <InputLabel :value="lang().label['valor_total_item']" class="bg-amber-200 rounded-3xl p-1 text-xl"/>
            <TextInput type="number"
                       class="mt-1 block w-full "
                       v-model="localValorTotal"
                       disabled
                       :placeholder="lang().placeholder.valor_total_item"
            />
            <!--                       :error="errors.valor_total_item"-->
            <!--                        :message="errors.valor_total_item"-->
            <InputError class="mt-2"/>
        </div>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect, computed, ref} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import Disclosure from "@/Pages/Item/Disclosure.vue";
import {Menu} from "floating-vue";
import Menudropdown from "@/Pages/Item/Menudropdown.vue";

// --------------------------- ** -------------------------

// Props que vienen del padre
const props = defineProps({

    valorUnitario: {
        type: Number,
        required: true
    },
    initialCantidad: {
        type: Number,
        default: 1
    },
    index: {
        type: Number,
        required: true
    },
    losSelect: Object,
});

const data = reactive({
    subtotal: 0,
    equipos: [
        {equipo_id: null, cantidad: 1, subtotalequip: 0}
    ],
}, {deep: true})

//para el padre
function actualizarEquipos(cantidad) {
    console.log('achu')
    if (cantidad < 0) cantidad = 0;

    while (data.equipos.length < cantidad) {
        console.log('equiposssssssss:  tienes equipossss  ' + data.equipos)
        data.equipos.push({equipo_id: null, cantidad: 1, subtotalequip: 0});
    }

    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }

    emit('updatEquipos', cantidad, data.equipos);
}

// Emitimos hacia el padre
const emit = defineEmits(['update', 'updatEquipos']); //todo: es necesario ambos? o solo con updateequipos basta


// Variables locales
const localCantidad = ref(props.initialCantidad);
const localValorUnitario = ref(props.valorUnitario);

// Cálculo reactivo
const localValorTotal = computed(() => localCantidad.value * localValorUnitario.value);

// Watchers para comunicar cambios
watch([localCantidad, localValorTotal], () => {
    emit('update', {
        index,
        cantidad: localCantidad.value,
        valor_total_item: localValorTotal.value
    });
});
</script>
