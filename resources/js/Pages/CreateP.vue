<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watchEffect} from 'vue';
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
onMounted(() => {
    if (props.numberPermissions > 9) {

        const valueRAn = Math.floor(Math.random() * (900) + 1)
        const dateran = Math.floor(Math.random() * (9) + 1)
        form.Codigo = (valueRAn);
        form.Descripcion = 'Descripcion: ' + valueRAn + 20
        form['Tipo Fabricante'] = valueRAn + 1
        form['Referencia Fabricante'] = valueRAn + 2
        form.Marca = valueRAn + 3
        form['Unidad de Compra'] = valueRAn + 4
        form['Precio de Lista'] = valueRAn + 5
        form['Fecha actualizacion'] = '2023-06-0' + dateran
        console.log("=>(CreateP.vue:37) form['Fecha actualizacion']", form['Fecha actualizacion']);
        form['Descuento Basico'] = valueRAn + 6
        form['Descuento Proyectos'] = valueRAn + 7
        form['Precio con Descuento'] = valueRAn + 8
        form['Precio con Descuento Proyecto'] = valueRAn + 9
        form['Precio Ultima Compra'] = valueRAn + 10
        form['Precios de Listas'] = valueRAn + 11
        form['Clasificacion 2 Inventario'] = valueRAn + 12
        form['Ruta Tiempos'] = valueRAn + 13
        form['Tiempos Chapisteria'] = valueRAn + 14
        form['provedor_id'] = valueRAn + 14
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'

    }


});
const emit = defineEmits(["close"]);

const data = reactive({
    params: {
        pregunta: ''
    },
    provedores: [0],
})



function nuevoHijo() {
    data.provedores.push(0)
    form.proveedor_id.push(props.losSelect[0][0])
}

let menosHijo = () => {
    if(data.provedores.length > 1){
        data.provedores.length = data.provedores.length - 1
        form.proveedor_id.length = form.proveedor_id.length - 1
    }
}
let justNames = props.titulos.map(names => {
    if (names['order'] !== 'noquiero'
        // &&
        // names['order'] !== 'noquiero1'
    )
        return names['order']
})
const form = useForm({
    ...Object.fromEntries(justNames.map(field => [field, ''])),
    proveedor_id: [props.losSelect[0][0]]
});


const printForm = [];
props.titulos.forEach(names => {
    if (names['order'] !== 'noquiero'
        // && names['order'] !== 'noquiero1'
    )
        printForm.push({
            idd: names['order'], label: names['label'], type: names['type']
        })
});
watchEffect(() => {
    if (props.show) {
        form.errors = {}
    }
})


const sexos = [{label: 'Masculino', value: 0}, {label: 'Femenino', value: 1}];

function ValidarVacios() {
    let result = true
    printForm.forEach(element => {
        if (!form[element.idd]) {
            console.log("=>(Create.vue:70) falta esto papa element.idd", element.idd);
            result = false
            return result
        }
    });
    return result
}

const create = () => {
    if (ValidarVacios()) {
        // console.log("🧈 debu pieza_id:", form.pieza_id);
        form.post(route('Equipo.store'), {
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
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl7'">
            <form class="p-6" @submit.prevent="create">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ lang().label.add }} {{ props.title }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 2xl:gap-8">
                    <div v-for="(atributosform, indice) in printForm" :key="indice">
                        <!-- tiempo -->
                        <div v-if="atributosform.type === 'time'" id="SelectVue">
                            <InputLabel :for="atributosform.label" :value="lang().label[atributosform.label]"/>
                            <TextInput :id="atributosform.idd" :type="atributosform.type" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]" step="3600"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>


                        <!-- normal -->
                        <div v-else class="">
                            <InputLabel :for="atributosform.label" :value="lang().label[atributosform.label]"/>
                            <TextInput :id="atributosform.idd" :type="atributosform.type" class="mt-1 block w-full"
                                       v-model="form[atributosform.idd]" required :placeholder="atributosform.label"
                                       :error="form.errors[atributosform.idd]"/>
                            <InputError class="mt-2" :message="form.errors[atributosform.idd]"/>
                        </div>
                        
                    </div>
                         <div v-for="(provedor,inde2) in data.provedores" :key="inde2"
                              id="SelectVue" class="">
                            <label name="labelSelectVue"> Proveedor </label>
                            <vSelect :options="props.losSelect[0]"
                                      v-model="form['proveedor_id'][inde2]"
                                      label="title"
                            ></vSelect>
                        </div>

<!--                    <div class="flex my-5 gap-8">-->
<!--                        <PrimaryButton type="button" :disabled="form.processing" @click="nuevoHijo()"> Agregar-->
<!--                            proveedor-->
<!--                        </PrimaryButton>-->
<!--                        <DangerButton type="button" :disabled="form.processing" @click="menosHijo()"> Qutiar-->
<!--                            proveedor-->
<!--                        </DangerButton>-->
<!--                    </div>-->
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
