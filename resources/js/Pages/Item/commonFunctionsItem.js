export function seleccionarDescuentoMayor(index, data) {

    const equipo = data.equipos[index]
    const descuentoBasico = equipo.equipo_selec.descuento_basico ?? 0;
    const descuentoProyectos = equipo.equipo_selec.descuento_proyectos ?? 0;

    const descuentoMayor = (descuentoBasico >= descuentoProyectos) ? descuentoBasico : descuentoProyectos;
    data.equipos[index].descuento_final = Math.round(descuentoMayor * 100000) / 100000;

}

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


//DELETE FUNCTIONS
export function deleteItemCommun(index, form, actualizarFn) {
    if (index < 0 || index >= form.items.length) {
        console.error("Índice fuera de rango:", index);
        return;
    }
    data.hijosZeroFlags.splice(index, 1);
    form.items.splice(index, 1);
    actualizarFn(); // 👈 se usa la función recibida
}