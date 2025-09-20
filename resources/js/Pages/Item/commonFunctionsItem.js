/*
INDEXE

MAIN FUNCTIONS
VISUALIZERS
CALCULUS FUNCTIONS
DELETE FUNCTIONS

COMPACT FUNCTIONS
*/




//<editor-fold desc="Main functions">
// *********************************

import {computed, nextTick, reactive} from "vue";
import {forEach} from "lodash";

/*
constantes
 */

export const clasetablaCantidad = 'dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md mt-1 block mx-auto border-[0.5px] border-indigo-200 focus:border-indigo-700';
export const clasetablaCantidad2 = ' w-20 pl-1';
export const clasetablaPorcentajes2 = ' w-20';


export const tableheaders = ` 
                <th class="dark:text-white px-3 py-2 whitespace-nowrap rounded-l-2xl">Tipo</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap ">#</th>
<!--                <th class="dark:text-white px-3 py-2 mx-2 min-w-[10px]">Código</th>-->
                <th class="dark:text-white px-3 py-2 mx-2 whitespace-nowrap min-w-[150px] max-w-[700px]">
                Código y Descripción
                </th>
                <th :class="'dark:text-white -mx-4 py-2 whitespace-nowrap' + clasetablaCantidad2">Cantidad</th>
                <th class="dark:text-white px-3 py-2 min-w-[180px] max-w-[400px] whitespace-nowrap">Precio de lista</th>
                <th class="dark:text-white hidden 2xl:table-cell px-3 py-2 whitespace-nowrap">Descuentos</th>
                <th :class="'dark:text-white px-3 py-2 whitespace-nowrap'+ clasetablaPorcentajes2">Descuento final %
                </th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap">Costo</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap">Costo total</th>
                <th class="dark:text-white px-3 py-2 max-w-[40px] whitespace-nowrap">Factor</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap">Valor unitario</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap ">Subtotal</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap">Alerta mano de obra</th>
                <th class="dark:text-white px-3 py-2 whitespace-nowrap rounded-r-2xl">Acciones</th>
            `;

/*
fin constantes
 */


export async function buscarEquipos2(search, data) {

    const url = route('api.select.equipos') + '?q=' + encodeURIComponent(search);
    try {
        const res = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        data.equiposOptions = await res.json();
    } catch (error) {
        const errorMessage = `API Error | query: "${search}" | message: ${error.message}`;

        try {
            const logUrl = route('api.log.error') + '?error=' + encodeURIComponent(errorMessage);
            console.log("🔗 URL generada para log:", logUrl);
            // enviar al backend el error por querystring
            await fetch(logUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });
        } catch (logError) {
            console.error('❌ No se pudo registrar el error en el backend:', logError);
        }

        console.error(errorMessage, error);
    }
}

//</editor-fold>


//FIN MAIN FUNCTIONS


// ********************************* VISUALIZERS
export function truncarADosDecimales(numero) { //newis
    return Math.trunc(numero * 100) / 100;
}

//FIN VISUALIZERS


//<editor-fold desc="CALCULUS FUNCTIONS">
// ********************************* 

export const getPorcentaje = (equipo) => Number((equipo.descuento_final * 100).toFixed(2))

export const setPorcentaje = (equipo, valor) => {
  const val = valor / 100
  // Redondeamos a 2 decimales
  equipo.descuento_final = Math.max(0, Number(val.toFixed(4)))
}


export function onInputPrecio(e, index, data) {
    const raw = e.target.value.replace(/[^\d]/g, ""); // solo números
    data.equipos[index].equipo_selec.precio_de_lista = Number(raw || 0);
}

export function seleccionarDescuentoMayor(index, data) {

    const equipo = data.equipos[index]
    const descuentoBasico = equipo.equipo_selec.descuento_basico ?? 0;
    const descuentoProyectos = equipo.equipo_selec.descuento_proyectos ?? 0;

    const descuentoMayor = (descuentoBasico >= descuentoProyectos) ? descuentoBasico : descuentoProyectos;
    data.equipos[index].descuento_final = Math.round(descuentoMayor * 100000) / 100000;

}

//</editor-fold>


// ********************************* UPDATE FUNCTIONS

export function actualizarTodosLosFactores(nuevoFactor, data) {
    if (typeof nuevoFactor !== 'number' || nuevoFactor < 0) {
        alert("El factor debe ser un número positivo.");
        return;
    }
    data.equipos.forEach(equipo => {
        equipo.factor_final = nuevoFactor;
    });
}
export function actualizarFilaCobre(nuevoCobre, data,index) {
    if (typeof nuevoCobre !== 'number' || nuevoCobre < 0) {
        alert("El cobre fue mal calculado, debe ser un número positivo.");
        return;
    }
    
    data.equipos[index].costo = nuevoCable;
}
export function actualizarFilaCable(nuevoCable, data,index) {
    if (typeof nuevoCable !== 'number' || nuevoCable < 0) {
        alert("El cable fue mal calculado, debe ser un número positivo.");
        return;
    }
    
    data.equipos[index].costo = nuevoCable;
}


