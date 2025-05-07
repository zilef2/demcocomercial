<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect, ref} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";

// --------------------------- ** -------------------------

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    titulos: Object, //parametros de la clase principal
    losSelect: Object,
    numberPermissions: Number,
})
const emit = defineEmits(["close"]);

const data = reactive({
    params: {
        pregunta: ''
    },
    subtotal: 0,
    equipos: [{equipo_id: null, cantidad: 1}],
})

// Método para actualizar la cantidad de equipos (por ejemplo desde el botón hijo)
function actualizarEquipos(cantidad) {
    while (data.equipos.length < cantidad) {
        data.equipos.push({equipo_id: null, cantidad: 1});
    }
    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }
}

const noIncluirPrint = ['numero',
    'valor_unitario_item',
    'valor_total_item',
    'oferta_id',
    'conteo_items',
    'cantidad',
] //html
const noIncluirForm = [] //useform
let justNames = props.titulos.map(names => {
    if (!noIncluirForm.includes(names['order']))
        // if (names['order'] !== 'noquiero')
        return names['order']
})

const printForm = [];
props.titulos.forEach(names => {
    if (!noIncluirPrint.includes(names['order']))
        printForm.push({
            idd: names['order'], label: names['label'], type: names['type']
        })
});

const form = useForm({...Object.fromEntries(justNames.map(field => [field, '']))});
onMounted(() => {
    form.conteo_items = 1
    if (props.numberPermissions > 9) {

        const valueRAn = Math.floor(Math.random() * (90) + 1)
        form.numero = 'numero gen ' + (valueRAn);
        form.nombre = 'nombre gen ' + (valueRAn);
        form.descripcion = 'descripcion gen ' + (valueRAn);
        form.valor_unitario_item = 0;
        form.cantidad = 0;
        // form.oferta_id = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'

    }
});

// const equipos = ref([{equipo_id: null}]); // array dinámico

watchEffect(() => {
    if (props.show) {
        form.errors = {}
    }
})
watch(() => form.cantidad, () => recalcularSubtotal(), {deep: true});
watch(() => data.equipos, () => recalcularSubtotal(), {deep: true});

// Función de suma total
function recalcularSubtotal() {
    data.equipos.forEach((equipo, index) => {

        const valorUnitario = parseFloat(equipo?.equipo_id?.Valor_Unit) || 0;
        const cantidad = parseInt(equipo?.cantidad) || 0;
        if (valorUnitario && cantidad)
            data.equipos[index].subtotalequip = valorUnitario * cantidad;

    });
    console.table(data.equipos)
    //total item
    form['valor_unitario_item'] = 0
    data.equipos.forEach((equipo) => {
        form['valor_unitario_item'] += parseFloat(equipo.subtotalequip) || 0;
    });
    form['valor_total_item'] = (form['valor_unitario_item'] * form.cantidad);
}

// watch(() => form.proveedor_id, (new_proveedor_id) => {
//
// })


// <!--<editor-fold desc="zona final">-->
function ValidarVacios() {
    let result = true
    printForm.forEach(element => {
        if (!form[element.idd]) {
            result = false
            return result
        }
    });
    return result
}

