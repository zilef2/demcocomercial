<script setup type="module">

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, usePage} from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import {reactive, watch} from 'vue';
import pkg from 'lodash';
import Pagination from '@/Components/Pagination.vue';
import {ChevronUpDownIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/solid';
import DeleteBulk from '@/Pages/Oferta/DeleteBulk.vue';
import Delete from '@/Pages/Oferta/Delete.vue';
import Detalle from '@/Pages/Oferta/Detalle.vue';
import Checkbox from '@/Components/Checkbox.vue';
import {formatDate, number_format} from '@/global.ts';
import {Link} from '@inertiajs/vue3'


const {_, debounce, pickBy} = pkg
const props = defineProps({
    fromController: Object,
    total: Number,
    filters: Object,
    breadcrumbs: Object,
    perPage: Number,

    title: String,

    numberPermissions: Number,
    losSelect: Object,//normally used by headlessui
})

const data = reactive({
    params: {
        search: props.filters.search,
        // search2: props.filters.search2,
        //   search3: props.filters.search3,
        field: props.filters.field,
        order: props.filters.order,
        perPage: props.perPage,
    },
    DetalleOpen: false,
    eldetalle: null,
    Ofertao: null,
    selectedId: [],
    multipleSelect: false,
    deleteOpen: false,
    deleteBulkOpen: false,
    dataSet: usePage().props.app.perpage,
})

// <!--<editor-fold desc="order, watchclone, select">-->
const order = (field) => {
    data.params.field = field
    data.params.order = data.params.order === "asc" ? "desc" : "asc"
}

watch(() => _.cloneDeep(data.params), debounce(() => {
    let params = pickBy(data.params)
    router.get(route("Oferta.index"), params, {
        replace: true,
        preserveState: true,
        preserveScroll: true,
    })
}, 150))

const selectAll = (event) => {
    if (event.target.checked === false) {
        data.selectedId = []
    } else {
        props.fromController?.data.forEach((Oferta) => {
            data.selectedId.push(Oferta.id)
        })
    }
}
const select = () => data.multipleSelect = props.fromController?.data.length === data.selectedId.length;

// <!--</editor-fold>-->


// const form = useForm({ })
// watchEffect(() => { })


// text - string // number // dinero // date // datetime // foreign
const titulos = [
    {order: 'codigo_oferta', label: 'codigo_oferta', type: 'text'},
    {order: 'cliente', label: 'Cliente', type: 'text'},
    {order: 'proyecto', label: 'proyecto', type: 'text'},
    {order: 'TotalOferta', label: 'TotalOferta', type: 'dinero'},
    {order: 'Userino', label: 'user_id', type: 'foreign', nameid: 'Userino'},
    {order: 'cargo', label: 'cargo', type: 'text'},
    {order: 'empresa', label: 'empresa', type: 'text'},
    {order: 'ciudad', label: 'ciudad', type: 'text'},
    {order: 'fecha', label: 'fecha', type: 'date'},
];

function abrirPDF(claseFromController) {
    if (!claseFromController || !claseFromController.id) {
        console.error('claseFromController no definido');
        return;
    }
    window.open(route('Oferta.pdf', claseFromController.id), '_blank');
    // window.location.href = route('Oferta.pdf', claseFromController.id);
}


</script>

<template>
    <Head :title="props.title"/>

    <AuthenticatedLayout>
        <Breadcrumb :title="title" :breadcrumbs="breadcrumbs" class="capitalize text-xl font-bold"/>
        <div class="space-y-4">
            <div class="px-4 sm:px-0">
                <div class="rounded-lg overflow-hidden w-fit">
                    <Link class="rounded-none" href="/NuevaOferta/1" v-if="can(['create oferta'])">
                        <PrimaryButton class="rounded-none"> Oferta plantilla 1</PrimaryButton>
                    </Link>
<!--                    <Link class="rounded-none" href="/NuevaOferta/2" v-if="can(['create oferta'])">-->
<!--                        <PrimaryButton class="rounded-none px-1"> Oferta pruebas</PrimaryButton>-->
<!--                    </Link>-->


                    <Delete v-if="can(['delete oferta'])" :numberPermissions="props.numberPermissions"
                            :show="data.deleteOpen" @close="data.deleteOpen = false" :Ofertaa="data.Ofertao"
                            :title="props.title"></Delete>
                    <Detalle :show="data.DetalleOpen" :eldetalle="data.eldetalle"
                             @close="data.DetalleOpen=false"
                             :title="props.title" maintitle="Oferta"
                    ></Detalle>
                    <DeleteBulk v-if="can(['delete oferta'])" :show="data.deleteBulkOpen"
                                @close="data.deleteBulkOpen = false, data.multipleSelect = false, data.selectedId = []"
                                :selectedId="data.selectedId" :title="props.title"/>
                </div>
            </div>
            <div class="relative bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between p-2">
                    <div class="flex space-x-2">
                        <SelectInput v-model="data.params.perPage" :dataSet="data.dataSet"/>
                        <DangerButton @click="data.deleteBulkOpen = true"
                                      v-show="data.selectedId.length != 0 && can(['delete oferta'])" class="px-3 py-1.5"
                                      v-tooltip="lang().tooltip.delete_selected">
                            <TrashIcon class="w-5 h-5"/>
                        </DangerButton>
                    </div>
                    <TextInput v-model="data.params.search" type="text"
                               class="block w-4/6 md:w-3/6 lg:w-2/6 rounded-lg"
                               placeholder="Código, empresa o proyecto"/>
                </div>
                <div class="overflow-x-auto scrollbar-table">
                    <table v-if="props.total > 0" class="w-full">
                        <thead class="uppercase text-sm border-t border-gray-200 dark:border-gray-700">
                        <tr class="dark:bg-gray-900/50 text-left">
                            <th class="px-2 py-4 text-center">
                                <Checkbox v-model:checked="data.multipleSelect" @change="selectAll"/>
                            </th>
                            <th class="px-2 py-4">Accion</th>

                            <th class="px-2 py-4 text-center">#</th>
                            <th v-for="titulo in titulos" class="px-2 py-4 cursor-pointer"
                                v-on:click="order(titulo['order'])">
                                <div class="flex justify-between items-center">
                                    <span>{{ lang().label[titulo['label']] }}</span>
                                    <ChevronUpDownIcon class="w-4 h-4"/>
                                </div>
                            </th>
                            <th class="px-2 py-4 cursor-pointer">
                                <div class="flex justify-between items-center">
                                    <span>Ver detalles</span>
                                    <ChevronUpDownIcon class="w-4 h-4"/>
                                </div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(claseFromController, indexu) in props.fromController.data" :key="indexu"
                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-200/30 hover:dark:bg-gray-900/20">

                            <td class="whitespace-nowrap py-4 px-2 sm:py-3 text-center">
                                <input
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary dark:text-primary shadow-sm focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-gray-800 dark:checked:bg-primary dark:checked:border-primary"
                                    type="checkbox" @change="select" :value="claseFromController.id"
                                    v-model="data.selectedId"/>
                            </td>
                            <td class="whitespace-nowrap py-4 w-12 px-2 sm:py-3">
                                <div class="justify-center items-center">
                                    <div class="inline-flex rounded-md shadow-sm" role="group">
<!--                                        <Link-->
<!--                                            :href="'/EditOferta/' + claseFromController.id"-->
<!--                                            v-show="can(['update oferta'])"-->
<!--                                            class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-200-->
<!--                                             rounded-l-lg hover:bg-indigo-500 focus:z-10 focus:ring-1-->
<!--                                              focus:ring-indigo-800 focus:border-indigo-800 hover:text-white"-->
<!--                                        >-->
<!--                                            <span class="flex items-center">-->
<!--                                                <PencilIcon class="w-4 h-4 mr-1"/>-->
<!--                                                <span>Editar</span>-->
<!--                                            </span>-->
<!--                                        </Link>-->

                                        
                                        
<!--                                        <Link-->
<!--                                            :href="'/ContinueOferta/' + claseFromController.id"-->
<!--                                            v-if="can(['create oferta'])"-->
<!--                                            class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-200 hover:bg-indigo-500 focus:z-10 focus:ring-1 focus:ring-indigo-800 focus:border-indigo-800 hover:text-white"-->
<!--                                        >-->
<!--                                            <span class="flex items-center">-->
<!--                                                <PencilIcon class="w-4 h-4 mr-1"/>-->
<!--                                                <span>Continuar</span>-->
<!--                                            </span>-->
<!--                                        </Link>-->

                                        <!-- Botón de PDF -->
                                        <button
                                            @click.prevent="abrirPDF(claseFromController)"
                                            class="px-3 py-1.5 text-sm font-medium text-gray-700
                                             bg-white border-t border-b border-r border-gray-200 rounded-r-lg
                                              hover:bg-indigo-500 hover:text-white 
                                              focus:z-10 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                            v-tooltip="'Descargar PDF'"
                                        >
                                            Descargar PDF
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap py-4 px-2 sm:py-3 text-center">{{ ++indexu }}</td>
                            <td v-for="titulo in titulos" class="whitespace-nowrap py-4 px-2 sm:py-3">
                                <span v-if="titulo['type'] === 'text' || titulo['type'] === 'string'"> {{
                                        claseFromController[titulo['order']]
                                    }} </span>
                                <span v-if="titulo['type'] === 'number'"> {{
                                        number_format(claseFromController[titulo['order']], 0, false)
                                    }} </span>
                                <span v-if="titulo['type'] === 'dinero'"> {{
                                        number_format(claseFromController[titulo['order']], 0, true)
                                    }} </span>
                                <span v-if="titulo['type'] === 'date'"> {{
                                        formatDate(claseFromController[titulo['order']], false)
                                    }} </span>
                                <span v-if="titulo['type'] === 'datetime'"> {{
                                        formatDate(claseFromController[titulo['order']], true)
                                    }} </span>
                                <span v-if="titulo['type'] === 'foreign'">
                                        {{ claseFromController?.[titulo?.['nameid']] ?? '' }}
                                    </span>
                            </td>
                            <td v-tooltip="lang().tooltip.v_alfa"
                                @click="(data.DetalleOpen = true), (data.eldetalle = claseFromController)"
                                class="whitespace-nowrap py-4 px-2 sm:py-3 cursor-pointer text-blue-600 dark:text-blue-400 font-bold underline">
                                {{ claseFromController.QuantityItems }} Items
                            </td>

                        </tr>
                        <tr class="border-t border-gray-600">
                            <td v-if="numberPermissions > 1"
                                class="whitespace-nowrap py-4 w-12 px-2 sm:py-3 text-center"> -
                            </td>
                            <td class="whitespace-nowrap py-4 px-2 sm:py-3 text-center"> Total:</td>
                            <td class="whitespace-nowrap py-4 px-2 sm:py-3 text-center">
                                {{ props.total }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h2 v-else class="text-center text-xl my-8">Sin Registros</h2>
                </div>
                <div v-if="props.total > 0"
                     class="flex justify-between items-center p-2 border-t border-gray-200 dark:border-gray-700">
                    <Pagination :links="props.fromController" :filters="data.params"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
