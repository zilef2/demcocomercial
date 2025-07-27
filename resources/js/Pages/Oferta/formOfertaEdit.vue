<script setup>
import {useForm} from '@inertiajs/vue3';
import {reactive, onMounted, watch} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'


// --------------------------- ** -------------------------

// const props = defineProps({
//     textoIntroducturio: {
//         type: String
//     },
// });
const props = defineProps({
  dataOferta: Object,
cargo,String
});
const emit = defineEmits(['update:modelValue']);

// const form = reactive({
//     ...props.modelValue
// });

const form = useForm({
    codigo_oferta: String,
    descripcion: String,
    cargo: String,
    empresa: String,
    ciudad: String,
    proyecto: String,
})
const textoIntroducturio = 'DEMCO INGENIERÍA, es una empresa dinámica dedicada al diseño, construcción y puesta en servicio de subestaciones y tableros eléctricos en media y baja tensión, desarrollando proyectos con altas especificaciones en ingeniería, en alianza con reconocidas empresas'

onMounted(() => {
    
        form.codigo_oferta = props.dataOferta.codigo_oferta
        form.descripcion =  props.dataOferta.descripcion
        form.ciudad =  props.dataOferta.ciudad
        form.proyecto =  props.dataOferta.proyecto
        form.cargo = props.cargo //viene de user
        form.empresa =  props.dataOferta.empresa
});


watch(form, (newValue) => {
    emit('update:modelValue', newValue);
}, { deep: true });


// watch(() => props.dataOferta, () => {
//        
//     },
//     {deep: true, immediate: true}
// );
// watch(() => form, (nuevoForm) => {
//     emit('updateFormInicial', { nuevoForm: nuevoForm });
// }, { deep: true });
// function emitirFormManual() {
//     emit('updateFormInicial', { nuevoForm: form });
// }
//
// defineExpose({
//     emitirFormManual
// });

</script>

<template>
<!--     <pre class="mt-24">{{props.dataOferta.codigo_oferta}}</pre>-->
    
    <div class="flex gap-4 items-center my-1">
        <div class="max-w-5xl mx-auto px-6 py-2 bg-white rounded-xl shadow-md dark:bg-gray-800
                    border-t-2 border-indigo-600">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Crear Nueva Oferta</h2>

            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="codigo_oferta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código de Oferta</label>
                        <input type="text"
                            id="codigo_oferta"
                            v-model="form.codigo_oferta"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                            required
                        />
                    </div>
                    <!-- Empresa -->
                    <div>
                        <label for="empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Empresa</label>
                        <input
                            type="text"
                            id="empresa"
                            v-model="form.empresa"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                            required
                        />
                    </div>

                    <!-- Ciudad -->
                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ciudad</label>
                        <input
                            type="text"
                            id="ciudad"
                            v-model="form.ciudad"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                            required
                        />
                    </div>
                </div>

                <!-- Tercera fila -->
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <!-- Descripción -->
                    <div>
                        <label for="descripcion"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea
                            id="descripcion"
                            v-model="form.descripcion"
                            rows="3"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                        ></textarea>
                    </div>
                </div>

                <!-- Cuarta fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 mb-6">
                    <!-- Cargo -->
                    <div>
                        <label for="cargo"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cargo</label>
                        <input
                            type="text"
                            id="cargo"
                            v-model="form.cargo"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                        />
                    </div>

                    <!-- Proyecto -->
                    <div class="2xl:col-span-2">
                        <label for="proyecto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proyecto</label>
                        <input
                            type="text"
                            id="proyecto"
                            v-model="form.proyecto"
                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#74bc1f]"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label for="proyecto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{textoIntroducturio}}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
