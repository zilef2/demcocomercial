<tr v-for="(equipo, index) in equiposOrdenados" :key="equipo.idd"
    :class="{ 'bg-gray-200 dark:bg-gray-700': index % 2 !== 0 }">
<template v-if="equipo.tipoFila === 'modelo1'">
    <!--                <td class="px-3 py-2 whitespace-nowrap dark:text-white">{{ index + 1 }}°</td>-->
    <!-- Campo editable para definir posición -->
    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
        <button @click="alternarTipoFila(equipo)"
                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
            ♻️
        </button>
    </td>
    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
        <input type="text"
               :value="equipo.orden"
               class="w-14 border rounded text-center"
               @keyup.enter="moverYReindexar(equipo, $event.target.value)"
               @blur="verificarIndices(equipo, $event)"
        >
    </td>
    <!-- codigo -->
    <td class="p-2 whitespace-nowrap min-w-[100px] max-w-[750px] text-center">
        <!--                <td class="p-2 whitespace-nowrap mx-auto text-center max-w-[50px] dark:text-white">-->
        <p class="mx-auto">{{ data.equipos[index]?.equipo_selec?.value ?? '' }}</p>
        <!--                </td>-->
        <!--                 descripcion-->
        <vSelect
            v-model="data.equipos[index].equipo_selec"
            :options="data.equiposOptions"
            label="title"
            :filterable="false"
            append-to-body
            placeholder="Buscar equipo..."
            class="print:hidden mt-1 block w-full min-w-[250px] fixed zilefvs"
            @search="(q) => { data.searchEquipo = q; buscarEquipos(q) }"
            @update:modelValue="handleEquipoChange(index, $event)"
        />

        <div class="hidden print:block text-sm w-full">
            {{ data.equipos[index]?.equipo_selec?.title ?? 'Sin selección' }}
        </div>
    </td>
    <!-- fin descripcion-->
    <!-- cantidad-->
    <td class="mx-auto px-0 py-2 whitespace-nowrap text-center">
        <input
            type="number" min=0
            :value="data.equipos[index].cantidad"
            @input="event => data.equipos[index].cantidad = Math.max(0, event.target.valueAsNumber || 0)"
            :class="clasetablaCantidad + clasetablaCantidad2"
        />
    </td>
    <!-- fin cantidad-->


    <!-- precio de lista -->
    <td v-if="data.equipos[index]?.equipo_selec?.precio_de_lista2 !== 0"
        class="px-1 py-2 whitespace-nowrap mx-auto text-center">
        <p class="w-full dark:text-white ">
            {{
                data.equipos[index]?.equipo_selec ?
                    number_format(data.equipos[index]?.equipo_selec.precio_de_lista, 0, 1) : 'Sin valor'
            }}
            <Button type="button"
                    v-if="data.equipos[index] && data.equipos[index].equipo_selec"
                    @click="data.equipos[index].equipo_selec.precio_de_lista2 = 0"
                    class="items-center py-2 bg-green-700 text-center
                                     border rounded-lg border-green-800 text-white
                                     hover:bg-green-500
                                      cursor-pointer h-8 w-8 ml-2"
                    v-tooltip="'Editar'"
            >
                <PencilIcon class="w-4 mx-auto"/>
            </Button>
        </p>
    </td>
    <!--  si no hay precio en la BD-->
    <td v-else-if="data.equipos[index]?.equipo_selec"
        class="py-2 whitespace-nowrap mx-auto text-center ">
        <input
            type="text"
            :value="formatPesosCol(data.equipos[index].equipo_selec.precio_de_lista)"
            @input="onInputPrecio($event, index,data)"
            class="max-w-[140px] border-gray-50/75 dark:border-gray-700 dark:bg-gray-900
                         dark:text-gray-300 rounded-md mt-1 block w-full 
                         bg-gradient-to-r from-yellow-400 to-orange-400"
        />
        <div class="hidden print:block text-sm">
            {{ data.equipos[index]?.equipo_selec?.precio_de_lista }}
        </div>
        <div v-if="data.equipos[index]?.equipo_selec?.precio_de_lista == 0"
             :id="'valor-nulo' + indexItem + '_' + index"
             class="bg-red-600 mx-1 mt-2 max-w-[150px] rounded-lg">
            Valor nulo!
        </div>
    </td>
    <!-- fin precio de lista-->


    <!--  show both discounts -->
    <td class="hidden 2xl:table-cell text-xs md:text-md px-3 py-2 whitespace-nowrap mx-auto text-center">
        <p v-if="data.equipos[index].equipo_selec"
           class="max-w-[150px] border-gray-50/75 text-sm 
                            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block 
                            w-full border-[0.5px] border-indigo-200
                            focus:border-indigo-700"
        >
            Basico: {{ truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_basico * 100) }}
            %<br>
            Proyectos: {{
                truncarADosDecimales(data.equipos[index]?.equipo_selec.descuento_proyectos * 100)
            }} %<br>
        </p>
    </td>
    <!--                    descuento mayor -->
    <td class="p-2 whitespace-nowrap align-middle">
        <div :class="'flex items-center justify-start h-full' + clasetablaPorcentajes2">
            <input
                type="number"
                min="0"
                :value="getPorcentaje(data.equipos[index])"
                @input="event => setPorcentaje(data.equipos[index], event.target.valueAsNumber)"
                class="w-24 border rounded-md"
            /> <span class="mx-2 w-1/6 "> %</span>
        </div>
    </td>

    <!--  costo -->
    <td class="px-3 py-2 whitespace-nowrap">
        <p v-if="data.equipos[index].equipo_selec">{{
                number_format(data.equipos[index].costounitario, 0, 1)
            }}</p>
    </td>
    <td class="px-3 py-2 whitespace-nowrap">
        <p v-if="data.equipos[index].equipo_selec">{{
                number_format(data.equipos[index].costototal, 0, 1)
            }}</p>
    </td>

    <!-- factor -->
    <td class="px-3 py-2 whitespace-nowrap mx-auto text-center">
        <input
            type="number" step="0.01"
            v-model.number="data.equipos[index].factor_final"
            class="w-24 border-gray-50/75
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block
                                border-[0.5px] border-indigo-200
                                focus:border-indigo-700"
        />
    </td>
    <td class="px-3 py-2 whitespace-nowrap">
        <p v-if="data.equipos[index].equipo_selec">{{
                number_format(data.equipos[index].valorunitario, 0, 1)
            }}</p>
    </td>
    <td class="px-3 py-2 whitespace-nowrap">
        <p v-if="data.equipos[index].equipo_selec">{{
                number_format(data.equipos[index].subtotalequip, 0, 1)
            }}</p>
    </td>

    <!--                ultima columna-->
    <td class="px-3 py-2 whitespace-nowrap">
        <p v-if="data.equipos[index].equipo_selec">
            {{ data.equipos[index].equipo_selec.alerta_mano_obra }}
        </p>
    </td>
    <td class="px-3 py-2 whitespace-nowrap">
        <button @click.prevent="eliminarEquipo(index,data)"
                type="button" @keydown.enter.prevent="false"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Eliminar
        </button>
    </td>