export function actualizarEquipos(cantidad, data, props, factorSeleccionado) { //ddefinee_2A
    if (cantidad < 0) cantidad = 0;
    const initialLength = data.equipos.length;

    while (data.equipos.length < cantidad) {
        data.equipos.push({
            nombre_item: '',
            equipo_selec: null,
            cantidad: 1,
            descripcion: '',
            descuento_final: 0,
            factor_final: 1,
            costounitario: 0,
            costototal: 0,
            valorunitario: 0,
            subtotalequip: 0,
            
            orden: data.equipos.length,
            idd: data.equipos.length,
            tipoFila: 'modelo1', // valor por defecto
            textoCategoria: 'modelo1', // valor por defecto
        });
    }
    while (data.equipos.length > cantidad) {
        data.equipos.pop();
    }
    if (data.equipos.length > initialLength) {
        AsignarFactores(data, props, factorSeleccionado);
    }
}

function AsignarFactores(data, props, factorSeleccionado) {
    let fs = factorSeleccionado
    if (!fs) return

    const isinteger = Number.isInteger(fs);
    if (!isinteger) return
    //fin validaciones
    fs = fs - 1
    let equipo = data.equipos[data.equipos.length - 1];
    equipo.factor_final = props.factores[fs].value ?? 1;

}

// ********************************* DELETE FUNCTIONS

export function deleteItemCommun(index, form, data, actualizarFn) {
    if (index < 0 || index >= form.items.length) {
        console.error("Índice fuera de rango:", index);
        return;
    }

    data.hijosZeroFlags.splice(index, 1);
    form.items.splice(index, 1);
    if (form.equipos) form.equipos.splice(index, 1);
    actualizarFn(); // 👈 se usa la función recibida
}

export function eliminarEquipo(index, data) {
    data.equipos.splice(index, 1);
}

//<editor-fold desc="COMPACT FUNCTIONS">
export function useEquipos(data) {
    // Computed: devuelve equipos ordenados por .orden
    const equiposOrdenados = computed(() => {
        return data.equipos.slice().sort((a, b) => a.orden - b.orden)
    })


    function verificarIndices(equipo, event) {
        let estamal = false
        let idx = event.target.value;
        let orden = equipo.orden
        let idd = equipo.idd
        if(idx == ''){
            
            let indicevacio = data.equipos.findIndex(e => e.idd == idd)
            // data.equipos[indicevacio].orden = orden
            event.target.value = equipo.orden
            return 
        }
        //ya verificamos que no este vacio, ahora 
        // if (orden != idx) {
        //
        //     data.equipos.forEach((e, i) => {
        //
        //         console.log(data.equipos.map(equipo => equipo.orden));
        //         if (e.orden != i + 1) {
        //             estamal = true
        //         }
        //     });
        //
        //     if (estamal)
        //         data.equipos.forEach((e, i) => {
        //             e.orden = i + 1
        //         });
        // }
    }

    function moverYReindexar(equipo, nuevoOrden) {

        // Si el usuario dejó el input vacío o pasamos undefined/null: salir sin tocar nada
        if (nuevoOrden === '' || nuevoOrden == null) return;

        let numero = Number(nuevoOrden);
        if (!Number.isInteger(numero) || numero <= 0) return;
        if (equipo.orden === numero) return;


        if (nuevoOrden > data.equipos.length) numero = data.equipos.length;


        // Construimos la lista de "otros" sin el equipo movido (comparando por idd si existe, sino por referencia)
        const others = data.equipos
            .filter(e => e.idd !== equipo.idd)
            // .filter(e => (e.idd != null && equipo.idd != null) ? e.idd !== equipo.idd : e !== equipo)
            .slice()
            .sort((a, b) => a.orden - b.orden);

        // insert index: clamp entre 0 y others.length
        const insertIdx = Math.max(0, numero - 1);

        // Insertar el equipo en la posición deseada
        others.splice(insertIdx, 0, equipo);

        // Reasignar orden (1..N) de forma determinista
        others.forEach((e, i) => {
            e.orden = i + 1;
        });

        // Reemplazar el array reactivo conservando reactividad
        data.equipos.splice(0, data.equipos.length, ...others);
    }


    return {
        equiposOrdenados,
        moverYReindexar,
        verificarIndices
    }
}

//</editor-fold>