export interface CobreData {
    subtotal: number;
    abstotal: number;
    t_subtotl: number;
    t_abstotl: number;
    ValorProcesoManoObra: number;

    textocolumna1: string[];
    amperios: number[];
    cantidades: number[];
    metros: number[];
    pesos: number[];
    pesototal: number[];
    valortotal: number[];
    tiempoprincipal: number[];

    textocolumna2: string[];
    textocolumna3: string[];
    textocolumna4: string[];
    textocolumna2_descrip: string[];
    textocolumna3_descrip: string[];

    cantidades2: number[];
    valortotal2: number[];
    tiempoprincipal2: number[];

    amperios3: number[];
    cantidades3: number[];
    metros3: number[];
    pesos3: number[];
    pesototal3: number[];
    valortotal3: number[];
    tiempoprincipal3: number[];
    soportest450: number[];

    factorMultiplicadoCG: number;
    dAISLADORES: number;
    dSOPORTET40: number;
    dSOPORTET50: number;
    Soporteangulo: number[];

    cantidades4: number[];
    factoresElectrogible: number[][];
    valorElectrogible: number[];
    tiempoElectrogible: number[];
}

export function useAmper() {

    const tablaAmperajeYMetros = [
        {min: 0, max: 161, peso: 0, mts: 0},
        {min: 162, max: 273, peso: 0.396, mts: 1.2},
        {min: 274, max: 326, peso: 0.841, mts: 1.4},
        {min: 327, max: 378, peso: 1.064, mts: 1.4},
        {min: 379, max: 481, peso: 1.286, mts: 1.4},
        {min: 482, max: 582, peso: 1.73, mts: 1.4},
        {min: 583, max: 587, peso: 2.175, mts: 1.6}, //alterado
        {min: 586, max: 671, peso: 1.682, mts: 1.6}, // ojo: rango extraño en datos
        {min: 672, max: 687, peso: 2.572, mts: 1.6},
        {min: 688, max: 693, peso: 2.619, mts: 1.6},
        {min: 694, max: 714, peso: 2.645, mts: 1.6},
        {min: 715, max: 794, peso: 3.365, mts: 1.8},
        {min: 795, max: 835, peso: 3.192, mts: 1.8},
        {min: 836, max: 884, peso: 3.46, mts: 1.8},
        {min: 885, max: 993, peso: 3.508, mts: 1.8},
        {min: 994, max: 1079, peso: 4.35, mts: 1.8},
        {min: 1080, max: 1149, peso: 4.397, mts: 1.8},
        {min: 1150, max: 1259, peso: 5.238, mts: 1.8},
        {min: 1260, max: 1449, peso: 6.525, mts: 1.8},
        {min: 1450, max: 1729, peso: 7.016, mts: 2},
        {min: 1730, max: 2049, peso: 8.794, mts: 2},
        {min: 2050, max: 2479, peso: 13.191, mts: 2.2},
        {min: 2480, max: 2719, peso: 17.398, mts: 2.2},
        {min: 2720, max: 3189, peso: 14.032, mts: 2.2},
        {min: 3190, max: 3259, peso: 17.588, mts: 2.4},
        {min: 3260, max: 3979, peso: 26.097, mts: 2.4},
        {min: 3980, max: 4499, peso: 34.8, mts: 2.4},
        {min: 4500, max: 5529, peso: 41.91, mts: 2.6},
        {min: 5530, max: 6539, peso: 56.13, mts: 2.6},
        {min: 6540, max: 9999, peso: 70.36, mts: 2.8},
    ];

    const tablaTiempo = [
        {cap: 0, tiempo: 0},
        {cap: 162, tiempo: 0.2900},
        {cap: 274, tiempo: 0.4350},
        {cap: 327, tiempo: 0.4350},
        {cap: 379, tiempo: 0.5800},
        {cap: 482, tiempo: 0.7250},
        {cap: 586, tiempo: 0.8700},
        {cap: 583, tiempo: 0.7250},
        {cap: 672, tiempo: 1.0150},
        {cap: 688, tiempo: 0.5800},
        {cap: 694, tiempo: 0.5800},
        {cap: 715, tiempo: 0.8700},
        {cap: 795, tiempo: 1.0150},
        {cap: 836, tiempo: 1.4500},
        {cap: 885, tiempo: 1.4500},
        {cap: 994, tiempo: 1.3050},
        {cap: 1080, tiempo: 1.0150},
        {cap: 1150, tiempo: 1.0150},
        {cap: 1260, tiempo: 2.0300},
        {cap: 1450, tiempo: 2.0300},
        {cap: 1730, tiempo: 2.0300},
        {cap: 2050, tiempo: 3.0450},
        {cap: 2480, tiempo: 3.7700},
        {cap: 2720, tiempo: 4.9300},
        {cap: 3190, tiempo: 4.9300},
        {cap: 3260, tiempo: 5.8290},
        {cap: 3980, tiempo: 7.7720},
        {cap: 4500, tiempo: 7.7720},
        {cap: 5530, tiempo: 7.7720},
        {cap: 6540, tiempo: 7.7720},
    ];


    const getMts = (valor: number): [number, number] => {
        const rango = tablaAmperajeYMetros.find(r => valor >= r.min && valor <= r.max)
        return rango ? [rango.mts, rango.peso] : [0, 0]
    }

    const getTiempo = (valor: number): number => {
        // Buscar el registro más cercano sin pasarse
        let tiempo = 0;
        for (let i = 0; i < tablaTiempo.length; i++) {
            if (valor >= tablaTiempo[i].cap) {
                tiempo = tablaTiempo[i].tiempo;
            } else {
                break;
            }
        }
        return tiempo;
    };


    const esValido = (valor: any) => valor != null && !isNaN(valor);
    const esNegativo = (valor: any) => valor < 0;

    const MultiplyRound = (a: number, b: number = 1): number => {

        return Math.round(a * b * 10000) / 10000
    }


    const getFilasParaGuardar = (data: CobreData) => {
        let filasParaGuardar = [];

        const columnas = [data.textocolumna1, data.textocolumna2, data.textocolumna3, data.textocolumna4]
        let hyper = 0
        for (let i = 0; i < columnas[hyper].length; i++) {

            if (data.amperios[i] > 0 || data.cantidades[i] > 0) {
                filasParaGuardar.push({
                    textocolumna: columnas[hyper][i],
                    amperios: data.amperios[i],
                    cantidades: data.cantidades[i],
                    metros: data.metros[i],
                    pesos: data.pesos[i],
                    pesototal: data.pesototal[i],
                    valortotal: data.valortotal[i],
                    tiempoprincipal: data.tiempoprincipal[i],
                    tipo: 'normal',
                    tiponum: 1,
                });
            }
        }
        hyper++
        for (let i = 0; i < columnas[hyper].length; i++) {

            if (data.cantidades2[i] > 0) {
                filasParaGuardar.push({
                    cantidades: data.cantidades2[i],
                    valortotal: data.valortotal2[i],
                    tiempoprincipal: data.tiempoprincipal2[i],

                    textocolumna: columnas[hyper][i],

                    amperios: 0,
                    metros: 0,
                    pesos: 0,
                    pesototal: 0,
                    tipo: 'normal',
                    tiponum: 1,
                });
            }
        }
        hyper++
        for (let i = 0; i < columnas[hyper].length; i++) {

            if (data.cantidades3[i] > 0) {
                filasParaGuardar.push({
                    textocolumna: columnas[hyper][i],
                    amperios: data.amperios3[i],
                    cantidades: data.cantidades3[i],
                    metros: data.metros3[i],
                    pesos: data.pesos3[i],
                    pesototal: data.pesototal3[i],
                    valortotal: data.valortotal3[i],
                    tiempoprincipal: data.tiempoprincipal3[i],
                    //soportest450: [0, 0],
                    tipo: 'normal',
                    tiponum: 1,
                });
            }
        }
        hyper++

        filasParaGuardar.push({
            textocolumna: columnas[hyper][0],
            amperios: 0,
            cantidades: data.cantidades4[0],
            metros: 0,
            pesos: 0,
            pesototal: 0,

            valortotal: data.valorElectrogible[0],
            tiempoprincipal: data.tiempoElectrogible[0],
            tipo: 'normal',
            tiponum: 1,

        });
        filasParaGuardar.push({
            textocolumna: 'Total',
            amperios: 0,
            cantidades: 0,
            metros: 0,
            pesos: 0,
            pesototal: 0,

            valortotal: data.abstotal,
            tiempoprincipal: data.t_abstotl,
            tipo: 'total',
            tiponum: 2,

        });

        return filasParaGuardar
    }


    return {
        getMts,
        getTiempo,
        esValido,
        esNegativo,
        MultiplyRound,
        getFilasParaGuardar,
    }
}