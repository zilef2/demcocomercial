<template>
  <div v-if="props.errors.length" class="max-w-lg mx-auto mt-4">
    <div
      class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-md animate-fade-in-down transition-all duration-300 ease-out"
    >
      <div class="flex items-start gap-3">
        <div>
          <h3 class="font-semibold text-red-800 mb-1">Se encontraron los siguientes errores: ️</h3>
          <ul class="list-disc list-inside space-y-1 text-sm">
            <li v-for="(error, index) in props.errors" :key="index">{{ error }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const props = defineProps({
    errors: {
        type: Object,
        required: false
    },
});

// const errors = ref([
//   'El campo nombre es obligatorio.',
//   'El correo electrónico no es válido.',
//   'Debes aceptar los términos y condiciones.'
// ]);

// Alternativamente podrías pasar `errors` como prop desde tu componente padre
</script>

<style scoped>
@keyframes fade-in-down {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-down {
  animation: fade-in-down 0.4s ease-out;
}
</style>
