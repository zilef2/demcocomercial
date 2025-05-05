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
    'oferta_id'
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
    if (props.numberPermissions > 9) {

        const valueRAn = Math.floor(Math.random() * (90) + 1)
        form.numero = 'numero genenerico ' + (valueRAn);
        form.nombre = 'numero genenerico ' + (valueRAn);
        form.descripcion = 'numero genenerico ' + (valueRAn);
        form.conteo_items = 1
        form.valor_unitario_item = 1000;
        form.cantidad = 1;
        form.valor_total_item = 1000;
        // form.oferta_id = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'

    }
});


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


watchEffect(() => {
    if (props.show) {
        form.errors = {}
    }
})

watch(() => form.proveedor_id, (new_proveedor_id) => {

})

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
</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl10'">
            <form class="p-6 mb-64" @submit.prevent="create">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
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
                            <InputLabel :for="atributosform.label" :value="lang().label[atributosform.label]"/>
                            <TextInput :id="atributosform.idd" :type="atributosform.type" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>
                    </div>
                    <!--                    valor_unitario_item-->
                    <!--valor_total_item-->
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['valor_unitario_item']"/>
                        <TextInput type="number" class="mt-1 block w-full"
                                   v-model="form['valor_unitario_item']" required
                                   :placeholder="lang().placeholder.valor_unitario_item"
                                   :error="form.errors['valor_unitario_item']"/>
                        <InputError class="mt-2" :message="form.errors['valor_unitario_item']"/>
                    </div>
                    <div class="col-span-1">
                        <InputLabel :value="lang().label['valor_total_item']"/>
                        <TextInput type="number" class="mt-1 block w-full"
                                   v-model="form['valor_total_item']" required
                                   :placeholder="lang().placeholder.valor_total_item"
                                   :error="form.errors['valor_total_item']"/>
                        <InputError class="mt-2" :message="form.errors['valor_total_item']"/>
                    </div>

                    <div id="SelectVue" class="col-span-full">
                        <label name="labelSelectVue"> Equipo </label>
                        <vSelect :options="props.losSelect[' Equipo']"
                                 v-model="form['equipo_id']"
                                 label="title"
                        ></vSelect>
                        <!--                            <InputError class="mt-2" :message="form.errors['proveedor_id.'+inde2+'.value']"/>-->
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
