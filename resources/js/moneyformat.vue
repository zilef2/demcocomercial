<script setup>
import { ref, watch } from 'vue';

const formatNumber = (value) => {
    if (!value) return '';
    const number = String(value).replace(/\D/g, '');
    return new Intl.NumberFormat('es-CO').format(number);
};

export function useMoneyFormat(modelValue) {
    const formattedValue = ref(formatNumber(modelValue.value));

    watch(modelValue, (newVal) => {
        formattedValue.value = formatNumber(newVal);
    });

    const onInput = (event) => {
        const input = event.target;
        const rawValue = input.value.replace(/\D/g, '');

        // Actualiza el modelo original
        modelValue.value = rawValue;

        // Actualiza el valor formateado mostrado
        formattedValue.value = formatNumber(rawValue);
    };

    return {
        formattedValue,
        onInput
    };
}

</script>

<template>

</template>

<style scoped>

</style>