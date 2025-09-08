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

// --- Inicio de la Suite de Pruebas ---
describe('NewItem.vue', () => {

    it('no debería permitir valores negativos en los inputs numéricos con min="0"', async () => {

        // --- 1. Montar el Componente ---
        const wrapper = mount(NewItem, {
            props: {
                item: {
                    nombre: 'Item de Prueba',
                    cantidad: 1,
                    equipos: [
                        {
                            equipo_selec: {
                                value: 'TEST-01',
                                title: 'Equipo de Prueba',
                                precio_de_lista: 100,
                                descuento_basico: 0.10,
                                descuento_proyectos: 0.05,
                                alerta_mano_obra: 'N/A'
                            },
                            cantidad: 1,
                            descuento_final: 0.10,
                            factor_final: 1.5, // Este no tiene min="0" y debería ser ignorado
                            costounitario: 0,
                            costototal: 0,
                            valorunitario: 0,
                            subtotalequip: 0
                        }
                    ]
                },
                indexItem: 0,
                mostrarDetalles: true,
                factores: [{ title: 'Factor Test', value: 1.5 }],
                factorSeleccionado: 1
            },
            global: {
                stubs: {
                    PrimaryButton: true,
                    Button: true, // Añadido para resolver el warning de Vue
                    vSelect: true,
                    InputError: true,
                    Add_Sub_equipos: true,
                    FactorModal: true,
                    PencilIcon: true,
                    TextInput: { // Stub para TextInput que se comporta como un input real
                        props: ['modelValue'],
                        template: `<input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />`
                    }
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

        await nextTick();

        // --- 2. Encontrar los Elementos ---
        const numberInputs = wrapper.findAll('input[type="number"]');

        // --- 3. Actuar y Verificar ---
        let testedInputs = 0;
        for (const input of numberInputs) {
            // Solo probamos los inputs que tienen explícitamente min="0"
            if (input.attributes('min') === '0') {
                testedInputs++;
                await input.setValue('-5');
                await nextTick();

                console.log(`Verificando input: ${input.element.className}, valor es '${input.element.value}'`);
                
                // El comportamiento esperado es que el valor se corrija a 0 o quede vacío
                expect(input.element.value).not.toBe('-5');
                expect(Number(input.element.value)).toBeGreaterThanOrEqual(0);
            }
        }

        // Asegurarnos de que al menos un input fue probado para evitar falsos positivos.
        expect(testedInputs).toBeGreaterThan(0);
    });
});