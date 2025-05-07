<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
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
const emit = defineEmits(["close"]);
const form = useForm({

    user_id: '',
    cargo: '',
    empresa: '',
    ciudad: '',
    proyecto: '',
    fecha: '',
})

const data = reactive({
    params: {
        pregunta: ''
    },
})
// let justNames = props.titulos.map(names =>{
//     if(names['order'] !== 'noquiero')
//         return names['order']
// })
// const form = useForm({ ...Object.fromEntries(justNames.map(field => [field, ''])) });
onMounted(() => {
    if (props.numberPermissions > 9) {

        const valueRAn = Math.floor(Math.random() * (9) + 1)
        // form.nombre = 'nombre genenerico '+ (valueRAn);
        // form.codigo = (valueRAn);
        // form.hora_inicial = '0'+valueRAn+':00'//temp
        // form.fecha = '2023-06-01'

    }
});

const printForm = [];

watchEffect(() => {
    if (props.show) {
        // form.errors = {}
    }
})


// <!--<editor-fold desc="post form">-->
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
        form.post(route('GuardarNuevaOferta'), {
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
        <form class="p-6" @submit.prevent="create">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Generar oferta
            </h2>
            <div class=" my-8 flex">
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full divide-y-2 divide-gray-200">
                        <thead class="ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white">
                            <th class="px-3 py-2 whitespace-nowrap">Codigo</th>
                            <th class="px-3 py-2 whitespace-nowrap">Descripcion</th>
                            <th class="px-3 py-2 whitespace-nowrap">Role</th>
                            <th class="px-3 py-2 whitespace-nowrap">Salary</th>
                        </tr>
                        </thead>

                        <tbody v-for="(equipo,index) in props.losSelect?.ultimosEquipos" :key="index"
                               class="divide-y divide-gray-200">
                        <tr
                            class="*:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white *:first:font-medium
                             hover:bg-red-300 hover:dark:bg-gray-900/20" 
                            :class="index % 2 === 0 ? 'bg-gray-200' : 'bg-white'"
                        >
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.Codigo }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.Descripcion }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.Descripcion }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo.Descripcion }}</td>
                        </tr>


<!--                        <tr-->
<!--                            class="*:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white *:first:font-medium"-->
<!--                        >-->
<!--                            <td class="px-3 py-2 whitespace-nowrap">Guillermo de la Cruz</td>-->
<!--                            <td class="px-3 py-2 whitespace-nowrap">18/11/1991</td>-->
<!--                            <td class="px-3 py-2 whitespace-nowrap">Familiar/Vampire Hunter</td>-->
<!--                            <td class="px-3 py-2 whitespace-nowrap">$0</td>-->
<!--                        </tr>-->
                        </tbody>
                    </table>
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
