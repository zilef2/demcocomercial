<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, watch, watchEffect} from 'vue';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import '@vuepic/vue-datepicker/dist/main.css';
import {DiferenciaMinutos, formatTime, TransformTdate} from '@/global.ts';


const Hardcoded = [
    '23328-4' //todo: tochange, this is a "lujo" and its better to get a code from ofertas and 
]
const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,

    losSelect: Object,
    numberPermissions: Number,
    valuesGoogleCabeza: Object,
    valuesGoogleBody: Object,
    Trabajadores: Object,
    losOT: Object,
})
const emit = defineEmits(["close"]);

const data = reactive({
    params: {
        pregunta: ''
    },
    actividad_id: props.losSelect.actividad,
    centrotrabajo_id: props.losSelect.centrotrabajo,
    disponibilidad_id: props.losSelect.disponibilidad,
    ordentrabajo_id: props.losSelect.ordentrabajo,
    reproceso_id: props.losSelect.reproceso,
    temp_disponibilidad_id: null,
    temp_reproceso_id: null,
    temp_actividad_id: null,
    valorInactivo: 'NA',
    cabeza: props.valuesGoogleCabeza,
    nombresOT: Object.values(props.valuesGoogleBody),
    mensajeFalta: '',
    BanderaTipo: true,
    mensajeTiemposAuto: '',
    limiteMinimo: '',

    //estos son los vectores generados en frontend
    ordentrabajo_ids: [],
    ot2: [],
    tenemosCentro: false,
    soloParaOfertas: false,
})


//very usefull
const justNames = [
    // 'codigo',
    'tipoReporte',
    'fecha',
    'hora_inicial',
    'hora_final',
    'actividad_id',
    'centrotrabajo_id',
    'disponibilidad_id',
    'operario_id',
    'ordentrabajo_id',
    'reproceso_id',

    'ordentrabajo_ids',
    'otitem',
    'user_id',

    'numero_oferta',
    'OTItem',
    'TiempoEstimado',
    'ot_id', //centro costo => proyectos

];
const form = useForm({...Object.fromEntries(justNames.map(field => [field, '']))});


// <!--<editor-fold desc="onmounted and disablecontext">-->
const CalcularHoraActual = () => {
    let horaActual = new Date();
    horaActual.setHours(horaActual.getHours() - 1);
    let formatoHora = (valor) => (valor < 10 ? `0${valor}` : valor);
    return `${formatoHora(horaActual.getHours())}:${formatoHora(horaActual.getMinutes())}`;
}

const disableContextMenu = (event) => {
    // Prevent the default context menu behavior
    event.preventDefault();
    return false;
};

onMounted(() => {
    data.limiteMinimo = CalcularHoraActual()
    setInterval(() => {
        data.limiteMinimo = CalcularHoraActual()
    }, 60000);

    // if (props.numberPermissions > 9) {
    //     setTimeout(() => {
    //         form.ordentrabajo_ids = data.ordentrabajo_ids[1];
    //         form.centrotrabajo_id = data.centrotrabajo_id[1];
    //         form.actividad_id = data.actividad_id[1];
    //         data.mensajeTiemposAuto = 'Super!'
    //     }, 500);
    // }
    // document.body.addEventListener('contextmenu', this.disableContextMenu);
    document.body.addEventListener('contextmenu', disableContextMenu);


    //explaining: nombresOT, es el objeto de google, la fila de google sheets.
    data.ordentrabajo_ids = data.nombresOT.map((val) => ({
        title: val.numero_oferta?.replace(/_/g, " "),
        value: val.id,
    }))
    data.ot2 = data.nombresOT.map((val) => ({
        title: val.ot?.replace(/_/g, " "),
        value: val.id,
    }))
});
// <!--</editor-fold>-->

// onBeforeUnmount(() => document.body.removeEventListener('c5ontextmenu', this.disableContextMenu))

// <!--<editor-fold desc="validar">-->

let ValidarNotNull = (campos) => {
    let sonObligatorios = '';
    try {
        campos.forEach((value) => {
            if (typeof form[value] === 'undefined'
                || form[value] === null
                || form[value].value === null
                || form[value].length === 0) {

                sonObligatorios = value
                throw new Error('BreakException');
            }
        })
    } catch (e) {
        // if (e.message !== 'BreakException') throw e;
    }
    return sonObligatorios;
}

