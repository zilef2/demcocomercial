<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watchEffect} from 'vue';
import "vue-select/dist/vue-select.css";
import DangerButton from '@/Components/DangerButton.vue';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps({
    show: Boolean,
    title: String,
    Equipoa: Object,
    titulos: Object, //parametros de la clase principal
    losSelect: Object,

})

const emit = defineEmits(["close"]);
const data = reactive({
    printForm: [],
    provedores: [],
    recuperar: true,
})

function nuevoHijo() {

    data.provedores.push(0)
    console.log("=>(Edit.vue:33) data.provedores", data.provedores);
    form.proveedor_id.push(props.losSelect[0][0])
}

let menosHijo = () => {
    if (data.provedores.length > 1) {
        data.provedores.length = data.provedores.length - 1
        form.proveedor_id.length = form.proveedor_id.length - 1
    }
}
//very usefull
const justNames = props.titulos.map(names => names['order'])


const form = useForm({
    ...Object.fromEntries(justNames.map(field => [field, ''])),
    proveedor_id: [],
});

onMounted(() => {
    if (props.numberPermissions > 9) {
        const valueRAn = Math.floor(Math.random() * 9 + 1)
        form.nombre = 'admin orden trabajo ' + (valueRAn);
        form.codigo = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'
    }
    // data.printForm.length -= 1 //dependex
});

props.titulos.forEach(names => {
    data.printForm.push({
        idd: names['order'], label: names['label'], type: names['type'], value: form[names['order']]
    })
});

watchEffect(() => {
    if (props.show) {

        // data.justNames.forEach(element => {
        //     form[element] =  props.Equipoa[element]
        // });
        form.errors = {}
        data.provedores.length = 0

        if (data.recuperar) recuperarInfo()

        // form.codigo = props.Equipoa?.codigo

    } else {
        form.reset()
        data.recuperar = true
    }

    function recuperarInfo() {
        data.recuperar = false
        props.titulos.forEach(names => {
            form[names['order']] = props.Equipoa[names['order']];
        });

        props.Equipoa.proveedor_ids.forEach(
            (element, index) => {
                data.provedores.push(0);
                const encontrado = props.losSelect[0].find(item => item.value === element);
                form.proveedor_id.push(encontrado);
                console.log("=>(Edit.vue:73) encontrado", encontrado);
            }
        );
    }
})

const update = () => {
    form.put(route('Equipo.update', props.Equipoa?.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close")
        },
        onError: () => null,
        onFinish: () => {
            form.reset()
            data.provedores.length = 0
        },
    })
}
// const sexos = [ { label: 'Masculino', value: 'Masculino' }, { label: 'Femenino', value: 'Femenino' } ];

</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'xl7'">
            <form class="p-6" @submit.prevent="create">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ lang().label.edit }} {{ props.title }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 2xl:gap-8">
                    <div v-for="(atributosform, indice) in data.printForm" :key="indice">
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
                    <div
                        v-if="Array.isArray(data.provedores) && data.provedores.length"
                        v-for="(provedor,inde2) in data.provedores" :key="inde2"
                        id="SelectVue" class="">

                        <label name="labelSelectVue"> Proveedor </label>
                        <vSelect :options="props.losSelect[0]"
                                 v-model="form['proveedor_id'][inde2]"
                                 label="title"
                        ></vSelect>
                        <InputError class="mt-2" :message="form.errors['proveedor_id.'+inde2+'.value']"/>

                    </div>

                    <div class="flex my-5 gap-8">
                        <PrimaryButton type="button" :disabled="form.processing" @click="nuevoHijo()">
                            Agregar proveedor
                        </PrimaryButton>
                        <DangerButton type="button" :disabled="form.processing" @click="menosHijo()">
                            Quitar proveedor
                        </DangerButton>
                    </div>
                </div>
                <div class=" my-8 flex justify-end">
                    <SecondaryButton :disabled="form.processing" @click="emit('close')"> {{ lang().button.close }}
                    </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                   @click="update">
                        {{ form.processing ? lang().button.save + '...' : lang().button.save }}
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
[name="labelSelectVue"] {
    /* font-size: 22px; */
    font-weight: 600;
}
</style>
