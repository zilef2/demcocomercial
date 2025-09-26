<script setup>
import {nextTick, reactive, watch, computed} from 'vue';
// import {router, usePage} from '@inertiajs/vue3';
import {formatPesosCol, number_format} from '@/global.ts';
// import {ChevronUpDownIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/solid';
import Modal from "@/Components/Modal.vue";


const props = defineProps({
    show: {
        type: Boolean,
        default: true,
    },
});

// aquiiii
const valorequipo19 = 5480.475

// Opciones de calibre (display y valor)











const calibres = [
    {label: '12 (25A)', value: 3143},
    {label: '10 (35A)', value: 4935},
    {label: '8 (50A)', value: 7977},
    {label: '6 (65A)', value: 12275},
    {label: '4 (85A)', value: 19911},
    {label: '2 (115A)', value: 30081},
    {label: '1/0 (150A)', value: 49604},
    {label: '2/0 (175A)', value: 62218},
    {label: '4/0 (230A)', value: 96249}
]

const data = reactive([
  { descripcion: 'CONTADOR 3F (TRIFÁSICO)', cant: 2, mts: 10, calibre: null },
  { descripcion: 'CONTADOR 3F (TRIFÁSICO)', cant: 1, mts: 10, calibre: null },
  { descripcion: 'CONTADOR 3F (TRIFÁSICO)', cant: 0, mts: 10, calibre: null },

  { descripcion: 'CONTADOR 3F (TRIFÁSICO ELECTRICARIBE)', cant: 0, mts: 8, calibre: null },
  { descripcion: 'CONTADOR 3F (TRIFÁSICO ELECTRICARIBE)', cant: 0, mts: 8, calibre: null },
  { descripcion: 'CONTADOR 3F (TRIFÁSICO ELECTRICARIBE)', cant: 0, mts: 8, calibre: null },

  { descripcion: 'CONTADOR 2F (BIFASICO)', cant: 1, mts: 7, calibre: null },
  { descripcion: 'CONTADOR 2F (BIFASICO)', cant: 1, mts: 7, calibre: null },

  { descripcion: 'CONTADOR 2F (BIFASICO ELECTRICARIBE)', cant: 0, mts: 5.5, calibre: null },
  { descripcion: 'CONTADOR 2F (BIFASICO ELECTRICARIBE)', cant: 0, mts: 5.5, calibre: null },

  { descripcion: 'CONTADOR 1F (TRIFÁSICO)', cant: 0, mts: 7, calibre: null },

  { descripcion: 'PEINE PRIMERA BANDEJA', cant: 1, mts: 0, calibre: null },
  { descripcion: 'PEINE SEGUNDA BANDEJA', cant: 2, mts: 0, calibre: null },
  { descripcion: 'PEINE TERCERA BANDEJA', cant: 3, mts: 0, calibre: null },

  { descripcion: 'INTERRUPTORES PRIMERA BANDEJA', cant: 1, mts: 0, calibre: null },
  { descripcion: 'INTERRUPTORES SEGUNDA BANDEJA', cant: 2, mts: 0, calibre: null },
  { descripcion: 'INTERRUPTORES TERCERA BANDEJA', cant: 3, mts: 0, calibre: null },

  { descripcion: 'DPS', cant: 2, mts: 0, calibre: null },

  { descripcion: 'MINIBREAKER 3P', cant: 2, mts: 3, calibre: null },
  { descripcion: 'MINIBREAKER 2P', cant: 1, mts: 0.5, calibre: null },
  { descripcion: 'MINIBREAKER 1P', cant: 1, mts: 0.3, calibre: null },

  { descripcion: 'UPS Y TRANSFORMADOR BAJA', cant: 1, mts: 25, calibre: null },

  { descripcion: 'OTROS:', cant: 2, mts: 0, calibre: null }
])

// Calculo vl unitario
const calcVLUnitario = (row) => {
    if (!row.calibre) return 0
    return (2 * valorequipo19 + row.calibre * row.mts) * 1.43
}

// Calculo total por fila
const calcTotal = (row) => {
    return calcVLUnitario(row) * row.cant
}

// Subtotal general
const subtotal = computed(() =>
    data.reduce((acc, row) => acc + calcTotal(row), 0)
)


//aqui se empieza el otro script 

const emit = defineEmits(['close', 'confirm'])

function calvalorunidad() {
    nextTick()
    data.valorunidad = (Math.floor(data.metros * data.valor * data.precioequipo) + 3832.5) * 1.43
    data.total = data.valorunidad * data.cantidad
}

function calcularCalibre(amperaje) {
    if (amperaje <= 25) return 12;
    if (amperaje <= 35) return 10;
    if (amperaje <= 50) return 8;
    if (amperaje <= 65) return 6;
    if (amperaje <= 85) return 4;
    if (amperaje <= 115) return 2;
    return null; // fuera de rango
}


watch([
    () => data.cantidad,
    () => data.metros,
    () => data.valor,
    () => data.corriente,
], () => {
    calvalorunidad()
})

watch(() => data.corriente, (new_corriente) => {
    data.calibre = calcularCalibre(new_corriente)
})
const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Modal @close="closeModal" :show="show" :maxWidth="'xl5'">
        <div class="min-h-max bg-gray-50 flex flex-col items-center py-10 px-4 mt-4">
            <!-- Encabezado -->
            <header class="mb-10 text-center max-w-2xl">
                <h1 class="text-slate-800 text-3xl sm:text-4xl font-bold tracking-tight">
                    Calculo del <span class="text-indigo-600">Cableado de Potencia</span>
                </h1>
<!--                <p class="text-md mt-2 text-gray-600">Ejemplo ilustrativo para calibre 6</p>-->
                <p class="text-sm mt-1 text-gray-500">Referencias: 1.1 y 1.3</p>
            </header>

            <!-- Card principal -->
            <div class="p-4">
                <table class="w-full border border-gray-300 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-2 py-1">DESCRIPCION</th>
                        <th class="border px-2 py-1">CANT</th>
                        <th class="border px-2 py-1">MTS</th>
                        <th class="border px-2 py-1">CALIBRE</th>
                        <th class="border px-2 py-1">V/L UNIT.</th>
                        <th class="border px-2 py-1">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, idx) in data" :key="idx">
                        <td class="border px-2 py-1">{{ row.descripcion }}</td>
                        <td class="border px-2 py-1">
                            <input type="number" v-model.number="row.cant" class="w-16 border rounded text-center"/>
                        </td>
                        <td class="border px-2 py-1">
                            <input type="number" v-model.number="row.mts" class="w-16 border rounded text-center"/>
                        </td>
                        <td class="border max-w-64 min-w-32 px-2 py-1">
                            <select v-model="row.calibre" class="border rounded px-1  max-w-60 min-w-32">
                                <option :value="null">--</option>
                                <option v-for="c in calibres" :key="c.value" :value="c.value">
                                    {{ c.label }}
                                </option>
                            </select>
                        </td>
                        <td class="border px-2 py-1 text-right">
                            {{ formatPesosCol(calcVLUnitario(row)) }}
                        </td>
                        <td class="border px-2 py-1 text-right">
                            {{ formatPesosCol(calcTotal(row)) }}
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="5" class="border px-2 py-1 text-right">TOTAL</td>
                        <td class="border px-2 py-1 text-right">
                            {{ formatPesosCol(subtotal) }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </Modal>
</template>

