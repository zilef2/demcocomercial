<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: [String,Number],
    error: {
        type: String,
        default: null,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input v-bind:class="error ? 'border-red-500 dark:border-red-400 dark:bg-black dark:text-gray-300 focus:border-red-500 dark:focus:border-red-400 focus:ring-red-500 dark:focus:ring-red-400' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary dark:focus:border-primary focus:ring-primary dark:focus:ring-primary'"
        class="rounded-md shadow-sm placeholder:text-gray-400 placeholder:dark:text-gray-400/50" :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" ref="input" />
</template>
