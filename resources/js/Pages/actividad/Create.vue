<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import vSelect from "vue-select"; import "vue-select/dist/vue-select.css";
import { reactive, watch, onMounted, ref, watchEffect } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

// --------------------------- ** -------------------------

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    losSelect: Object,
    titulos: Object, //parametros de la clase principal

    numberPermissions: Number,
})
const emit = defineEmits(["close"]);

const data = reactive({
    params: {
        pregunta: ''
    },
    centros : [0],
    valido: true,
    mensajeError : ''
})

//very usefull
const justNames = props.titulos.map(names => names['order'] )
const form = useForm({ ...Object.fromEntries(justNames.map(field => [field, ''])),
    centro_id: [props.losSelect[0]]
});

onMounted(() => { });


let validar = () => {
    try{
        data.valido = true
        if(!form.nombre || !form.tipo){
            data.valido = false
            throw new Error('BreakException');
        }

        // form.centro_id.forEach(element => {
        //     if(element.value === 0){
        //         data.valido = false
        //         throw new Error('BreakException');
        //     }
        // });
    } catch (e) {
        data.valido = false
    }
}
const create = () => {
    validar()
    if(data.valido){
        form.post(route('actividad.store'), {
            preserveScroll: true,
            onSuccess: () => {
                emit("close")
                form.reset()
            },
            onError: () => null,
            onFinish: () => null,
        })
    }else{
        data.mensajeError = 'Hay elementos vacios'
    }
}

watchEffect(() => {
    if (props.show) {
        form.errors = {}
    }
})

function nuevoHijo(){
    data.centros.push(0)
    form.centro_id.push(props.losSelect[0])
}

let menosHijo = () => {
    data.centros.length = data.centros.length - 1
    form.centro_id.length = form.centro_id.length - 1
}

const tiposOptions = [
  {
    title: "Seleccione un tipo",
    value: 0
  },
  {
    title: "TVA",
    value: "TVA"
  },
  {
    title: "TNVA",
    value: "TNVA"
  },
];

</script>

<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">
            <form class="p-6" @submit.prevent="create">
                <div class="mb-[230px]">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ lang().label.add }} {{ props.title }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div class="">
                        <InputLabel for="nombre" :value="lang().label.nombre" />
                        <TextInput id="nombre" type="text" class="mt-1 h-8 block w-full"
                                   v-model="form['nombre']" required :placeholder="nombre"
                                   :error="form.errors['nombre']" />
                        <InputError class="mt-2" :message="form.errors['nombre']" />
                      </div>
                      <div>
                        <InputLabel for="tipo" :value="lang().label.Tipo" />
                        <vSelect :options="tiposOptions" label="title"
                                  class="dark:bg-gray-400 rounded-lg dark:text-white"
                                  v-model="form.tipo"></vSelect>
                      </div>
                        <div v-for="(centro, index) in data.centros" id="SelectVue">
                            <label name="labelSelectVue" class="dark:text-white">
                              Centro de trabajo </label>
                            <vSelect :options="props.losSelect" label="title"
                                      class="dark:bg-gray-400 rounded-lg dark:text-white"
                                v-model="form.centro_id[index]"></vSelect>
                            <InputError class="mt-2" :message="form.errors.centro_id" />
                        </div>

                    </div>

                    <div class="flex my-5 gap-8">
                        <PrimaryButton type="button" :disabled="form.processing" @click="nuevoHijo()"> Mas centros </PrimaryButton>
                        <PrimaryButton type="button" :disabled="form.processing" @click="menosHijo()"> Menos centros </PrimaryButton>
                    </div>
                </div>
                <div class="flex my-8 justify-end">
                    <p class="text-lg mx-8 text-red-500">{{ data.mensajeError }}</p>
                    <SecondaryButton :disabled="form.processing" @click="emit('close')"> {{ lang().button.close }} </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="create">
                        {{lang().button.add}} {{ form.processing ?  '...' : '' }}
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
    font-weight: 700;
}
</style>
<style scoped>
:deep(.vue-select) { /* O un selector más específico si es necesario */
  --vs-dropdown-bg: #fff;
  --vs-dropdown-color: #000;
  --vs-colors--dark: #fff;
}
</style>
