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
    // data.equipos viene de reactive en el componente
    const equiposOrdenados = computed(() => {
        // data.equipos.slice()
        return data.equipos.slice().sort((a, b) => a.orden - b.orden)
    })


    function moverYReindexar(equipo, nuevoOrden) {
        // Coerción y validación estricta del número
        const numero = Number(nuevoOrden);
        if (!Number.isInteger(numero)) {
            alert('Error: valor de orden inválido');
            console.log('moverYReindexar: nuevoOrden no entero ->', nuevoOrden);
            nextTick()
            return;
        }

        const total = data.equipos.length;
        if (total === 0) {
            nextTick()
            return;
        }

        // Validar equipos incompletos (detecta null o undefined o cadena vacía)
        if (data.equipos.some(e => e.equipo_selec == null || e.equipo_selec === [])) {
            alert('Error: hay equipos con id vacía o nula. No se puede reordenar.');
            console.log('moverYReindexar: equipos inválidos:', data.equipos);
            nextTick()
            return;
        }

        // Limitar el rango
        let target = Math.min(Math.max(1, numero), total);
        const targetIndex = target - 1;

        // Buscar índice: primero por referencia (más fiable), luego fallback por id (coercion a string)
        let currIndex = data.equipos.findIndex(e => e === equipo);
        if (currIndex === -1) {
            currIndex = data.equipos.findIndex(e => String(e.id) === String(equipo.id));
        }
        if (currIndex === -1) {
            console.warn('moverYReindexar: no se encontró el equipo en data.equipos', {equipo});
            nextTick()
            return;
        }

        // Si ya está en la misma posición, solo reindexamos orden por consistencia y salimos.
        if (currIndex === targetIndex) {
            data.equipos.forEach((e, i) => {
                e.orden = i + 1
            });
            console.log('moverYReindexar: elemento ya en posición', target);
            nextTick()
            return;
        }

        // Mover elemento y reindexar
        const [item] = data.equipos.splice(currIndex, 1);
        data.equipos.splice(targetIndex, 0, item);
        data.equipos.forEach((e, i) => {
            e.orden = i + 1
        });

        console.log(`moverYReindexar: movido id=${item.id} de ${currIndex + 1} a ${target}`, {
            data: data.equipos.map(x => ({id: x.id, orden: x.orden}))
        });
    }


    return {equiposOrdenados, moverYReindexar}
}

//</editor-fold>