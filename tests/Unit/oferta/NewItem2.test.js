// Importaciones necesarias
import { mount } from '@vue/test-utils';
import { describe, it, expect, vi } from 'vitest';
import { nextTick } from 'vue';

// El componente que vamos a probar
import NewItem from '@/Pages/Item/Newitem.vue';

// --- Mocks ---
vi.mock('@inertiajs/vue3', () => ({
    useForm: vi.fn(() => ({})),
    usePage: vi.fn(() => ({})),
    Link: { template: '<slot />' }
}));

vi.stubGlobal('route', vi.fn(() => '/'));
vi.stubGlobal('alert', vi.fn()); // Mock para la función alert

// --- Inicio de la Suite de Pruebas ---
describe('NewItem.vue', () => {

    const mountComponent = (props = {}) => {
        return mount(NewItem, {
            props: {
                item: { nombre: 'Item de Prueba', equipos: [] },
                indexItem: 0,
                valorUnitario: 0,
                factores: [{ title: 'Factor Test', value: 1.5 }],
                factorSeleccionado: 1,
                ...props
            },
            global: {
                stubs: {
                    PrimaryButton: true,
                    Button: true,
                    vSelect: true,
                    InputError: true,
                    Add_Sub_equipos: true,
                },
                directives: {
                    tooltip: {},
                },
                mocks: {
                    lang: () => ({
                        placeholder: { cantidad: 'Cantidad' }
                    })
                }
            }
        });
    };

    it('debería mostrar "sin valor" cuando se agrega un equipo sin valor unitario', async () => {
        const wrapper = mountComponent();

        wrapper.vm.data.equipos = [
            {
                equipo_selec: {
                    precio_de_lista: 100,
                    descuento_basico: 10,
                    descuento_proyectos: 5,
                    alerta_mano_obra: 'N/A'
                },
                cantidad: 1,
                descuento_final: 10,
                factor_final: 1.5,
                costounitario: 0,
                costototal: 0,
                valorunitario: 0,
                subtotalequip: 0
            }
        ];
        await nextTick();

        expect(wrapper.html()).toContain('sin valor');
    });
});