</template>

<!-- === MODELO 2 (texto libre) === -->
<template v-else-if="equipo.tipoFila === 'texto'">
    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
        <button @click="alternarTipoFila(equipo)"
                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
            ♻️
        </button>
    </td>
    <td colspan="10" class="p-2">
        <input
            type="text"
            v-model="equipo.textoLibre"
            class="w-full border rounded p-2"
            placeholder="Digite la categoria aquí..."
        />
    </td>
</template>

<!-- === MODELO 3 (cobre) === -->
<template v-else-if="equipo.tipoFila === 'cobre'">
    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
        <button @click="alternarTipoFila(equipo)"
                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
            ♻️
        </button>
    </td>
    <td colspan="10" class="text-center">
        <PrimaryButton type="button" @click="data.showModalcobre = true; data.indicemodelo = index">
            Calcular cobre
        </PrimaryButton>
    </td>
</template>

<!-- === MODELO 4 (cableado) === -->
<template v-else-if="equipo.tipoFila === 'cableado'">
    <td class="px-3 py-2 whitespace-nowrap dark:text-white">
        <button @click="alternarTipoFila(equipo)"
                class="m-2 bg-gray-500 hover:bg-gray-700 p-2 rounded">
            ♻️
        </button>
    </td>
    <td colspan="10" class="text-center">
        <PrimaryButton type="button" @click="data.showModalcableado = true">
            Calcular cableado
        </PrimaryButton>
    </td>
</template>
</tr>