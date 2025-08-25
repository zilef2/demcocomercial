<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
        // default: 'button',
    },
});
</script>

<template>
    <button :type="type"
            class="inline-flex items-center px-4 py-2 bg-indigo-500 dark:bg-indigo-500
         border border-transparent rounded-md font-semibold text-xs text-white
         mouse-pointer 
          dark:text-white uppercase tracking-widest 
          hover:bg-indigo-800 hover:border-indigo-500
          active:bg-indigo-500 dark:active:bg-indigo-500/80 focus:outline-none focus:ring-2 
          focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-indigo-500 
          disabled:bg-gray-300">
        <slot/>
    </button>
</template>