const create = () => {
    if (ValidarVacios()) {
        // console.log("🧈 debu pieza_id:", form.pieza_id);
        form.post(route('Item.store'), {
            preserveScroll: true,
            onSuccess: () => {
                emit("close")
                form.reset()
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
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl10'">
            <form class="py-12 px-8 xl:px-20 mb-16" @submit.prevent="create">
                <h2 class="text-xl 2xl:text-3xl font-bold tracking-tight text-gray-900 dark:text-white my-6">
                    🛠️ Gestionar {{ props.title }}: Crear Nuevo Registro
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-8">
                    <!--// text - string // number // dinero // date // datetime // foreign-->

                    <div v-for="(atributosform, indice) in printForm" :key="indice">
                        <div v-if="atributosform.type === 'time'" id="SelectVue">
                            <InputLabel :for="atributosform.label" :value="lang().label[atributosform.label]"/>
                            <TextInput :id="atributosform.idd" :type="atributosform.type" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]" step="3600"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>

                        <!-- normal -->
                        <div v-else-if="atributosform.type === 'integer'" class="">
                            <InputLabel :for="atributosform.label" :value="lang().label[atributosform.label]"/>
                            <TextInput :id="atributosform.idd" type="number" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>
                        <!-- normal -->
                        <div v-else-if="atributosform.type === 'text' || atributosform.type === 'string' " class="">
                            <InputLabel :for="atributosform.label"
                                        :value="lang().label[atributosform.label] + ' del Item'"/>
                            <TextInput :id="atributosform.idd" :type="atributosform.type" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>
                    </div>
                </div>
                <hr class="border-collapse border border-b-2 border-gray-300 my-4">
                <h2 class="text-lg 2xl:text-2xl font-medium text-gray-900 dark:text-gray-100 mt-3">
                    Agrege los equipos
                </h2>
                <!--                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-8 my-4">-->
                <!--                    <div id="SelectVue" class="col-span-2 2xl:col-span-3">-->
                <!--                        <label name="labelSelectVue"> Equipo </label>-->
                <!--                        <vSelect :options="props.losSelect['Equipo']"-->
                <!--                                 v-model="form['equipo_id']"-->
                <!--                                 label="title"-->
                <!--                        ></vSelect>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                    <InputError class="mt-2" :message="form.errors['proveedor_id.'+inde2+'.value']"/>-->

                <Add_Sub_equipos :initialEquipos="data.equipos.length" @updateEquipos="actualizarEquipos"/>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-16 my-4">
                    <div v-for="(equipo, index) in data.equipos" :key="index" id="SelectVue"
                         class="col-span-2 xl:col-span-2">

                        <label :name="'labelSelectVue_' + index">Equipo {{ index + 1 }}</label>
                        <vSelect :options="props.losSelect['Equipo']"
                                 v-model="data.equipos[index].equipo_id"
                                 label="title" class="mt-1 block w-full col-span-2"
                        ></vSelect>
                        <!-- Selección de cantidad -->

                        <div class="grid grid-cols-2 mt-2">
                            <label class="mx-1 mt-6 text-lg"><b>Val
                                Unitario: </b>{{ data.equipos[index]?.equipo_id?.Valor_Unit ?? '' }}</label>
                            <div class="inline-block">
                                <label class="font-semibold">Cantidad:</label>
                                <input type="number" min="1" v-model.number="data.equipos[index].cantidad"
                                       class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm mt-1 block w-full"/>
                            </div>
                            <div class="inline-block col-span-full">
                                <label class="font-semibold">Total Equipo:</label>
                                <input type="number" disabled v-model.number="data.equipos[index].subtotalequip"
                                       class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       bg-gray-300 dark:bg-gray-600
                                        rounded-md shadow-sm mt-1 block w-full"/>
                            </div>

                            <hr class="border-[1px] border-gray-300 my-2 col-span-full">
                            <div class="flex">
                                <label class="inline-block mx-1 text-sm"><b>Tipo: </b>{{
                                        data.equipos[index]?.equipo_id?.Tipo ?? ''
                                    }}</label>
                                <label class="inline-block mx-1 text-sm"><b>Ref: </b>{{
                                        data.equipos[index]?.equipo_id?.Referencia ?? ''
                                    }}</label>
                                <label class="inline-block mx-1 text-sm"><b>Marca: </b>{{
                                        data.equipos[index]?.equipo_id?.Marca ?? ''
                                    }}</label>
                                <label class="inline-block mx-1 text-sm"><b>Unidad: </b>{{
                                        data.equipos[index]?.equipo_id?.Uni ?? ''
                                    }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <Add_Sub_equipos v-if="data.equipos.length > 6" :initialEquipos="data.equipos.length"
                                 @updateEquipos="actualizarEquipos"/>


                <hr class="border-collapse border border-b-2 border-gray-300 my-4">
                <h2 class="text-lg 2xl:text-2xl font-medium text-gray-900 dark:text-gray-100 mt-3">
                    Total del item
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 2xl:grid-cols-5 gap-8 my-8 hover:bg-gray-50">
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['cantidad'] + ' del Item'"/>
                        <TextInput type="number" class="mt-1 block w-full"
                                   v-model="form['cantidad']" required
                                   :placeholder="lang().placeholder.cantidad"
                                   max=10000000
                                   :error="form.errors['cantidad']"/>
                        <InputError class="mt-2" :message="form.errors['cantidad']"/>
                    </div>

                    <!--valor_total_item-->
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['valor_unitario_item']"/>
                        <TextInput type="number" class="mt-1 block w-full bg-gray-300"
                                   v-model="form['valor_unitario_item']" disabled
                                   :placeholder="lang().placeholder.valor_unitario_item"
                                   :error="form.errors['valor_unitario_item']"/>
                        <InputError class="mt-2" :message="form.errors['valor_unitario_item']"/>
                    </div>
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['valor_total_item']"/>
                        <TextInput type="number" class="mt-1 block w-full bg-gray-300"
                                   v-model="form['valor_total_item']" disabled
                                   :placeholder="lang().placeholder.valor_total_item"
                                   :error="form.errors['valor_total_item']"/>
                        <InputError class="mt-2" :message="form.errors['valor_total_item']"/>
                    </div>
                </div>
                <div class=" my-8 flex justify-end">
                    <SecondaryButton :disabled="form.processing" @click="emit('close')"> {{ lang().button.close }}
                    </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                   @click="create">
                        {{ lang().button.add }} {{ form.processing ? '...' : '' }}
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>

<style>
textarea {
    @apply px-3 py-2 border border-gray-300 rounded-md;
}

[name="labelSelectVue"],
.muted {
    color: #1b416699;
}

[name="labelSelectVue"] {
    /* font-size: 22px; */
    font-weight: 600;
}
</style>
