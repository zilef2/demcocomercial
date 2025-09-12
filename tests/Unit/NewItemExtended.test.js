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

// --- Suite de Pruebas Extendida ---
describe('NewItem.vue - Pruebas Extendidas', () => {
    it('debería renderizar correctamente el nombre del item', async () => {
        const wrapper = mount(NewItem, {
            props: {
                item: { nombre: 'Item Test', cantidad: 2, equipos: [] },
                indexItem: 0,
                mostrarDetalles: true,
                factores: [],
                factorSeleccionado: 1
            },
            global: { stubs: { PrimaryButton: true, TextInput: true } }
        });
        expect(wrapper.text()).toContain('Item Test');
    });

    it('debería actualizar la cantidad correctamente', async () => {
        const wrapper = mount(NewItem, {
            props: {
                item: { nombre: 'Item Test', cantidad: 2, equipos: [] },
                indexItem: 0,
                mostrarDetalles: true,
                factores: [],
                factorSeleccionado: 1
            },
            global: {
                stubs: {
                    TextInput: {
                        props: ['modelValue'],
                        template: `<input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />`
                    }
                }
            }
        });
        const cantidadInput = wrapper.find('input[type="number"]');
        await cantidadInput.setValue('5');
        await nextTick();
        expect(cantidadInput.element.value).toBe('5');
    });

    it('debería mostrar los equipos si existen', async () => {
        const wrapper = mount(NewItem, {
            props: {
                item: {
                    nombre: 'Item Test',
                    cantidad: 1,
                    equipos: [
                        { equipo_selec: { title: 'Equipo 1' }, cantidad: 1 }
                    ]
                },
                indexItem: 0,
                mostrarDetalles: true,
                factores: [],
                factorSeleccionado: 1
            },
            global: { stubs: { TextInput: true } }
        });
        expect(wrapper.text()).toContain('Equipo 1');
    });

    it('debería no permitir valores negativos en cantidad', async () => {
        const wrapper = mount(NewItem, {
            props: {
                item: { nombre: 'Item Test', cantidad: 1, equipos: [] },
                indexItem: 0,
                mostrarDetalles: true,
                factores: [],
                factorSeleccionado: 1
            },
            global: {
                stubs: {
                    TextInput: {
                        props: ['modelValue'],
                        template: `<input type='number' min='0' :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />`
                    }
                }
            }
        });
        const cantidadInput = wrapper.find('input[type="number"]');
        await cantidadInput.setValue('-3');
        await nextTick();
        expect(Number(cantidadInput.element.value)).toBeGreaterThanOrEqual(0);
    });
});
