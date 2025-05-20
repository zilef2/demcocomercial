<template>
    <section class="text-gray-600 body-font w-full">
        <div class="container px-5 py-2 mx-2 text-center">
            <div class="flex -m-4">
                <div class="p-2 w-full">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-600 mb-1">Codigo:
                                {{ textoArray?.['Codigo'] }}</h2>
                            <h1 class="title-font text-lg font-bold text-gray-900 mb-3">Ref:
                                {{ textoArray?.['Referencia_Fabricante'] }}</h1>
                            
                            
                            <nav class="flex flex-col sm:items-start sm:text-left text-center items-center -mb-1 space-y-2.5">
                                  <a>
                                    <span class="bg-indigo-100 text-indigo-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>Marca: {{ textoArray?.['Marca'] }}
                                  </a>
                                  <a>
                                    <span class="bg-indigo-100 text-indigo-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>Tipo Fabricante: {{ textoArray?.['Tipo_Fabricante'] }}
                                  </a>
                                  <a>
                                    <span class="bg-indigo-100 text-indigo-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>Precio Lista: {{ number_format(textoArray?.['Precio_de_Lista'], 0, 1) }}
                                  </a>
                                  <a>
                                    <span class="bg-indigo-100 text-indigo-500 w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>Unidad: {{ textoArray?.['Unidad_de_Compra'] }}
                                  </a>
                              </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script setup>
import {number_format} from '@/global.ts';

const props = defineProps({
    textoArray: {
        type: Object,
        default: ['Sin mensaje'],
    }
})
</script>
