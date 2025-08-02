<template>
    <Modal @close="closeModal" :show="show" :maxWidth="'md'">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Actualizar Factor de Equipos
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Por favor, introduce el nuevo factor que se aplicará a todos los equipos de este item.
            </p>

            <div class="mt-6">
                <TextInput
                    v-model="nuevoFactor"
                    type="number"
                    class="mt-1 block w-3/4"
                    placeholder="Factor"
                    min="0"
                    step="0.01"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    @click="confirmUpdate"
                >
                    Actualizar Factor
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'confirm']);

const nuevoFactor = ref(1);

const confirmUpdate = () => {
    const factor = parseFloat(nuevoFactor.value);
    if (!isNaN(factor) && factor >= 0) {
        emit('confirm', factor);
        closeModal();
    } else {
        alert("Por favor, introduce un número válido para el factor.");
    }
};

const closeModal = () => {
    emit('close');
};
</script>
