<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { reactive, watch, watchEffect,onMounted } from 'vue';
import pkg from 'lodash';
import { useForm, router } from '@inertiajs/vue3';

import { BookOpenIcon, ArrowUpCircleIcon, ArrowDownCircleIcon } from '@heroicons/vue/24/solid';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


const { _, debounce, pickBy } = pkg
const props = defineProps({
    title: String,
    // fromController: Object,
    breadcrumbs: Object,
    NumEquipos: Number,
    NumReportes: Number,
    ini: Date,
    fin: Date,
    flash: String,
    NumReportesRecha: Number,
    NumReportesSinval: Number,
    haySinsalario: Number,

    //sigo
    NumReportesSigo: Number,
    NumReportesRechaSigo: Number,
    NumReportesSinvalSigo: Number,
    NumProveedores: Number,
    UltimosProveedores: Object,
})

const data = reactive({
    respuesta: '',
    params:{
        fecha_ini: '',
        quincena: '',
        arrayFestivos: '',
    },
    paramsSigo:{
        fecha_ini: '',
        quincena: '',
        arrayFestivos: '',
        year: '',
        month: '',
    },
    warnn:'',
    tiposSiigo:[],

})

onMounted(() => { });

watch(() => _.cloneDeep(data.params), debounce(() => {
        let params = pickBy(data.params)
        router.get(route("user.uploadexcel"), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
    }, 30)
)
watch(() => _.cloneDeep(data.paramsSigo), debounce(() => {
        let paramsS = pickBy(data.paramsSigo)
        router.get(route("user.uploadexceSigo"), paramsS, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
    }, 30)
)


//formulario para importar usuarios
const formUp = useForm({
    archivo1: null,
});
const formProveedores = useForm({
    archivo2: null,
});
//formulario para exportar el informe quincenal


// watch(() => form.fecha_ini, (newX) => {})


// watch(() => form2.fecha_ini_sigo, (newX) => {
//       // data.paramsSigo.year = newX.year
// })


watchEffect(() => {
})

function uploadFile() {
    formUp.post(route('EquipoUploadExcelPost'), {
        preserveScroll: true,
        onSuccess: () => {
            // emit("close")
            // form.reset()
            // data.respuesta = $page.props.flash.success
        },
        onError: () => null,
        onFinish: () => null,
    });
}
function uploadFil2() {
    formProveedores.post(route('ProveedoresUploadExcel'), {
        preserveScroll: true,
        onSuccess: () => {
            // emit("close")
            // form.reset()
            // data.respuesta = $page.props.flash.success
        },
        onError: () => null,
        onFinish: () => null,
    });
}


// const downloadExcel = () => { window.open('users/export/' + form.NumeroDiasFestivos + '/' + form.quincena + '/' + (form.fecha_ini.month) + '/' + form.fecha_ini.year, '_blank') }
const columnasImportarUser = [
    {value: 'Codigo', rule: 'Único'},
    {value: 'Descripcion', rule: 'Requerida'},
    {value: 'Tipo Fabricante', rule: 'Requerida'},
    {value: 'Referencia Fabricante', rule: 'Requerida'},
    {value: 'Marca', rule: 'Requerida'},
    {value: 'Unidad de Compra', rule: 'Requerida'},
    {value: 'Precio de Lista', rule: 'Requerida'},
    {value: 'Fecha actualizacion', rule: 'Requerida'},
    {value: 'Descuento Basico', rule: 'Requerida'},
    {value: 'Descuento Proyectos', rule: 'Requerida'},
    {value: 'Precio con Descuento', rule: 'Requerida'},
    {value: 'Precio con Descuento Proyecto', rule: 'Requerida'},
    {value: 'Precio Ultima Compra', rule: 'Opcional'},
    {value: 'Precios de Listas', rule: 'Opcional'},
    {value: 'Clasificacion 2 Inventario', rule: 'Opcional'},
    {value: 'Ruta Tiempos', rule: 'Requerida'},
    {value: 'Tiempos Chapisteria', rule: 'Opcional'},
    {value: 'habilitado', rule: 'Obligatorio (1 o 0)'},
];
const columnasImportarProveedores2 = [
    {value: 'PROVEEDOR 1', rule: 'Opcional'},
    {value: 'PROVEEDOR 2', rule: 'Opcional'},
    {value: 'PROVEEDOR 3', rule: 'Opcional'},
    {value: 'PROVEEDOR 4', rule: 'Opcional'},
    {value: 'PROVEEDOR 5', rule: 'Opcional'},
    {value: 'PROVEEDOR 6', rule: 'Opcional'},
];

// <!--</editor-fold>-->

</script>

<template>
    <Head :title="props.title"></Head>
    <AuthenticatedLayout>
        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" />
        <div class="space-y-4">

            <div v-if="data.warnn" class="px-4 sm:px-0">
                <div class="rounded-lg overflow-hidden w-fit">
                    <div class="flex max-w-screen-xl shadow-lg rounded-lg">
                        <div class="bg-yellow-600 py-4 px-6 rounded-l-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="fill-current text-white" width="20" height="20"> <path fill-rule="evenodd" d="M8.22 1.754a.25.25 0 00-.44 0L1.698 13.132a.25.25 0 00.22.368h12.164a.25.25 0 00.22-.368L8.22 1.754zm-1.763-.707c.659-1.234 2.427-1.234 3.086 0l6.082 11.378A1.75 1.75 0 0114.082 15H1.918a1.75 1.75 0 01-1.543-2.575L6.457 1.047zM9 11a1 1 0 11-2 0 1 1 0 012 0zm-.25-5.25a.75.75 0 00-1.5 0v2.5a.75.75 0 001.5 0v-2.5z"> </path> </svg>
                        </div>
                        <div
                            class="px-8 py-6 bg-white rounded-r-lg flex justify-between items-center w-full border border-l-transparent border-gray-200">
                            <div>{{ data.warnn ? data.warnn : '' }}</div>
                            <!-- <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-gray-700" viewBox="0 0 16 16" width="20" height="20"> <path fill-rule="evenodd" d="M3.72 3.72a.75.75 0 011.06 0L8 6.94l3.22-3.22a.75.75 0 111.06 1.06L9.06 8l3.22 3.22a.75.75 0 11-1.06 1.06L8 9.06l-3.22 3.22a.75.75 0 01-1.06-1.06L6.94 8 3.72 4.78a.75.75 0 010-1.06z"> </path> </svg>
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-12 mx-auto">
                        <div v-if="can(['isAdmin'])" class="flex flex-wrap -m-4">

                            <!-- subir -->
                            <div class="p-4 w-full sm:w-1/2 2xl:w-1/2">
                                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                    <ArrowUpCircleIcon class=" h-24 lg:h-48 md:h-36 w-full object-cover object-center bg-amber-100" />

                                    <div class="p-6">
                                        <h3 class="mx-auto  text-center title-font text-xl font-medium text-gray-900 mb-2 dark:text-white dark:bg-gray-800">Subir Equipos</h3>
                                        <h2 class="mb-4 tracking-widest text-center text-sm title-font font-medium text-gray-400 dark:text-gray-100">Formato xlsx</h2>
                                        <p class="leading-relaxed mb-3 dark:text-white dark:bg-gray-800"> Este formulario necesita la lista de proveedores actualizada, antes de subir los Equipos</p>
                                        <p class="leading-relaxed my-2 dark:text-white dark:bg-gray-800"> El archivo no debe pesar mas de 8MB</p>
                                        <form @submit.prevent="uploadFile" id="upload" class="my-6">
                                            <input type="file" @input="formUp.archivo1 = $event.target.files[0]"
                                                   accept="application/vnd.openxmlformUpats-officedocument.spreadsheetml.sheet" class=" dark:text-white dark:bg-gray-800" />
                                            <progress v-if="formUp.progress" :value="formUp.progress.percentage" max="100" class="rounded-lg mx-auto">
                                                {{ formUp.progress.percentage }}%
                                            </progress>

                                            <div class="w-full">
                                                <PrimaryButton v-show="can(['create user'])" :disabled="formUp.archivo1 == null"
                                                               class="rounded-xl my-4 mouse-pointer">
                                                    {{ lang().button.subir }}
                                                </PrimaryButton>
                                            </div>
                                        </form>

                                        <div class="flex items-center flex-wrap my-6">
                                            <div class="grid grid-cols-1">
                                                <a class="text-gray-500 items-center text-lg md:mb-2 lg:mb-0">
                                                    Numero de Equipos: <span class=" text-indigo-600 dark:text-indigo-200 dark:bg-gray-800">{{props.NumEquipos}}</span> 
                                                </a>
                                            </div>

                                            <section class="text-gray-600 body-font">
                                                <div class="container p-5 mx-auto">
                                                    <div class="text-center mb-1">
                                                        <h1 class="text-xl font-medium text-center title-font text-gray-900 mb-4 dark:text-white dark:bg-gray-800">
                                                            Si subes una hoja o pestaña adicional de Proveedores, debe llamarse PROVEDORES
                                                        </h1>
                                                        <p class="text-base leading-relaxed w-full mx-auto  dark:text-white dark:bg-gray-800">
                                                            Solo la primera fila debe ser como se muestra:
                                                        </p>
                                                    </div>
                                                    <div class="flex flex-wrap sm:mx-auto sm:mb-2 -mx-2 dark:text-white dark:bg-gray-800">
                                                        <div v-for="columna in columnasImportarUser" class="px-2 w-full">
                                                            <div class="bg-gray-50 rounded flex p-1 h-full items-center dark:text-white dark:bg-gray-800">
                                                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"> <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path> <path d="M22 4L12 14.01l-3-3"></path> </svg>
                                                                <span class="title-font font-medium">
                                                                      {{columna.value}} : {{ columna.rule }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="can(['isSuper'])" class="p-4 w-full sm:w-1/2 2xl:w-1/2">
                                solo super
                                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                    <ArrowUpCircleIcon class=" h-24 lg:h-48 md:h-36 w-full object-cover object-center bg-indigo-100" />

                                    <div class="p-6">
                                        <h3 class="mx-auto  text-center title-font text-xl font-medium text-gray-900 mb-2 dark:text-white dark:bg-gray-800">Subir Proveedores</h3>
                                        <h2 class="mb-4 tracking-widest text-center text-sm title-font font-medium text-gray-400 dark:text-gray-100">Formato xlsx</h2>
                                        <p class="leading-relaxed my-2 dark:text-white dark:bg-gray-800"> El archivo no debe pesar mas de 8MB</p>
                                        <form @submit.prevent="uploadFil2" id="upload" class="my-6">
                                            <input type="file" @input="formProveedores.archivo2 = $event.target.files[0]"
                                                   accept="application/vnd.openxmlformUpats-officedocument.spreadsheetml.sheet" class=" dark:text-white dark:bg-gray-800" />
                                            <progress v-if="formUp.progress" :value="formUp.progress.percentage" max="100" class="rounded-lg mx-auto">
                                                {{ formUp.progress.percentage }}%
                                            </progress>

                                            <div class="w-full">
                                                <PrimaryButton v-show="can(['create user'])" :disabled="formUp.archivo2 == null"
                                                               class="rounded-xl my-4 mouse-pointer">
                                                    {{ lang().button.subir }}
                                                </PrimaryButton>
                                            </div>
                                        </form>

                                        <div class="flex items-center flex-wrap my-6">
                                            <div class="grid grid-cols-1">
                                                <a class="text-gray-500 items-center text-lg md:mb-2 lg:mb-0">
                                                    Numero de Proveedores: <span class=" text-indigo-600 dark:text-indigo-200 dark:bg-gray-800">{{props.NumProveedores}}</span> 
                                                </a>
                                            </div>

                                            <section class="text-gray-600 body-font">
                                                <div class="container p-5 mx-auto">
                                                    <div class="text-center mb-1">
                                                        <h1 class="text-xl font-medium text-center title-font text-gray-900 mb-4 dark:text-white dark:bg-gray-800">
                                                            Formato del excel
                                                        </h1>
                                                        <p class="text-base leading-relaxed w-full mx-auto  dark:text-white dark:bg-gray-800">
                                                            Solo la primera fila debe ser como se muestra:
                                                        </p>
                                                    </div>
                                                    <div class="flex flex-wrap sm:mx-auto sm:mb-2 -mx-2 dark:text-white dark:bg-gray-800">
                                                        <div v-for="columna in columnasImportarProveedores2" class="px-2 w-full">
                                                            <div class="bg-gray-50 rounded flex p-1 h-full items-center dark:text-white dark:bg-gray-800">
                                                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"> <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path> <path d="M22 4L12 14.01l-3-3"></path> </svg>
                                                                <span class="title-font font-medium">
                                                                      {{columna.value}} : {{ columna.rule }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
