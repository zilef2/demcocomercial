<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect} from 'vue';
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
})


// && names['order'] !== 'noquiero1'

// && names['order'] !== 'noquiero1'


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
        form.valor_unitario_item = 1000;
        form.cantidad = 1;
        form.valor_total_item = 1000;
        // form.oferta_id = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'

    }
});

const equipos = ref([{ equipo_id: null }]); // array dinámico

function actualizarEquipos(cantidad) {
    // Si hay más, agregamos
    while (equipos.value.length < cantidad) {
        equipos.value.push({ equipo_id: null });
    }
    // Si hay menos, quitamos
    while (equipos.value.length > cantidad) {
        equipos.value.pop();
    }
}




watchEffect(() => {
    if (props.show) {
        form.errors = {}
    }
})

watch(() => form.proveedor_id, (new_proveedor_id) => {

})



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
            <form class="p-6 mb-64" @submit.prevent="create">
                <h2 class="text-lg 2xl:text-2xl font-medium text-gray-900 dark:text-gray-100 my-3">
                    {{ lang().label.add }} {{ props.title }}
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

                <Add_Sub_equipos :initialEquipos="equipos.length" @updateEquipos="actualizarEquipos"/>

                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-8 my-4">
                    <div v-for="(equipo, index) in equipos" :key="index" id="SelectVue"
                         class="col-span-2 2xl:col-span-3">
                        <label :name="'labelSelectVue_' + index">Equipo {{ index + 1 }}</label>
                        <vSelect :options="props.losSelect['Equipo']"
                                 v-model="equipos[index].equipo_id"
                                 label="title"
                        ></vSelect>
                    </div>
                </div>

                <hr class="border-collapse border border-b-2 border-gray-300 my-4">
                <h2 class="text-lg 2xl:text-2xl font-medium text-gray-900 dark:text-gray-100 mt-3">
                    Total del item
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 2xl:grid-cols-5 gap-8 my-8 hover:bg-gray-50">
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['cantidad']"/>
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
