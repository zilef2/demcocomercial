<script setup>
import {useForm} from '@inertiajs/vue3';
import {onMounted, reactive, ref, watchEffect} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'
import "vue-select/dist/vue-select.css";
import {formatDate, number_format} from '@/global.ts';
import Newitem from "@/Pages/Item/Newitem.vue";
import CerrarYguardar from "@/Pages/Oferta/CerrarYguardar.vue";
import Add_Sub_equipos from "@/Pages/Item/Add_Sub_equipos.vue";
import Add_Sub_items from "@/Pages/Item/Add_Sub_items.vue";

// --------------------------- ** -------------------------

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
    titulos: Object, //parametros de la clase principal
    losSelect: Object,
    numberPermissions: Number,
})
const form = useForm({

    user_id: '',
    cargo: '',
    empresa: '',
    ciudad: '',
    proyecto: '',
    fecha: '',

    items: [],

})

const data = reactive({
    params: {
        pregunta: ''
    },
    valor_total_items: '',
    cantidades: '',
})
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

function actualizarValorTotal({index, cantidad, valor_total_item}) {
    data.valor_total_items[index] = valor_total_item;
    data.cantidades[index] = cantidad;
}

function actualizarItems(cantidad) {
    console.log('cantidad '+cantidad)
    while (form.items.length < cantidad) {
        form.items.push({equipo_id: null, cantidad: 1});
    }
    while (form.items.length > cantidad) {
        form.items.pop();
    }
}

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
                // emit("close")
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
        <form class="px-16 py-8 2xl:px-36 2xl:py-16" @submit.prevent="create">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Nueva oferta</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Agrege tantos items necesite para la oferta</p>
            </div>
            <Add_Sub_items 
                :initialEquipos="form.items.length"
                 @updateItems="actualizarItems"/>
                    <hr class="border-[1px] border-black my-6 col-span-full"/>


            <Newitem
                v-for="(item, index) in form.items"
                :key="index"
                :valorUnitario="item.equipo_id?.Valor_Unit ?? 0"
                :initialCantidad="item.cantidad ?? 1"
                :errors="form.errors"
                :index="index"
                :losSelect="losSelect"
                @update="actualizarValorTotal"
            />
            <Add_Sub_items v-if="form.items.length > 2" 
                        :initialEquipos="form.items.length"
                        @updateItems="actualizarItems"/>

            <CerrarYguardar :ruta="'Oferta.index'" :formProcessing="form.processing" @create="create"/>

            <h2 class="mx-auto text-center text-2xl font-medium text-gray-900 dark:text-gray-100 mt-36">
                Últimas actualizaciones de equipos
            </h2>
            <div class="w-full my-8 px-2 2xl:px-16">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y-2 divide-gray-200">
                        <thead class="ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white">
                            <th class="px-3 py-2 whitespace-nowrap">Código</th>
                            <th class="px-3 py-2 whitespace-nowrap">Descripción</th>
                            <th class="px-3 py-2 whitespace-nowrap">Tipo Fabricante</th>
                            <th class="px-3 py-2 whitespace-nowrap">Referencia Fabricante</th>
                            <th class="px-3 py-2 whitespace-nowrap">Marca</th>
                            <th class="px-3 py-2 whitespace-nowrap">Unidad de Compra</th>
                            <th class="px-3 py-2 whitespace-nowrap">Precio de Lista</th>
                            <th class="px-3 py-2 whitespace-nowrap">Última Actualización</th>
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
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['Tipo Fabricante'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['Referencia Fabricante'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['Marca'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ equipo['Unidad de Compra'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ number_format(equipo['Precio de Lista'], 0, 1) }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ formatDate(equipo['Fecha actualizacion']) }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <CerrarYguardar
                :ruta="'Oferta.index'"
                :formProcessing="form.processing"
                @create="create"
            />

        </form>
    </section>
</template>