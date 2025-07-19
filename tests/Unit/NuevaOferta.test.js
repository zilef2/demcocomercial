// 1. Importaciones necesarias
import { mount } from '@vue/test-utils';
import { describe, it, expect, vi } from 'vitest';
import NuevaOferta from '@/Pages/Oferta/NuevaOferta.vue';

// Mock de Inertia.js para evitar errores en las pruebas
vi.mock('@inertiajs/vue3', () => ({
    useForm: vi.fn(() => ({
        post: vi.fn(),
        processing: false,
        dataOferta: {},
        daItems: [],
        equipos: [],
        valores_total_items: [],
        cantidadesItem: [],
        ultra_valor_total: 0,
    })),
    usePage: vi.fn(() => ({
        props: {
            flash: {},
            errors: {},
        }
    })),
    Link: { // <-- Añadimos un mock para el componente Link
        template: '<slot />'
    }
}));

// 2. Descripción de la suite de pruebas
describe('NuevaOferta.vue', () => {

    // 3. Definición de una prueba individual (test case)
    it('debería renderizar el título principal de la oferta', () => {

        // Mockeamos la función global 'route' que usa el componente hijo
        vi.stubGlobal('route', vi.fn(() => '/'));

        // 4. Montar el componente
        // 'mount' crea una instancia del componente en un entorno de prueba.
        // Le pasamos 'props' falsas para simular las que recibiría en la app.
        const wrapper = mount(NuevaOferta, {
            props: {
                numberPermissions: 10,
                ultimoIdMasUno: 1,
                plantilla: 0,
            },
            global: {
                mocks: {
                    $page: {
                        props: {
                            flash: {},
                            errors: {},
                        }
                    }
                }
            }
        });

        // 5. Realizar la aserción (la prueba en sí)
        // 'expect' es la función de Vitest para hacer comprobaciones.
        // 'wrapper.find(...)' busca un elemento dentro del componente montado.
        // '.text()' obtiene el contenido de texto de ese elemento.
        // '.toContain(...)' comprueba si el texto incluye la cadena que esperamos.
        expect(wrapper.find('h1').text()).toContain('Valor total de la oferta');
    });
});
