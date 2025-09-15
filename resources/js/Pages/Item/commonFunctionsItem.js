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


export function actualizarEquipos(cantidad, data, props, factorSeleccionado) {
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
            orden: data.equipos.length + 1,
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


//<editor-fold desc="COMPACT FUNCTIONS">
export function useEquipos(data) {
    // Computed: devuelve equipos ordenados por .orden
    const equiposOrdenados = computed(() => {
        return data.equipos.slice().sort((a, b) => a.orden - b.orden)
    })


    // Función: mover un equipo a un nuevo índice y reindexar todo
    function moverYReindexar(equipo, nuevoOrden) {
        console.log("🚀🚀moverYReindexar ~ nuevoOrden: ", nuevoOrden);
        
        if(!nuevoOrden) return;
        
        const numero = Number(nuevoOrden);
        if (!Number.isInteger(numero) || numero <= 0) {
            // alert("Error: el orden debe ser un número positivo");
            return;
        }
        nextTick()
        console.log("🚀🚀moverYReindexar ~ equipo: ", equipo);
        console.log("🚀🚀moverYReindexar ~ nuevoOrden: ", nuevoOrden);
        nextTick()

        // Clona y ordena los equipos para asegurar un orden consistente antes de manipularlos.
        const sorted = data.equipos.slice().sort((a, b) => a.orden - b.orden);

        const oldIdx = sorted.findIndex(e => e === equipo);
        if (oldIdx === -1) {
            console.error("Equipo no encontrado", equipo);
            return;
        }

        // Elimina el equipo de su posición original en el array ordenado.
        const [moved] = sorted.splice(oldIdx, 1);


        let insertIdx = numero - 1;
        if (numero === 1) insertIdx--
        if (insertIdx < 0) {
            insertIdx = 0;
        } else if (insertIdx > sorted.length) {
            insertIdx = sorted.length;
        }

        // Inserta el equipo movido en su nueva posición en el array.
        sorted.splice(insertIdx, 0, moved);

        sorted.forEach((e, i) => {
            e.orden = i + 1;
        });

        // Reemplaza el contenido del array original con el array reordenado y reindexado.
        data.equipos.splice(0, data.equipos.length, ...sorted);
    }


    return {
        equiposOrdenados,
        moverYReindexar,
    }
}

//</editor-fold>