let ValidarCreateReporte = () => {
    let tipo = form.tipoReporte.value;
    let result = true;
    const mensaje = '. Campo obligatorio'

    let horaactual = new Date().getHours()
    let minutosDif = DiferenciaMinutos(horaactual + ':00', form.hora_inicial)

    if (form.actividad_id == null || form.actividad_id.value === 0) return 'No olvide la actividad';
    if (minutosDif > 0) return 'Ha pasado mucho tiempo!';

    if (tipo === 0) {
        result = ValidarNotNull([
            // 'ordentrabajo_ids',
            'centrotrabajo_id',
            'actividad_id',
        ])
    } //acti

    if (tipo === 1) {
        result = ValidarNotNull([
            'centrotrabajo_id',
            // 'ordentrabajo_ids',
            'actividad_id',
            'reproceso_id',
        ])
    } //reproceso

    if (tipo === 2) {
        result = ValidarNotNull([
            'centrotrabajo_id',
            'disponibilidad_id',
        ])
    } //disponibilidad

    let objectMessages = {
        'ordentrabajo_ids': 'Orden trabajo',
        'actividad_id': 'Actividad',
        'reproceso_id': 'Reproceso',
        'centrotrabajo_id': 'Centro de trabajo',
        'disponibilidad_id': 'Disponibilidad',
    }
    if (result !== '') return objectMessages[result] + mensaje
    else return result
}
// <!--</editor-fold>-->


// <!--<editor-fold desc="Watchers">-->

watchEffect(() => {
    if (props.show) {
        if (data.BanderaTipo) {

            form.tipoReporte = {title: 'Actividad', value: 0};
            data.BanderaTipo = false
        }

        form.errors = {}
        if (form.fecha === null || form.fecha === '') {
            let currentDate = new Date();
            form.fecha = (TransformTdate(currentDate, '')).substring(0, 10);
            form.hora_inicial = formatTime()
        }

        if ((form.ordentrabajo_ids && form.ordentrabajo_ids.value) || (form.ot_id && form.ot_id.id)) {
            console.table(data.nombresOT.slice(0, 10));

            let OTidd
            data.tenemosCentro = false
            if (form.ordentrabajo_ids && form.centrotrabajo_id?.title?.toLowerCase() === 'ofertas') {
                data.tenemosCentro = true
                OTidd = data.nombresOT.find(item => {
                    return item.id === form.ordentrabajo_ids.value
                })
            } else if (form.ot_id && form.centrotrabajo_id?.title?.toLowerCase() === 'proyectos') {
                // data.tenemosCentro = true
                // OTidd = data.nombresOT.find(item => {
                //     return item.id === form.ot_id.value
                // })
            } 

            if (data.tenemosCentro) {
                form.avance = OTidd.avance
                form.cliente = OTidd.cliente
                form.TiempoEstimado = OTidd.tiempo_estimado
            }
        }

        //mostrar cliente, avanze y tiempo solo para ofertas
        data.soloParaOfertas = (form.ordentrabajo_ids || form.ot_id)
            && form.tipoReporte.value !== 2
            && form.centrotrabajo_id?.title?.toLowerCase() === 'ofertas'
    } else {
        data.BanderaTipo = true
    }
})


//si se cambia el tiporeporte, todo vacio
watch(() => form.tipoReporte, () => {
    form.actividad_id = null
    form.centrotrabajo_id = null
    form.disponibilidad_id = null
    form.operario_id = null
    form.ordentrabajo_id = null
    form.reproceso_id = null
    form.ordentrabajo_ids = null
    // tipoReporte
    // form.otitem = null
    // form.numero_oferta = null
    // form.OTItem = null
    // form.TiempoEstimado = null

    //
    form.numero_oferta = null
    // form.cliente = null
    // form.avance = null
    form.TiempoEstimado = null
})

watch(() => form.centrotrabajo_id, (newCentro) => {
    if (newCentro && typeof newCentro.value !== 'undefined') {
        let actividadesDelCentro = 'centrotrabajo' + newCentro.title
        data.actividad_id = props.losSelect[actividadesDelCentro]

        form.ordentrabajo_ids = null
        form.ot_id = null
        form.avance = null
        form.cliente = null
        form.TiempoEstimado = null
        data.tenemosCentro = false
        if (props.numberPermissions > 9) {
            setTimeout(() => {
                // form.ot_id = data.ot2[0]
                form.actividad_id = data.actividad_id[1]
            }, 120)
        }
    }
    form.actividad_id = {title: 'Seleccione actividad', value: null}
})
// <!--</editor-fold>-->


