<template>
    <section class="text-gray-600 body-font w-full">
        <div class="container px-5 py-2 mx-2 text-center">
            <div class="flex -m-4">
                <div class="p-2 w-full">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-600 mb-1">Codigo:
                                {{ textoArray['Codigo'] }}</h2>
                            <h1 class="title-font text-lg font-bold text-gray-900 mb-3">Ref:
                                {{ textoArray['Referencia_Fabricante'] }}</h1>
                            <p class="text-black mb-3">Marca: {{ textoArray['Marca'] }}</p>
                            <p class="text-black mb-3">Tipo Fabricante: {{ textoArray['Tipo_Fabricante'] }}</p>
                            <p class="text-black mb-3">Precio Lista:
                                {{ number_format(textoArray['Precio_de_Lista'], 0, 1) }}</p>
                            <div class="flex items-center ">
                                <a class="text-black inline-flex items-center md:mb-2 lg:mb-0">Unidad:
                                    {{ textoArray['Unidad'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--    10/2,5 KA 240/440V
     "Tipo_Fabricante": "EZC100B
      "Referencia_Fabricante": "EZC100B3015
       "Marca": "SCHNEIDER
       -->
    <!--    "Unidad_de_Compra": "Und
     "Precio_de_Lista": 525000, "Fecha_actualizacion": "2025-02-03
      "Descuento_Basico": 1,-->
    <!--    "Descuento_Proyectos": 1, "Precio_con_Descuento": 162750, "Precio_con_Descuento_Proyecto": 162750,-->
    <!--    "Precio_Ultima_Compra": 0, "Precios_de_Listas": "525000
     "Ruta_Tiempos": "T-0.1
      "Tiempos_Chapisteria": 0 }-->
</template>

<script setup>
import {formatDate, number_format} from '@/global.ts';

import {
    HomeIcon,
    UserIcon,
    CheckBadgeIcon,
    KeyIcon,
    ShieldCheckIcon,
    ClockIcon,
    PresentationChartLineIcon,
    BanknotesIcon,
} from "@heroicons/vue/24/solid";


const props = defineProps({
    textoArray: {
        type: Object,
        default: ['Sin mensaje'],
    }
})
</script>
