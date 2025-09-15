// utils/demoOferta.ts

export function Plantilla_facil(data, indexItem, parte = 1) {

    if (indexItem === 0 && parte === 1) {

        data.daitem.nombre = 'achu';
        data.equipos = [
            {
                nombre_item: "Item generico 1", //numzilef1
                cantidad: 1,
                factor_final: 1.0,
                equipNormal: 1,
                orden: 1,
                equipo_selec: {
                    value: "40123",
                    title: "TERMINAL TIPO PIN CABLE 12-10 AMARILLA",
                    cantidad: 1,
                    precio_de_lista: 47200,
                    precio_de_lista2: 47200,
                    alerta_mano_obra: 26.22,
                    descuento_basico: 0.1, descuento_proyectos: 0.1,
                }
            },
        ]
    }
    if (indexItem === 1 && parte === 1) {
        data.daitem.nombre = 'achu2';
        data.equipos = [
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)", //numzilef1
                cantidad: 1,
                factor_final: 1.0,
                orden: 1,
                equipo_selec: {
                    value: "73246",
                    title: "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44.  TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 1428525.096,
                    precio_de_lista2: 1428525.096,
                    alerta_mano_obra: 26.22,
                    descuento_basico: 0, descuento_proyectos: 0,
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)", //numzilef2
                cantidad: 1,
                factor_final: 1.0,
                orden: 2,
                equipo_selec: {
                    value: "73339",
                    title: "GABINETE FABRICADO EN LÁMINA GALVANIZADA CALIBRE 14 Y 16, 2200X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP56. TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 2131924.91,
                    precio_de_lista2: 2131924.91,
                    alerta_mano_obra: 26.22,
                    descuento_basico: 0, descuento_proyectos: 0,
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)", //numzilef3
                cantidad: 12,
                factor_final: 1.0,
                orden: 3,
                equipo_selec: {
                    value: "40123",
                    title: "TERMINAL TIPO PIN CABLE 12-10 AMARILLA",
                    cantidad: 1,
                    precio_de_lista: 47200,
                    precio_de_lista2: 47200,
                    alerta_mano_obra: 6,
                    descuento_basico: 0, descuento_proyectos: 0,
                }
            },
        ]
    }
}


export function rellenarDemoOferta(form, dataGenerica = 1, final = 10) {
    let inicial = 0
    for (let i = inicial; i < final; i++) {
        form.daItems.push({nombre_item: ' ' + (i + 1), equipo_selec: null, cantidad: 1});
    }

    const valueRAn = Math.floor(Math.random() * 9 + 10)
    if (dataGenerica === 2) {
        form.dataOferta.empresa = 'Empresa genenerica ' + valueRAn;
        form.dataOferta.ciudad = 'Medellín'
        form.dataOferta.proyecto = 'Proyecto genenerico ' + valueRAn;
    }
}