// <!--<editor-fold desc="SendToBackend">-->
const create = () => {
    form.ordentrabajo_id = form.ordentrabajo_ids
    data.mensajeFalta = ValidarCreateReporte();
    form.hora_inicial = formatTime()
    if (data.mensajeFalta === '') {
        setTimeout(SendToBackend(), 500);
    }

}
const SendToBackend = () => {
    form.post(route('reporte.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close")
            form.reset()
        },
        onError: () => alert(JSON.stringify(form.errors, null, 4)),
        onFinish: () => null
    })
    return null
}
// <!--</editor-fold>-->

const opcinesActividadOTros = [
    {title: 'Actividad', value: 0},
    {title: 'Reproceso', value: 1},
    {title: 'Disponibilidad (paro)', value: 2}
];


</script>

<template>
    <!--    <meta http-equiv="refresh" content="120">-->

    <section class="space-y-6  dark:text-white">
        <Modal :show="props.show" @close="emit('close')" :maxWidth="'4xl'">
            <form class="px-6 my-8" @submit.prevent="create">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ lang().label.add }} {{ props.title }}
                </h2>
                <div class="grid xs:grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div v-if="props.numberPermissions > 1" id="opcinesActividadO" class="xl:col-span-2 col-span-1">
                        <label class=" dark:text-white" name=""> Reportar en nombre de:
                            <small>(Opcional) </small></label>
                        <v-select :options="props.Trabajadores" label="title" class="dark:bg-gray-400"
                                  v-model="form.user_id"></v-select>
                    </div>
                    <div id="opcinesActividadO" class="xs:col-span-1 xl:col-span-2">
                        <label class=" dark:text-white"> Tipo de reporte </label>
                        <v-select :options="opcinesActividadOTros" label="title" class="dark:bg-gray-400"
                                  v-model="form.tipoReporte"></v-select>
                    </div>
                    <!-- empieza -->

                    <div class="xs:col-span-1 xl:col-span-1">
                        <InputLabel for="fecha" :value="lang().label['fecha']" class=" dark:text-white"/>
                        <TextInput id="fecha" type="date" class="mt-1 block w-full bg-gray-200  dark:text-white"
                                   v-model="form['fecha']" disabled placeholder="fecha"
                                   :error="form.errors['fecha']"/>
                        <InputError class="mt-2" :message="form.errors['fecha']"/>
                    </div>
                    <!--                        :value="lang().label['hora inicial'] + ', min: '+data.limiteMinimo" />-->
                    <div class=" dark:text-white col-span-1">
                        <InputLabel for="hora_inicial"
                                    :value="lang().label['hora inicial']"/>
                        <TextInput id="hora_inicial" type="time" class="mt-1 block w-full" disabled
                                   v-model="form['hora_inicial']" placeholder="hora_inicial"
                                   :error="form.errors['hora_inicial']" step="60"/>
                        <InputError class="mt-2" :message="form.errors['hora_inicial']"/>
                    </div>

                    <div id="Scentrotrabajo" class="xs:col-span-1 xl:col-span-1">
                        <label name="centrotrabajo_id" class=" dark:text-white"> Centro de trabajo </label>
                        <v-select :options="data['centrotrabajo_id']" label="title" class="dark:bg-gray-400"
                                  v-model="form.centrotrabajo_id"
                        ></v-select>
                        <InputError class="mt-2" :message="form.errors['centrotrabajo_id']"/>
                    </div>

                    <!--                    ordentrabajo es numero de oferta   numero_oferta-->
                    <!-- tipoReporte.value !== 2 si no es una disponibilidad-->

                    <div
                        v-if="form.tipoReporte.value !== 2 && form.centrotrabajo_id?.title?.toLowerCase() === 'ofertas'"
                        id="Sordentrabajo" class="xl:col-span-1 xs:col-span-1">
                        <label class="dark:text-white"> Número de oferta </label>
                        <v-select :options="data['ordentrabajo_ids']" label="title" class="dark:bg-gray-400"
                                  v-model="form['ordentrabajo_ids']"
                        ></v-select>
                    </div>
                    <div
                        v-else-if="form.tipoReporte.value !== 2 && form.centrotrabajo_id?.title?.toLowerCase() === 'proyectos'"

                        class="xl:col-span-2 xs:col-span-1">
                        <label name="ot_id" class="dark:text-white"> Número de OT </label>
                        <v-select :options="props.losOT" label="nombre" class="dark:bg-gray-400"
                                  v-model="form.ot_id"
                        ></v-select>
                        <InputError class="mt-2" :message="form.errors['ordentrabajo_id']"/>
                    </div>
                    <div v-else-if="form.tipoReporte.value !== 2 
                    && form.centrotrabajo_id?.title?.toLowerCase() !== 'ofertas'
                         && form.centrotrabajo_id?.title?.toLowerCase() !== 'proyectos'"
                    >
                        Seleccione centro de trabajo
                    </div>


                    <div v-if="data.soloParaOfertas"
                         class="w-full xl:col-span-2 xs:col-span-1  dark:text-white">
                        <InputLabel :for="index" value="Cliente" class=""/>
                        <TextInput :id="index" type="text" disabled class="mt-1 block w-full bg-gray-200"
                                   :value="form.cliente"
                        />
                    </div>

                    <div v-if="data.soloParaOfertas"
                         class="w-full col-span-1 dark:text-white">
                        <InputLabel :for="index" value="% avance"/>
                        <TextInput :id="index" type="text" disabled class="mt-1 block w-full bg-gray-200"
                                   :value="form.avance"
                        />
                    </div>


                    <!-- tiempo estimado -->
                    <div v-if="data.soloParaOfertas"
                         class=" col-span-1 dark:text-white">
                        <InputLabel :for="index" value="Tiempo estimado"/>
                        <TextInput :id="index" type="text" disabled
                                   class="mt-1 block w-full bg-gray-200 dark:bg-gray-400 dark:text-white"
                                   v-model="form.TiempoEstimado"
                        />
                    </div>


                    <!-- eleccion -->
                    <div id="actividad" v-if="form.tipoReporte.value === 0 || form.tipoReporte.value === 1"
                         class="xl:col-span-2 col-span-1">
                        <label name="actividad_id" class=" dark:text-white"> Actividad </label>
                        <v-select :options="data['actividad_id']" label="title" required
                                  v-model="form['actividad_id']" class="dark:bg-gray-400"
                        ></v-select>
                        <InputError class="mt-2" :message="form.errors['actividad_id']"/>
                    </div>
                    <div id="reproceso" v-if="form.tipoReporte.value === 1" class="xl:col-span-2 col-span-1">
                        <label name="reproceso_id" class=" dark:text-white"> Reproceso</label>
                        <v-select :options="data['reproceso_id']" label="title" required
                                  v-model="form['reproceso_id']" class="dark:bg-gray-400"
                        ></v-select>
                        <InputError class="mt-2" :message="form.errors['reproceso_id']"/>
                    </div>
                    <div id="disponibilidad" v-if="form.tipoReporte.value === 2" class="xl:col-span-3  col-span-1">
                        <label name="disponibilidad_id" class=" dark:text-white"> Disponibilidad</label>
                        <v-select :options="data['disponibilidad_id']" label="title" required
                                  v-model="form['disponibilidad_id']" class="dark:bg-gray-400"
                        ></v-select>
                        <InputError class="mt-2" :message="form.errors['disponibilidad_id']"/>
                    </div>
                    <!-- termina -->
                </div>


                <div class=" mb-8 mt-[360px] flex justify-end">
                    <h2 v-if="data.mensajeFalta !== ''"
                        class="mx-12 px-8 text-lg font-medium text-red-600 bg-red-50 dark:text-red-400 dark:bg-gray-800">
                        {{ data.mensajeFalta }}
                    </h2>
                    <h2 v-if="data.mensajeTiemposAuto !== ''"
                        class="mx-12 px-8 text-lg font-medium text-gray-800 dark:text-white dark:bg-gray-800">
                        {{ data.mensajeTiemposAuto }}
                    </h2>

                    <SecondaryButton :disabled="form.processing" @click="emit('close')"> {{ lang().button.close }}
                    </SecondaryButton>
                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                   @click="create">
                        {{ form.processing ? lang().button.add + '...' : lang().button.add }}
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
