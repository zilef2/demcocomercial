<template>
  <div class="w-full px-4 pt-16">
    <div class="mx-auto w-full max-w-md rounded-2xl bg-white p-2">
      <Disclosure v-for="(texto, index) in props.textoArray" :key="index" v-slot="{ open }">
        <DisclosureButton class="flex w-full justify-between rounded-lg bg-gray-200 px-4 py-2
         text-left text-lg font-medium text-[#74bc1f] 
        hover:bg-indigo-200 focus:outline-none focus-visible:ring focus-visible:ring-[#74bc1f]">
          <span>{{tituloArray[index]}}</span>
          <ChevronUpIcon
            :class="open ? '' : 'rotate-180 transform'"
            class="h-5 w-5 text-[#74bc1f]"
          />
        </DisclosureButton>
        <DisclosurePanel class="px-4 pb-2 pt-4 text-sm text-gray-500">
          {{texto}}
        </DisclosurePanel>
      </Disclosure>
    </div>
  </div>
<!--    adsasda {{textoArray}}-->
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronUpIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    tituloArray:{
        type: Array,
        default: ['Sin titulo'],
    },
    textoArray:{
        type: Array,
        default: ['Sin mensaje'],
    }
})
</script>
