'''<script setup>
import { onMounted, ref, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import EditItem from "@/Pages/Item/EditItem.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { number_format } from "@/global.ts";

const props = defineProps({
    oferta: Object,
    theuser: Object,
    numberPermissions: Number
});

const form = useForm({
    dataOferta: {
        id: props.oferta.id,
        codigo_oferta: props.oferta.codigo_oferta,
        descripcion: props.oferta.descripcion,
        cliente: props.oferta.cliente,
        cargo: props.oferta.cargo,
        empresa: props.oferta.empresa,
        ciudad: props.oferta.ciudad,
        proyecto: props.oferta.proyecto,
    },
    items: [],
    ultra_valor_total: props.oferta.valor_total_oferta,
});

onMounted(() => {
    if (props.oferta && props.oferta.items) {
        form.items = props.oferta.items.map(item => {
            const equipos = item.equipos.map(equipo => {
                // Reconstruir la estructura que el frontend espera, aplanando 'pivot'
                return {
                    cantidad: equipo.pivot.cantidad_equipos,
                    descuento_final: equipo.pivot.descuento_final,
                    factor_final: equipo.pivot.factor,
                    costounitario: equipo.pivot.costo_unitario,
                    costototal: equipo.pivot.costo_total,
                    valorunitario: equipo.pivot.valorunitarioequip,
                    subtotalequip: equipo.pivot.subtotalequip,
                    equipo_selec: {
                        value: equipo.pivot.codigoGuardado,
                        title: equipo.pivot.descripcion,
                        precio_de_lista: equipo.pivot.precio_de_lista,
                        descuento_basico: equipo.pivot.descuento_basico,
                        descuento_proyectos: equipo.pivot.descuento_proyectos,
                        alerta_mano_obra: equipo.alerta_mano_obra,
                        id: equipo.id
                    }
                };
            });
            return {
                id: item.id,
                nombre: item.nombre,
                descripcion: item.descripcion,
                cantidad: item.cantidad,
                valor_unitario_item: item.valor_unitario_item,
                valor_total_item: item.valor_total_item,
                equipos: equipos
            };
        });
    }
});

const addItem = () => {
    form.items.push({
        nombre: 'Item Nuevo',
        cantidad: 1,
        descripcion: '',
        equipos: [],
        valor_unitario_item: 0,
        valor_total_item: 0,
    });
};

const removeItem = (index) => {
    form.items.splice(index, 1);
};

const updateItem = (index, updatedItem) => {
    form.items[index] = updatedItem;
    recalculateTotal();
};

const recalculateTotal = () => {
    form.ultra_valor_total = form.items.reduce((total, item) => {
        return total + (item.valor_total_item || 0);
    }, 0);
};

watch(() => form.items, recalculateTotal, { deep: true });

const submit = () => {
    form.post(route('oferta.GuardarEditOferta', { oferta: props.oferta.id }), {
        preserveScroll: true,
        onSuccess: () => {
            // Lógica en caso de éxito
        },
        onError: (errors) => {
            console.error("Error al guardar la oferta:", errors);
        }
    });
};

const breadcrumbs = [
    { label: 'Ofertas', url: route('oferta.index') },
    { label: 'Editar Oferta', url: null }
];
</script>

<template>
    <Head title="Editar Oferta" />
    <AuthenticatedLayout>
        <template #header>
            <Breadcrumb :items="breadcrumbs" />
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">Editar Oferta: {{ form.dataOferta.codigo_oferta }}</h2>

                    <!-- Formulario de Datos Generales de la Oferta -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="codigo_oferta" class="block text-sm font-medium text-gray-700">Código Oferta</label>
                            <input type="text" v-model="form.dataOferta.codigo_oferta" id="codigo_oferta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="proyecto" class="block text-sm font-medium text-gray-700">Proyecto</label>
                            <input type="text" v-model="form.dataOferta.proyecto" id="proyecto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                         <div>
                            <label for="empresa" class="block text-sm font-medium text-gray-700">Empresa</label>
                            <input type="text" v-model="form.dataOferta.empresa" id="empresa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                         <div>
                            <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <input type="text" v-model="form.dataOferta.cliente" id="cliente" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Items de la Oferta -->
                    <div class="space-y-6">
                        <EditItem
                            v-for="(item, index) in form.items"
                            :key="index"
                            :item="item"
                            :index="index"
                            @update:item="updateItem(index, $event)"
                            @remove:item="removeItem(index)"
                        />
                    </div>

                    <div class="mt-6">
                        <PrimaryButton @click="addItem">Añadir Item</PrimaryButton>
                    </div>
                    
                    <div class="mt-8 text-right text-2xl font-bold">
                        Valor Total: {{ number_format(form.ultra_valor_total, 0, 1) }}
                    </div>

                    <div class="mt-8 flex justify-end">
                        <PrimaryButton @click="submit" :disabled="form.processing">
                            Guardar Cambios
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
'''