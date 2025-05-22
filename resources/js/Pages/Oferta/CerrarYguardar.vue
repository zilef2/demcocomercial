<template>
    <div class="block mx-auto text-center">
        <Link :href="computedHref">
            <SecondaryButton :disabled="formProcessing" class="px-2 2xl:px-12 2xl:text-lg">
                {{ lang().button.close }}
            </SecondaryButton>
        </Link>

        <PrimaryButton 
            class="ml-3 px-2 2xl:px-12 2xl:text-lg bg-[#74bc1f] hover:bg-[#74b1ff] dark:bg-[#74bc1f] dark:hover:bg-[#74bc1f]"
            :class="{ 'opacity-25': formProcessing }"
            :disabled="formProcessing"
            @click="create"
        >
            {{ lang().button.add }} {{ formProcessing ? '...' : '' }}
        </PrimaryButton>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3'; // Asegúrate de importar Link
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    ruta: {
        type: String,
        required: true
    },
    formProcessing: {
        type: Boolean,
        default: false
    }
});

// Emits
const emit = defineEmits(['create']);

// Computed
const computedHref = computed(() => route(props.ruta));

// Funciones
function create() {emit('create');} 
</script>

<script>
export default {
    name: 'CerrarYGuardar',
};
</script>
