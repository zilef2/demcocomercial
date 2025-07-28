<script setup>
import {useForm} from '@inertiajs/vue3';
import {reactive, onMounted, watch, nextTick} from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'


// --------------------------- ** -------------------------

// const props = defineProps(['modelValue']);
const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },
  //to learn
  // cargo: {
  //   type: [String],
  //   // type: [String, Object, Number], // depende del tipo que estás pasando
  //   required: false
  // }
});


const emit = defineEmits(['update:modelValue']);
const form = reactive({
    ...props.modelValue
});

const textoIntroducturio = 'DEMCO INGENIERÍA, es una empresa dinámica dedicada al diseño, construcción y puesta en servicio de subestaciones y tableros eléctricos en media y baja tensión, desarrollando proyectos con altas especificaciones en ingeniería, en alianza con reconocidas empresas'

onMounted(() => {
    nextTick()
        // form.empresa = ''
        // form.ciudad = ''
        // form.proyecto = ''
        form.cargo = props.modelValue.cargo
        form.empresa = props.modelValue.empresa
        form.ciudad = props.modelValue.ciudad
        form.proyecto = props.modelValue.proyecto
        console.log("🚀 ~  ~ props.modelValue: ", props.modelValue);
});


watch(form, (newValue) => {
    emit('update:modelValue', newValue);
}, { deep: true });

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
    <div class="flex gap-4 items-center my-1">
        <div class="max-w-5xl mx-auto px-6 py-2 bg-white rounded-xl shadow-md dark:bg-gray-800">
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
