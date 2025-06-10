<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-primary dark:bg-primary
         border border-transparent rounded-md font-semibold text-xs text-white
          dark:text-white uppercase tracking-widest 
          hover:bg-green-800 dark:hover:bg-primary/90 mouse-pointer
           focus:bg-primary/80 dark:focus:bg-primary/80 
          active:bg-primary dark:active:bg-primary/80 focus:outline-none focus:ring-2 
          focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-primary 
          transition ease-in-out duration-150 
          disabled:bg-gray-300">
        <slot />
    </button>
</template>
