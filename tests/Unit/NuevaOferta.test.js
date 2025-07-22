// 1. Importaciones necesarias
import { mount } from '@vue/test-utils';
import { describe, it, expect, vi, beforeEach } from 'vitest';
import NuevaOferta from '@/Pages/Oferta/NuevaOferta.vue';
import { reactive } from 'vue';

// 2. Mock de Inertia.js y estado del formulario
const form = reactive({
    post: vi.fn(),
    processing: false,
    dataOferta: {},
    daItems: [],
    equipos: [],
    valores_total_items: [],
    cantidadesItem: [],
    ultra_valor_total: 0,
    valorItemUnitario: 0,
    TotalItem: 0,
});

vi.mock('@inertiajs/vue3', () => ({
    useForm: vi.fn(() => form),
    usePage: vi.fn(() => ({
        props: { flash: {}, errors: {} }
    })),
    Link: { template: '<slot />' }
}));

// 3. Descripción de la suite de pruebas
describe('NuevaOferta.vue', () => {
    let wrapper;

    beforeEach(() => {
        form.daItems = [];
        form.equipos = [];
        form.valores_total_items = [];
        form.cantidadesItem = [];
        form.ultra_valor_total = 0;
        vi.clearAllMocks();

        vi.stubGlobal('route', vi.fn(() => '/'));
        vi.stubGlobal('lang', vi.fn(() => ({ placeholder: { cantidad: '' } })));

        wrapper = mount(NuevaOferta, {
            props: {
                numberPermissions: 10,
                ultimoIdMasUno: 1,
                plantilla: 0,
            },
            global: {
                stubs: {
                    Newitem: true,
                    Add_Sub_items: true,
                    formOferta: true,
                    CerrarYguardar: true,
                    Toast: true,
                    ErroresNuevaOferta: true,
                    PrimaryButton: true,
                },
                mocks: {
                    $page: { props: { flash: {}, errors: {} } }
                }
            }
        });
    });

    it('debería renderizar el título principal de la oferta', () => {
        expect(wrapper.find('h1').text()).toContain('Valor total de la oferta');
    });

    it('debería calcular y mostrar el valor total de la oferta correctamente', async () => {
        expect(form.ultra_valor_total).toBe(0);

        await wrapper.vm.actualizarItems(1);
        await wrapper.vm.actualizarValoresItems({
            indexItem: 0,
            valor_total_item: 500,
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        expect(form.ultra_valor_total).toBe(500);
        expect(wrapper.find('p.text-2xl').text()).toContain('500');

        await wrapper.vm.actualizarItems(2);
        await wrapper.vm.actualizarValoresItems({
            indexItem: 1,
            valor_total_item: 1000,
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        expect(form.ultra_valor_total).toBe(1500);
        expect(wrapper.find('p.text-2xl').text()).toContain('1.500');
    });

    it('debería actualizar el valor de un item basado en la cantidad y el valor unitario', async () => {
        await wrapper.vm.actualizarItems(1);

        const cantidadItem = 5;
        const valorItemUnitario = 10;
        const valor_total_item = cantidadItem * valorItemUnitario;

        await wrapper.vm.actualizarValoresItems({
            indexItem: 0,
            cantidadItem,
            valorItemUnitario,
            valor_total_item,
            equipos: [],
            TotalItem: 0,
            daitem: {},
        });

        expect(form.valores_total_items[0]).toBe(valor_total_item);
    });

    it('debería recalcular el total correctamente al eliminar un item', async () => {
        // Añadir 2 items
        await wrapper.vm.actualizarItems(2);

        // Asignar valor al primer item
        await wrapper.vm.actualizarValoresItems({
            indexItem: 0,
            valor_total_item: 500,
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        // Asignar valor al segundo item
        await wrapper.vm.actualizarValoresItems({
            indexItem: 1,
            valor_total_item: 1000,
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        // Verificar el total inicial
        expect(form.ultra_valor_total).toBe(1500);

        // Eliminar un item (ahora solo queda 1)
        await wrapper.vm.actualizarItems(1);

        // Verificar que el total se haya recalculado
        expect(form.ultra_valor_total).toBe(500);
    });
});
