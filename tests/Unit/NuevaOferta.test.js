// 1. Importaciones necesarias
import { mount } from '@vue/test-utils';
import { describe, it, expect, vi, beforeEach } from 'vitest';
import NuevaOferta from '@/Pages/Oferta/NuevaOferta.vue';
import { reactive } from 'vue';

// 2. Mock de Inertia.js y estado del formulario
// Hacemos un mock del módulo '@inertiajs/vue3'.
// Para 'useForm', en lugar de un objeto simple, usamos 'reactive' de Vue.
// Esto nos permite tener un estado del formulario que persiste entre las
// interacciones del test y que podemos inspeccionar y modificar.
// SOLUCIÓN AL ERROR 1: Añadimos 'TotalItem' y 'valorItemUnitario' al mock
// para que el componente pueda asignarlos sin que Vue se queje.
const form = reactive({
    post: vi.fn(),
    processing: false,
    dataOferta: {},
    daItems: [],
    equipos: [],
    valores_total_items: [],
    cantidadesItem: [],
    ultra_valor_total: 0,
    valorItemUnitario: 0, // Propiedad añadida para el mock
    TotalItem: 0,         // Propiedad añadida para el mock
});

vi.mock('@inertiajs/vue3', () => ({
    useForm: vi.fn(() => form), // El componente usará nuestro 'form' reactivo.
    usePage: vi.fn(() => ({
        props: { flash: {}, errors: {} }
    })),
    Link: { template: '<slot />' }
}));

// 3. Descripción de la suite de pruebas
describe('NuevaOferta.vue', () => {
    let wrapper;

    // 4. 'beforeEach' se ejecuta antes de cada 'it' (cada prueba).
    // Es un buen lugar para limpiar y preparar el entorno.
    beforeEach(() => {
        // Reseteamos el estado del formulario para asegurar que cada prueba
        // comience desde un estado limpio y predecible.
        form.daItems = [];
        form.equipos = [];
        form.valores_total_items = [];
        form.cantidadesItem = [];
        form.ultra_valor_total = 0;
        vi.clearAllMocks(); // Limpiamos mocks para evitar interferencias entre tests.

        // Mockeamos funciones globales que usan los componentes hijos.
        vi.stubGlobal('route', vi.fn(() => '/'));
        // SOLUCIÓN AL ERROR 2: Mockeamos la función 'lang' global.
        vi.stubGlobal('lang', vi.fn(() => ({ placeholder: { cantidad: '' } })));


        // Montamos el componente. 'wrapper' es nuestro objeto para interactuar con él.
        wrapper = mount(NuevaOferta, {
            props: {
                numberPermissions: 10,
                ultimoIdMasUno: 1,
                plantilla: 0,
            },
            global: {
                // SOLUCIÓN AL ERROR 3: Usamos 'stubs' para ignorar los componentes hijos
                // y evitar errores y advertencias no relacionadas con nuestra prueba.
                stubs: {
                    Newitem: true,
                    Add_Sub_items: true,
                    formOferta: true,
                    CerrarYguardar: true,
                    Toast: true,
                    ErroresNuevaOferta: true,
                    PrimaryButton: true, // Añadido para evitar warnings
                },
                mocks: {
                    $page: { props: { flash: {}, errors: {} } }
                }
            }
        });
    });

    // 5. Prueba original: verificar que el título se renderiza.
    it('debería renderizar el título principal de la oferta', () => {
        let textoh1 = wrapper.find('h1').text()
        console.log(`NuevaOferta-test :85: El texto h1 es: ${textoh1}`);
        
        expect(textoh1).toContain('Valor total de la oferta');
    });

    // 6. Nueva prueba: verificar la lógica de cálculo del total.
    it('debería calcular y mostrar el valor total de la oferta correctamente', async () => {
        // --- ARRANGE ---
        // No se necesita preparación aquí, 'beforeEach' ya limpió el estado.
        // El valor inicial debe ser 0.
        console.log(`NuevaOferta-test :97: El form.ultra_valor_total = ${form.ultra_valor_total}`);
        expect(form.ultra_valor_total).toBe(0);

        // --- ACT ---
        // Simulamos la adición de un item llamando al método del componente.
        // Usamos 'wrapper.vm' para acceder a la instancia del componente.
        await wrapper.vm.actualizarItems(1);

        // Simulamos la actualización del valor de ese item.
        await wrapper.vm.actualizarValoresItems({
            indexItem: 0,
            valor_total_item: 500,
            // Pasamos el resto de propiedades requeridas por la función, aunque no sean
            // relevantes para este cálculo específico, para evitar errores.
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        // --- ASSERT ---
        // Comprobamos que el estado interno (el valor numérico) es correcto.
        console.log(`NuevaOferta-test :: Se espera 500 -- El form.ultra_valor_total = ${form.ultra_valor_total}`);
        expect(form.ultra_valor_total).toBe(500);
        
        
        
        expect(wrapper.find('p.text-2xl').text()).toContain('500');

        // --- ACT (parte 2) ---
        // Ahora añadimos un segundo item y actualizamos su valor.
        await wrapper.vm.actualizarItems(2);
        await wrapper.vm.actualizarValoresItems({
            indexItem: 1,
            valor_total_item: 1000,
            equipos: [], valorItemUnitario: 0, TotalItem: 0, cantidadItem: 1, daitem: {}
        });

        // --- ASSERT (parte 2) ---
        // El total debe ser la suma de los dos items (500 + 1000).
        console.log(`NuevaOferta-test :: Se espera 1500 -- El form.ultra_valor_total = ${form.ultra_valor_total}`);
        expect(form.ultra_valor_total).toBe(1500);
        // El texto renderizado debe reflejar el nuevo total.
        // Asumimos que el formateo para 1500 será "1.500".
        expect(wrapper.find('p.text-2xl').text()).toContain('1.500');
    });
});