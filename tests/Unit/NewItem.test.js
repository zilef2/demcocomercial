// Importaciones necesarias
import { mount } from '@vue/test-utils';
import { describe, it, expect, vi } from 'vitest';
import { nextTick } from 'vue'; // <-- ¡NUEVO! Importamos nextTick de Vue.

// El componente que vamos a probar
import NewItem from '@/Pages/Item/Newitem.vue';

// --- Mocks ---
// Como NewItem usa componentes hijos y funciones globales, los simulamos aquí
// para mantener la prueba "unitaria" y centrada solo en NewItem.
vi.mock('@inertiajs/vue3', () => ({
    useForm: vi.fn(() => ({})),
    usePage: vi.fn(() => ({})),
    Link: { template: '<slot />' }
}));

vi.stubGlobal('route', vi.fn(() => '/'));

// --- Inicio de la Suite de Pruebas ---
describe('NewItem.vue', () => {

    // Nuestra nueva prueba. Fíjate que ahora es 'async' (asíncrona).
    it('no debería permitir valores negativos en sus inputs numéricos', async () => {

        // --- 1. Montar el Componente ---
        // Montamos el componente con las 'props' mínimas que necesita para funcionar.
        const wrapper = mount(NewItem, {
            props: {
                daitem: { nombre: 'Item de Prueba' },
                indexItem: 0,
                valorUnitario: 0,
                factores: [{title: 'Factor Test', value: 1.5}],
                factorSeleccionado: 1
            },
            global: {
                // Stubs: Son componentes o directivas falsas para evitar errores.
                stubs: {
                    PrimaryButton: true, // Ignora el componente PrimaryButton
                    vSelect: true,       // Ignora el componente v-select
                    InputError: true,
                    Add_Sub_equipos: true,
                },
                directives: {
                    tooltip: {}, // Ignora la directiva v-tooltip
                },
                // Mocks: Funciones globales falsas.
                mocks: {
                    lang: () => ({ // Crea una función lang() falsa
                        placeholder: { cantidad: 'Cantidad' }
                    })
                }
            }
        });

        // Para que los inputs aparezcan, necesitamos añadir un equipo a los datos del componente.
        // En lugar de setData, modificamos el estado directamente a través de la instancia (vm).
        // Esto es más directo y evita problemas con la reactividad anidada.
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
        // Esperamos que Vue procese el cambio de estado.
        await nextTick();

        // --- 2. Encontrar los Elementos ---
        // Buscamos TODOS los inputs de tipo número dentro del componente.
        const numberInputs = wrapper.findAll('input[type="number"]');

        // --- 3. Actuar (Simular Usuario) ---
        // Usamos un bucle 'for' para revisar cada input que encontramos.
        for (const input of numberInputs) {
            // Usamos .setValue() para simular que un usuario escribe "-5".
            // Esto es una acción asíncrona, por eso usamos 'await'.
            await input.setValue('-5');
            await nextTick();

            // Gracias al atributo min="0", el navegador (o happy-dom) debería haberlo corregido a "0" o haberlo dejado vacío.
            console.log(`Verificando input: el valor es '${input.element.value}'`);
            expect(input.element.value).not.toBe('-5');

            // Una prueba aún mejor es asegurarse de que el valor sea un número y sea >= 0.
            // Si el input está vacío, Number('') da 0, lo cual es correcto.
            expect(Number(input.element.value)).toBeGreaterThanOrEqual(0);
        }
    });
});