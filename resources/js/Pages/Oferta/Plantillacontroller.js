// utils/demoOferta.ts
export function PlantillaUno(data, indexItem, parte = 1) {
    if (indexItem === 0 && parte === 1)
        data.equipos = [

            // data.equipos[0].equipo_selec = 
            {
                nombre_item: 'CELDA DE MEDIDA MT', cantidad: 1, equipo_selec: {
                    precio_de_lista: 1475414,
                    precio_de_lista2: 1475414,
                    title: "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X1000X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44.  TIPO GEA-C",
                    value: 73240,
                    cantidad: 1,
                },
            },
            {
                cantidad: 1, equipo_selec: {
                    precio_de_lista: 0,
                    precio_de_lista2: 0,
                    title: "CELDA DE MEDIDA MT 17,5 KV CON ENTRADA A CABLE Y SALIDA A BARRA, 3 TC´S Y 3  TP´S (SIN MEDIDOR)",
                    cantidad: 1,
                    value: 4122
                },
            },
            {
                cantidad: 1, equipo_selec: {
                    precio_de_lista: 802500,
                    precio_de_lista2: 802500,
                    title: "BREAKER 3X100A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    value: 14
                },
            },
            // data.equipos[2].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 3450000,
                    precio_de_lista2: 3450000,
                    title: "TRANSFOMADORES DE POTENCIAL 13200^3/120^3 V INTERIOR. CALIBRADO. SEGUN NORMA",
                    value: 24901
                },
            },
            // data.equipos[3].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 2550000,
                    precio_de_lista2: 2550000,
                    title: "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S  CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
                    value: 23301
                },
            },
            // data.equipos[4].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 1500000,
                    precio_de_lista2: 1500000,
                    title: "CONVERSOR DE PUERTO ETHERNET A RS232 O RS485 PARA INSTALACION CONECTADO AL MEDIDOR",
                    value: 23310
                },
            },
            // data.equipos[5].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 240000,
                    precio_de_lista2: 240000,
                    title: "BORNERA DE PRUEBA TIPO LANDIS",
                    value: 23314
                },
            },
            // data.equipos[6].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 525000,
                    precio_de_lista2: 525000,
                    title: "BORNERA DE PRUEBA TIPO CUCHILLA",
                    value: 99677
                },
            },
            // data.equipos[7].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 442864,
                    precio_de_lista2: 442864,
                    title: "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO MT",
                    value: 59820
                },
            },
            // data.equipos[8].equipo_selec = 
            {
                equipo_selec: {
                    precio_de_lista: 196047,
                    precio_de_lista2: 196047,
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    value: 91028
                },
            },
        ]
    if (indexItem === 1 && parte === 1)
        data.equipos = [
            //2 - index[9]
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 9
                    precio_de_lista: 2765751.275,
                    precio_de_lista2: 2765751.275,
                    title: "CELDA DE MEDIDA EN 17.5 KV. FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14-16. 1600X1100X1200 mm",
                    value: 69303,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 10
                    precio_de_lista: 0,
                    precio_de_lista2: 0,
                    title: "CELDA DE MEDIDA MT 17,5 KV CON ENTRADA A CABLE Y SALIDA A BARRA, 3 TC´S Y 3  TP´S (SIN MEDIDOR)",
                    value: 4122,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 11
                    precio_de_lista: 1400000,
                    precio_de_lista2: 1400000,
                    title: "TRANSFOMADORES DE CORRIENTE DE 80/5 17,5 KV INTERIOR CALIBRADO. SEGUN NORMA",
                    value: 24805,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 12
                    precio_de_lista: 2300000,
                    precio_de_lista2: 2300000,
                    title: "TRANSFOMADORES DE POTENCIAL 13200^3/120^3 V INTERIOR. CALIBRADO. SEGUN NORMA",
                    value: 24901,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 13
                    precio_de_lista: 1700000,
                    precio_de_lista2: 1700000,
                    title: "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
                    value: 23301,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 14
                    precio_de_lista: 1000000,
                    precio_de_lista2: 1000000,
                    title: "CONVERSOR DE PUERTO ETHERNET A RS232 O RS485 PARA INSTALACION CONECTADO AL MEDIDOR",
                    value: 23310,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 15
                    precio_de_lista: 350000,
                    precio_de_lista2: 350000,
                    title: "BORNERA DE PRUEBA TIPO CUCHILLA",
                    value: 99677,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 16
                    precio_de_lista: 8642,
                    precio_de_lista2: 8642,
                    title: 'CORAZA 1"',
                    value: 85168,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 17
                    precio_de_lista: 295242.78,
                    precio_de_lista2: 295242.78,
                    title: "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO MT",
                    value: 59820,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 18
                    precio_de_lista: 13500,
                    precio_de_lista2: 13500,
                    title: "LAMPARA LED 9W 110VAC",
                    value: 51019,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 19
                    precio_de_lista: 174835.1196,
                    precio_de_lista2: 174835.1196,
                    title: "KIT DE CABLEADO DE CONTROL CALEFACCION CON TERMOSTATO",
                    value: 59837,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 20
                    precio_de_lista: 86219.0172,
                    precio_de_lista2: 86219.0172,
                    title: "KIT DE CABLEADO DE CONTROL ILUMINACION CON MICROSWICHE",
                    value: 59836,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 21
                    precio_de_lista: 461024.304,
                    precio_de_lista2: 461024.304,
                    title: "Barraje principal 3F+N+T. Según norma.",
                    value: 0,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 22
                    precio_de_lista: 1103316.564,
                    precio_de_lista2: 1103316.564,
                    title: "Mano de obra Fabricación",
                    value: 0,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: { //index 23
                    precio_de_lista: 126482,
                    precio_de_lista2: 126482,
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    value: 91028,
                },
            },
        ];
    if (indexItem === 2 && parte === 1)
        data.equipos = [
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 3786184.788,
                    precio_de_lista2: 3786184.788,
                    title: "CELDA SECCIONADOR EN AIRE 17.5 KV. FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14-16. 2200X1100X1200 mm",
                    value: 69301,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 8692500,
                    precio_de_lista2: 8692500,
                    title: "SECCIONADORES TRIPOLARES DE OPERACIÓN BAJO CARGA PARA USO INTERIOR SERIE 17,5 KV. CON PORTAFUSIBLES, DISPARO TRIPOLAR Y CUCHILLAS DE PUESTA A TIERRA RAPIDAS",
                    value: 4604,
                },
            },
            {
                cantidad: 3, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 368918.55,
                    precio_de_lista2: 368918.55,
                    title: "FUSIBLE DE MT TIPO HH 31,5 AMP 24 KV",
                    value: 51105,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 49542.48,
                    precio_de_lista2: 49542.48,
                    title: "Barraje principal T. Según norma.",
                    value: 0,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 694308.5184,
                    precio_de_lista2: 694308.5184,
                    title: "Mano de obra Fabricación",
                    value: 0,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 196047.1,
                    precio_de_lista2: 196047.1,
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    value: 91028,
                },
            },
        ];
    if (indexItem === 3 && parte === 1)
        data.equipos = [
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 19988254.13,
                    precio_de_lista2: 19988254.13,
                    title: "CELDA DE PROTECCION CON SECCIONADOR DE OPERACIÓN  BAJO CARGA CON FUSIBLES 17,5 KV. 630A 20KA.",
                    value: 4112,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 13403299.5,
                    precio_de_lista2: 13403299.5,
                    title: "CELDA DE PROTECCION CON SECCIONADOR DE OPERACIÓN MANUAL BAJO CARGA CON CUCHILLA DE PUESTA A TIERRA Y BASE PORTA FUSIBLES TIPO HH NORMA DIN 43625, DETECTOR DE TENSIÓN CAPACITIVO CON INDICADORES LUMINOSOS, SEÑALIZACION MECANICA DE FUSION DE FUSIBLES, ESTADO DEL SECCIONADOR Y CUCHILLA DE PUESTA A TIERRA. PORTA CANDADO PARA BLOQUEO DE SEGURIDAD. VENTANA DE INSPECCION POSICION CUCHILLA. MEDIDOR DE PRESION DE GAS SF6 DEL SECCIONADOR. APERTURA Y DISPARO TRIPOLAR POR FUSION DE FUSIBLES. DIMENSIONES 1600x375x960mm (AltoxAnchoxProf). INCLUYE PALANCA. 24KV. 630A. 20KA. IAC: A-FL. LSC2. IP3X, IEC62271-200.",
                    value: 4235,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 446880,
                    precio_de_lista2: 446880,
                    title: "JUEGO DE BARRAS (X3) PARA INTERCONEXION ENTRE CELDAS 480A CON TERMOENCOGIBLE EN MT",
                    value: 4238,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 135000,
                    precio_de_lista2: 135000,
                    title: "PALANCA DE OPERACIÓN SECCIONADORES",
                    value: 4116,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 330714,
                    precio_de_lista2: 330714,
                    title: "TAPA LATERAL GALVANIZADA PARA SECCIONADORES",
                    value: 4117,
                },
            },
            {
                cantidad: 3, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 506808.225,
                    precio_de_lista2: 506808.225,
                    title: "FUSIBLE DE MT TIPO HH 50 AMP 24 KV",
                    value: 51107,
                },
            },
            {
                cantidad: 1, subtotalequip: 0, equipo_selec: {
                    precio_de_lista: 196047.1,
                    precio_de_lista2: 196047.1,
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    value: 91028,
                },
            },
        ];
    if (indexItem === 4 && parte === 1)
        data.equipos = [
            {
                nombre_item: 'CELDA DE ENTRADA O SALIDA', cantidad: 1, equipo_selec: {
                    value: '4111',
                    title: 'CELDA DE ENTRADA O SALIDA DE LINEA CON SECCIONADOR DE OPERACIÓN  BAJO CARGA 17,5 KV. 630A 20KA.',
                    cantidad: 1,
                    precio_de_lista: 17892107.63,
                    precio_de_lista2: 17892107.63
                },
            },
            {
                cantidad: 1, equipo_selec: {
                    value: '4236',
                    title: 'CELDA DE ENTRADA O SALIDA DE LINEA CON SECCIONADOR DE OPERACIÓN MANUAL  BAJO CARGA CON CUCHILLA DE PUESTA A TIERRA, DETECTOR DE TENSION CAPACITIVO CON INDICADORES LUMINOSOS, SEÑALIZACION MECANICA DE  ESTADO DEL SECCIONADOR Y CUCHILLA DE PUESTA A TIERRA. PORTA CANDADO PARA BLOQUEO DE SEGURIDAD. VENTANA DE INSPECCION POSICION CUCHILLA. MEDIDOR DE PRESION DE GAS SF6 DEL SECCIONADOR. APERTURA TRIPOLAR FUSIBLES. DIMENSIONES  1600x375x960mm (AltoxAnchoxProf). INCLUYE PALANCA. 24KV. 630A. 20KA. IAC: A-FL. LSC2. IP3X, IEC62271-200.',
                    cantidad: 1,
                    precio_de_lista: 11486878.46,
                    precio_de_lista2: 11486878.46,
                }
            },
            {
                cantidad: 1, equipo_selec: {
                    value: '04238',
                    title: 'JUEGO DE BARRAS (X3) PARA INTERCONEXION ENTRE CELDAS 480A CON TERMOENCOGIBLE EN MT',
                    cantidad: 1,
                    precio_de_lista: 446880,
                    precio_de_lista2: 446880
                }
            },
            {
                cantidad: 1, equipo_selec: {
                    value: '4116',
                    title: 'PALANCA DE OPERACIÓN SECCIONADORES',
                    cantidad: 1,
                    precio_de_lista: 135000,
                    precio_de_lista2: 135000
                }
            },
            {
                cantidad: 1, equipo_selec: {
                    value: '4117',
                    title: 'TAPA LATERAL GALVANIZADA PARA SECCIONADORES',
                    cantidad: 1,
                    precio_de_lista: 330714,
                    precio_de_lista2: 330714
                }
            },
            {
                cantidad: 1, equipo_selec: {
                    value: '91001',
                    title: 'EMPAQUE CARTON Y STRECH (NO USAR)',
                    cantidad: 1,
                    precio_de_lista: 8680,
                    precio_de_lista2: 8680
                }
            },
        ];
    if (indexItem === 5 && parte === 1)
        data.equipos = [
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA", cantidad: 1, equipo_selec: {
                    value: "69318",
                    title: "BUTACO PARA SALIDA DE CABLES CELDA TIPO SF6. FABRICADO EN LÁMINA GALVANIZADA CALIBRE 16. PINTURA RAL 7035. DIMENSIONES 400X400X940",
                    cantidad: 1,
                    precio_de_lista: 297279.2768,
                    precio_de_lista2: 297279.2768
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "69319",
                    title: "REBANCO (CELDA DE REMONTE) PARA ENTRADA DE CABLES EN CELDAS TIPO SF6. FABRICADO EN LÁMINA GALVANIZADA CALIBRE 16. PINTURA RAL 7035. BISAGRADO CON CHAPA. DIMENSIONES 2000X400X940",
                    cantidad: 1,
                    precio_de_lista: 1177438.671,
                    precio_de_lista2: 1177438.671
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "69322",
                    title: "REBANCO (CELDA DE REMONTE) PARA ENTRADA DE CABLES EN CELDAS TIPO SF6. FABRICADO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA RAL 7035. BISAGRADO CON CHAPA. DIMENSIONES 1600X400X940",
                    cantidad: 1,
                    precio_de_lista: 1073253.426,
                    precio_de_lista2: 1073253.426
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "4101",
                    title: "CELDA DE REMONTE DE CABLES SIN BARRAJE.  24 KV",
                    cantidad: 1,
                    precio_de_lista: 4722896.5,
                    precio_de_lista2: 4722896.5
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "4237",
                    title: "CELDA DE REMONTE PARA ENTRADA DE CABLES CON SISTEMA DE BARRAS HORIZONTAL Y VERTICAL PARA INTERCONEXION CON EL SECCIONADOR, DETECTOR DE TENSION CAPACITIVO CON INDICADORES LUMINOSOS. VENTANA DE INSPECCION ESTADO CABLES Y CONEXIONES. Dimensiones 1600x375x950mm (AltoxAnchoxProf)",
                    cantidad: 1,
                    precio_de_lista: 5749812,
                    precio_de_lista2: 5749812
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "MOF",
                    title: "Mano de obra Fabricación",
                    cantidad: 1,
                    precio_de_lista: 1451315.062,
                    precio_de_lista2: 1451315.062
                }
            },
            {
                nombre_item: "REBANCO ENTRADA  (REMONTE) Y BUTACO SALIDA",
                cantidad: 1,
                equipo_selec: {
                    value: "91028",
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 196047.1,
                    precio_de_lista2: 196047.1
                }
            }
        ];
    if (indexItem === 6 && parte === 1)
        data.equipos = [
            {
                nombre_item: "CELDA TRIPLEX", cantidad: 1, equipo_selec: {
                    value: "69301",
                    title: "CELDA SECCIONADOR EN AIRE 17.5 KV. FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14-16. 2200X1100X1200 mm",
                    cantidad: 1,
                    precio_de_lista: 3786184.788,
                    precio_de_lista2: 3786184.788,
                    alerta_mano_obra: 10.12
                },
            }, {
                nombre_item: "CELDA TRIPLEX", cantidad: 1, equipo_selec: {
                    value: "4606",
                    title: "SECCIONADORES TRIPOLARES DE OPERACIÓN BAJO CARGA PARA USO INTERIOR SERIE 17,5 KV. TRIPOLAR ENTRADA Y SALIDA (DUPLEX) (1 ENTRADA - 2 SALIDAS SIN ENCLAVAMIENTO)",
                    cantidad: 1,
                    precio_de_lista: 7902000,
                    precio_de_lista2: 7902000,
                    alerta_mano_obra: 10.12
                },
            },
            {
                nombre_item: "CELDA TRIPLEX", cantidad: 1, equipo_selec:
                    {
                        value: "4601",
                        title: "SECCIONADORES TRIPOLARES DE OPERACIÓN BAJO CARGA PARA USO INTERIOR SERIE 17,5 KV. CON PORTAFUSIBLES Y DISPARO TRIPOLAR.",
                        cantidad: 1,
                        precio_de_lista: 6504000,
                        precio_de_lista2: 6504000,
                        alerta_mano_obra: 10.12
                    },
            },
            {
                nombre_item: "CELDA TRIPLEX", cantidad: 3, equipo_selec:
                    {
                        value: "51101",
                        title: "FUSIBLE DE MT TIPO HH 10 AMP 24 KV",
                        cantidad: 3,
                        precio_de_lista: 346603.95,
                        precio_de_lista2: 1039811.85,
                        alerta_mano_obra: 0
                    },
            }, {
                nombre_item: "CELDA TRIPLEX", cantidad: 2, equipo_selec:
                    {
                        value: "91028",
                        title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                        cantidad: 2,
                        precio_de_lista: 196047.1,
                        precio_de_lista2: 196047.1,
                        alerta_mano_obra: 0
                    }
            }
        ]
    if (indexItem === 7 && parte === 1)
        data.equipos = [
                {
                    nombre_item: "CELDA PARA TRAFO SECO 17,5KV. COLD ROLLED 2200X2400X1700 mm (NO INCLUYE VENTILACIÓN FORZADA)",
                    cantidad: 1,
                    equipo_selec: {
                        value: "69308",
                        title: "CELDA PARA TRAFO SECO 17,5KV. COLD ROLLED 2200X2400X1700 mm (NO INCLUYE VENTILACIÓN FORZADA)",
                        cantidad: 1,
                        precio_de_lista: 6082124.836,
                        precio_de_lista2: 6082124.836,
                        alerta_mano_obra: "T-35,08"
                    }
                },
                {
                    nombre_item: "VENTILADOR 16\" AXIAL INDUSTRIAL CON MOTOR MONOFASICO 110/220V. CAUDAL 1,11 M3/S.",
                    cantidad: 2,
                    equipo_selec: {
                        value: "30226",
                        title: "VENTILADOR 16\" AXIAL INDUSTRIAL CON MOTOR MONOFASICO 110/220V. CAUDAL 1,11 M3/S.",
                        cantidad: 2,
                        precio_de_lista: 1155516,
                        precio_de_lista2: 2311032,
                        alerta_mano_obra: "T-1,2"
                    }
                },
                {
                    nombre_item: "ITEM SIN CODIGO (EJEMPLO KIT DE VENTILACION)", cantidad: 1,
                    equipo_selec: {
                        value: "",
                        title: "ITEM SIN CODIGO (EJEMPLO KIT DE VENTILACION)",
                        cantidad: 1,
                        precio_de_lista: 0,
                        precio_de_lista2: 0,
                        alerta_mano_obra: "T-5"
                    }
                },
                {
                    nombre_item: "Barraje principal T. Según norma.", cantidad: 1,
                    equipo_selec: {
                        value: "",
                        title: "Barraje principal T. Según norma.",
                        cantidad: 1,
                        precio_de_lista: 49542.48,
                        precio_de_lista2: 49542.48,
                        alerta_mano_obra: 0
                    }
                },
                {
                    nombre_item: "Mano de obra Fabricación", cantidad: 1,
                    equipo_selec: {
                        value: "",
                        title: "Mano de obra Fabricación",
                        cantidad: 1,
                        precio_de_lista: 1436496.602,
                        precio_de_lista2: 1436496.602,
                        alerta_mano_obra: 0
                    }
                },
                {
                    nombre_item: "T. EMPAQUE CARTON Y STRECH", cantidad: 1,
                    equipo_selec: {
                        value: "91027",
                        title: "T. EMPAQUE CARTON Y STRECH",
                        cantidad: 1,
                        precio_de_lista: 117800,
                        precio_de_lista2: 117800,
                        alerta_mano_obra: 0
                    }
                }
            ]
    if (indexItem === 8 && parte === 1)
        data.equipos = [
            {
                nombre_item: "INTERCONEXION TRAFO EN DEMCO",
                cantidad: 1,
                equipo_selec: {
                    value: "72691",
                    title: "SOPORTE EN ANGULO INTERRUPTOR CELDA DE TRANSFORMADOR",
                    cantidad: 1,
                    precio_de_lista: 725327.925,
                    precio_de_lista2: 725327.925
                }
            },
            {
                nombre_item: "INTERCONEXION TRAFO EN DEMCO",
                cantidad: 32,
                equipo_selec: {
                    value: "60475",
                    title: "ARANDELA CONICA PARA TORNILLO diámetro 10mm",
                    cantidad: 32,
                    precio_de_lista: 3132.55,
                    precio_de_lista2: 3132.55
                }
            },
            {
                nombre_item: "INTERCONEXION TRAFO EN DEMCO",
                cantidad: 1,
                equipo_selec: {
                    value: "91027",
                    title: "T. EMPAQUE CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 117800,
                    precio_de_lista2: 117800
                }
            }
        ];
    if (indexItem === 9 && parte === 1)
        data.equipos = [
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "73246",
                    title: "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44.  TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 1428525.096,
                    precio_de_lista2: 1428525.096,
                    alerta_mano_obra: 26.22
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "73339",
                    title: "GABINETE FABRICADO EN LÁMINA GALVANIZADA CALIBRE 14 Y 16, 2200X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP56. TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 2131924.91,
                    precio_de_lista2: 2131924.91,
                    alerta_mano_obra: 26.22
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "72651",
                    title: "Placa de Montaje Estándar 2000 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #16. +Juego de Soportes (x6 und)",
                    cantidad: 1,
                    precio_de_lista: 174121.999,
                    precio_de_lista2: 174121.999,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 4,
                equipo_selec: {
                    value: "72671",
                    title: "Placa de Montaje Estándar 400 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #18. +Juego de Soportes (x4 und)",
                    cantidad: 1,
                    precio_de_lista: 46713.69273,
                    precio_de_lista2: 46713.69273,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "72690",
                    title: "SOPORTE EN ANGULO INTERRUPTOR PARA TABLERO GEA",
                    cantidad: 1,
                    precio_de_lista: 74872.56,
                    precio_de_lista2: 74872.56,
                    alerta_mano_obra: 1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "72689",
                    title: "CUBICULO DE MEDIDA PARA TABLERO GEA",
                    cantidad: 1,
                    precio_de_lista: 185841.9272,
                    precio_de_lista2: 185841.9272,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "69878",
                    title: "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X800 MM",
                    cantidad: 1,
                    precio_de_lista: 356198.696,
                    precio_de_lista2: 356198.696,
                    alerta_mano_obra: 7.25
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87736",
                    title: "BREAKER 3X(800)A 60/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 2197161.472,
                    precio_de_lista2: 2197161.472,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "1730",
                    title: "BREAKER 3X(560-800) A 85/55 KA 240/440V LI-TM. NO MOTORIZABLE",
                    cantidad: 1,
                    precio_de_lista: 5683896.0,
                    precio_de_lista2: 5683896.0,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "123",
                    title: "BREAKER 3X(320-800) A 50/50 KA 240/440V MICROLOGIC 2.0 E",
                    cantidad: 1,
                    precio_de_lista: 6235400.0,
                    precio_de_lista2: 6235400.0,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "275",
                    title: "BREAKER 3X(320-800) A 65/65 KA 240/440V UNIDAD DE DISPARO ET6G (Ir, Ig, Isd, li, 1SD. 1 OF)",
                    cantidad: 1,
                    precio_de_lista: 12646633.44,
                    precio_de_lista2: 12646633.44,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87321",
                    title: "INTERRUPTOR TERMOMAGNETICO CAJA MOLDEADA 3P, AJUSTE TERMICO 560-800A, AJUSTE MAGNETICO 5600-8000A, 65 KA-240V, 42 KA-440V",
                    cantidad: 1,
                    precio_de_lista: 3167680.0,
                    precio_de_lista2: 3167680.0,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "2161",
                    title: "KIT DE TRANSFERENCIA 320-800A CON INTERRUPTOR DE POTENCIA 3WT",
                    cantidad: 1,
                    precio_de_lista: 20546397.6,
                    precio_de_lista2: 20546397.6,
                    alerta_mano_obra: 5.05
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "130",
                    title: "BREAKER 3X(320-800) A 50/50 KA 240/440V MICROLOGIC 2.0 MOTORIZADO + MX+XF+1SDE",
                    cantidad: 1,
                    precio_de_lista: 11017168.32,
                    precio_de_lista2: 11017168.32,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "501",
                    title: "PLACA DE ENCLAVAMIENTO Y CABLES GUAYAS PARA 2 BREAKER",
                    cantidad: 1,
                    precio_de_lista: 3252028.0,
                    precio_de_lista2: 3252028.0,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87456",
                    title: "KIT CTM1000-S800DAS800DA3P-1000E46, PARA TRANSFERENCIA AUTOMÁTICA CON 2 INTERRUPTORES DWB800S800-3DA, In=560…800A, ENCLAVAMIENTO MECANICO POSTERIOR, ACCIONAMIENTOS MOTORIZADOS 220VAC Y BLOQUES DE CONTACTOS AUXILAR Y ALARMA",
                    cantidad: 1,
                    precio_de_lista: 15038720.0,
                    precio_de_lista2: 15038720.0,
                    alerta_mano_obra: 5.05
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "224",
                    title: "BREAKER 3X(400-1000) A 65/65 KA 240/440V MICROLOGIC 2.0E FIJO",
                    cantidad: 1,
                    precio_de_lista: 0.0,
                    precio_de_lista2: 0.0,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "538",
                    title: "ENCLAVAMIENTO MECANICO CON GUAYA PARA 1 INTERRUPTOR",
                    cantidad: 1,
                    precio_de_lista: 1855188.64,
                    precio_de_lista2: 1855188.64,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "539",
                    title: "SET DE GUAYAS (CABLES) PARA 2 INTERRUPTORES",
                    cantidad: 1,
                    precio_de_lista: 647035.2,
                    precio_de_lista2: 647035.2,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "417",
                    title: "CONTACTO AUXILIAR OF ó SD",
                    cantidad: 1,
                    precio_de_lista: 179840.0,
                    precio_de_lista2: 179840,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "2178",
                    title: "KIT DE TRANSFERENCIA 320-800A CON INTERRUPTOR 3VA27 LSIG",
                    cantidad: 1,
                    precio_de_lista: 0.0,
                    precio_de_lista2: 0.0,
                    alerta_mano_obra: 5.05
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "116",
                    title: "BREAKER 3X(250-630) A 85/42 KA 240/440V MICROLOGIC 2.3",
                    cantidad: 1,
                    precio_de_lista: 5428958.56,
                    precio_de_lista2: 5428958.56,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "486",
                    title: "PLACA DE ENCLAVAMIENTO MECANICO",
                    cantidad: 1,
                    precio_de_lista: 1503415.2,
                    precio_de_lista2: 1503415.2,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "547",
                    title: "PERCUTOR DE DISPARO",
                    cantidad: 1,
                    precio_de_lista: 97760.0,
                    precio_de_lista2: 97760.0,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "474",
                    title: "MANDO MOTORIZADO 240V",
                    cantidad: 1,
                    precio_de_lista: 3777399.36,
                    precio_de_lista2: 3777399.36,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 4,
                equipo_selec: {
                    value: "417",
                    title: "CONTACTO AUXILIAR OF ó SD",
                    cantidad: 1,
                    precio_de_lista: 179840.0,
                    precio_de_lista2: 179840,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "577",
                    title: "BREAKER 3X(504-630), 35KA @ 440V UNIDAD ELECTRONICA",
                    cantidad: 1,
                    precio_de_lista: 2263535.872,
                    precio_de_lista2: 2263535.872,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "902",
                    title: "MANDO MOTORIZADO 200-240VAC",
                    cantidad: 1,
                    precio_de_lista: 0.0,
                    precio_de_lista2: 0.0,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "885",
                    title: "BOBINA DE DISPARO 200-240VAC",
                    cantidad: 1,
                    precio_de_lista: 127278.864,
                    precio_de_lista2: 127278.864,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 4,
                equipo_selec: {
                    value: "891",
                    title: "CONTACTOS AUXILIARES Y DE ALARMA 1NA",
                    cantidad: 1,
                    precio_de_lista: 32542.848,
                    precio_de_lista2: 32542.848,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "922",
                    title: "ENCLAVAMIENTO TIPO GUAYA",
                    cantidad: 1,
                    precio_de_lista: 0.0,
                    precio_de_lista2: 0.0,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "924",
                    title: "CABLE ENCLAVAMIENTO 225MM",
                    cantidad: 1,
                    precio_de_lista: 0.0,
                    precio_de_lista2: 0.0,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "715",
                    title: "BREAKER 3X(800-2000) A 50 KA 690V. TIPO ABIERTO FIJO. LSIG. COMUNICACIÓN MODBUS",
                    cantidad: 1,
                    precio_de_lista: 16480421.23,
                    precio_de_lista2: 16480421.23,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "974",
                    title: "Enclavamiento mécanico para interruptores de montaje fijo, a traves de 2 interruptores de 1600A a 4000A",
                    cantidad: 1,
                    precio_de_lista: 2408170.752,
                    precio_de_lista2: 2408170.752,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "962",
                    title: "MANDO MOTORIZADO 208-240 VAC/DC",
                    cantidad: 1,
                    precio_de_lista: 924216.544,
                    precio_de_lista2: 924216.544,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "968",
                    title: "BOBINA DE APERTURA 220-240 VAC/DC",
                    cantidad: 1,
                    precio_de_lista: 357247.984,
                    precio_de_lista2: 357247.984,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "965",
                    title: "BOBINA DE CIERRE 220-240 VAC/DC",
                    cantidad: 1,
                    precio_de_lista: 300840.72,
                    precio_de_lista2: 300840.72,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "982",
                    title: "CONTACTOS AUXILIARES 2NA+NC",
                    cantidad: 1,
                    precio_de_lista: 188025.344,
                    precio_de_lista2: 188025.344,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "977",
                    title: "KIT DE CABLES ENCLAVAMIENTO MECANICO DE 1,5 MTS",
                    cantidad: 1,
                    precio_de_lista: 1264108.512,
                    precio_de_lista2: 1264108.512,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "22111",
                    title: "RELE DE TRANSFERENCIA AUTOMATICA, RED-RED Y RED - GENERADOR, 50-576AC, 1-3 FASES, DISPLAY GRAFICO 144X144 MM. CONTROL DE BAJO Y SOBRE VOLTAJE, PERDIDA DE FASE, ASIMETRIA, BAJA Y ALTA FRECUENCIA. RANGO DE ALIMENTACION AUXILIAR 90-260 VAC",
                    cantidad: 1,
                    precio_de_lista: 2609555.2,
                    precio_de_lista2: 2609555.2,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "59801",
                    title: "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MOTORIZADOS Y ATL 220V",
                    cantidad: 1,
                    precio_de_lista: 603964.2835,
                    precio_de_lista2: 603964.2835,
                    alerta_mano_obra: 11.68
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "22142",
                    title: "CONTROLADOR CONMUTADOR DE TRANSFERENCIAS AUTOMATICAS POWER",
                    cantidad: 1,
                    precio_de_lista: 1184000.0,
                    precio_de_lista2: 1184000.0,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "50853",
                    title: "FUENTE CONMUTADA 5A ,ENTRADA 90/264 Vac,SALIDA 24 Vdc. MONTAJE EN RIEL",
                    cantidad: 1,
                    precio_de_lista: 357499.296,
                    precio_de_lista2: 357499.296,
                    alerta_mano_obra: 0.35
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "59802",
                    title: "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MOTORIZADOS Y COMAP 220V",
                    cantidad: 1,
                    precio_de_lista: 705994.0051,
                    precio_de_lista2: 705994.0051,
                    alerta_mano_obra: 11.68
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "87722",
                    title: "BREAKER 3X(100)A 30/20KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "87725",
                    title: "BREAKER 3X(160)A 65/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 232263.68,
                    precio_de_lista2: 232263.68,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "87729",
                    title: "BREAKER 3X(250)A 65/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 232263.68,
                    precio_de_lista2: 232263.68,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87734",
                    title: "BREAKER 3X(630)A 60/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 1137396.224,
                    precio_de_lista2: 1137396.224,
                    alerta_mano_obra: 0.15
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87736",
                    title: "BREAKER 3X(800)A 60/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 2197161.472,
                    precio_de_lista2: 2197161.472,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "2092",
                    title: "BREAKER 3X20 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "01359",
                    title: "BREAKER 3X25 A 25/16/8 KA 230/415/440 V",
                    cantidad: 1,
                    precio_de_lista: 217872.0,
                    precio_de_lista2: 217872.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "02096",
                    title: "BREAKER 3X50 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "02097",
                    title: "BREAKER 3X63 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "02129",
                    title: "BREAKER 3X630 A 50/36KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 1344507.336,
                    precio_de_lista2: 1344507.336,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "02132",
                    title: "BREAKER 3X(20-25) A 35/25KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 234699.0876,
                    precio_de_lista2: 234699.0876,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 4,
                equipo_selec: {
                    value: "9",
                    title: "BREAKER 3X30A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360.0,
                    precio_de_lista2: 265360.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "14",
                    title: "BREAKER 3X100A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360.0,
                    precio_de_lista2: 265360.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 2,
                equipo_selec: {
                    value: "19",
                    title: "BREAKER 3X200A 50/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 712712.32,
                    precio_de_lista2: 712712.32,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "123",
                    title: "BREAKER 3X(320-800) A 50/50 KA 240/440V MICROLOGIC 2.0 E",
                    cantidad: 1,
                    precio_de_lista: 6235400.0,
                    precio_de_lista2: 6235400.0,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "277",
                    title: "BREAKER 3X(480-1200) A 65/65 KA 240/440V UNIDAD DE DISPARO ET6G (Ir, Ig, Isd, li, 1SD. 1 OF)",
                    cantidad: 1,
                    precio_de_lista: 13577432.32,
                    precio_de_lista2: 13577432.32,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "03430",
                    title: "BREAKER    3X100,    10KA,   240VAC, 8KA,  440VAC.",
                    cantidad: 1,
                    precio_de_lista: 280320.0,
                    precio_de_lista2: 280320.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "03431",
                    title: "BREAKER    3X125,    10KA,   240VAC, 8KA,  440VAC.",
                    cantidad: 1,
                    precio_de_lista: 603648.0,
                    precio_de_lista2: 603648.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "23401",
                    title: "MEDIDOR MULTIFUNCIONAL, PANTALLA LCD. MEDIDAS DE VOLTAJE, CORRIENTE, POTENCIAS (ACTIVA, REACTIVA Y APARENTE), FACTOR DE POTENCIA, FRECUENCIA, ENERGIA ACTIVA Y REACTIVA. DIMENSIONES 96X96MM. COMUNICACIONES MODBUS-RTU RS485. ENTRADA DE 1-5AMP, 480VAC. AUX 100-240 VAC/DC",
                    cantidad: 1,
                    precio_de_lista: 465106.432,
                    precio_de_lista2: 465106.432,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "23464",
                    title: "MEDIDOR DE ENERGIA MULTIFUNCIONAL (I+V+FP+HZ+80-480 VAC)",
                    cantidad: 1,
                    precio_de_lista: 867968.64,
                    precio_de_lista2: 867968.64,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "23484",
                    title: "MEDIDOR DE ENERGIA BIDIRECCIONAL MULTIFUNCIONAL (CLASE 0.5S, MULTITARIFA, 35 ALARMAS, 2ED/2SD+2RELE, MAX Y MIN, THD/TDD, ARMONICO 31, MEMORIA 256 KB, V,I,FP,HZ,DEMANDA PRESENTE, PREDICTIVA Y MAX, kWh, kVARh, kW, kVA, kVAR)",
                    cantidad: 1,
                    precio_de_lista: 2864246.048,
                    precio_de_lista2: 2864246.048,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 3,
                equipo_selec: {
                    value: "24322",
                    title: "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
                    cantidad: 1,
                    precio_de_lista: 64594.944,
                    precio_de_lista2: 64594.944,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "24322",
                    title: "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
                    cantidad: 1,
                    precio_de_lista: 64594.944,
                    precio_de_lista2: 64594.944,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "59818",
                    title: "KIT DE CABLEADO DE CONTROL ANALIZADOR DE REDES 220VAC",
                    cantidad: 1,
                    precio_de_lista: 393150.7872,
                    precio_de_lista2: 393150.7872,
                    alerta_mano_obra: 5.75
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "23302",
                    title: "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S  CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
                    cantidad: 1,
                    precio_de_lista: 2720000.0,
                    precio_de_lista2: 2720000.0,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "23314",
                    title: "BORNERA DE PRUEBA TIPO LANDIS",
                    cantidad: 1,
                    precio_de_lista: 256000.0,
                    precio_de_lista2: 256000.0,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 3,
                equipo_selec: {
                    value: "24601",
                    title: "TRANSFORMADORES DE CORRIENTE 100/5 CLASE 0,5S 2.5VA CALIBRADOS",
                    cantidad: 1,
                    precio_de_lista: 152000.0,
                    precio_de_lista2: 152000.0,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "59821",
                    title: "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
                    cantidad: 1,
                    precio_de_lista: 266228.544,
                    precio_de_lista2: 266228.544,
                    alerta_mano_obra: 5.75
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "25006",
                    title: "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
                    cantidad: 1,
                    precio_de_lista: 440000.0,
                    precio_de_lista2: 440000.0,
                    alerta_mano_obra: 0.37
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "87719",
                    title: "BREAKER 3X(63)A 25/15KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "2097",
                    title: "BREAKER 3X63 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "12",
                    title: "BREAKER 3X60A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360.0,
                    precio_de_lista2: 265360.0,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "29752",
                    title: "TIPO 1+2, 3P 150 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
                    cantidad: 1,
                    precio_de_lista: 457775.616,
                    precio_de_lista2: 457775.616,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "59842",
                    title: "CABLEADO DPS",
                    cantidad: 1,
                    precio_de_lista: 27200.0,
                    precio_de_lista2: 27200.0,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V (CONSTRUCCION)",
                cantidad: 1,
                equipo_selec: {
                    value: "91029",
                    title: "T. EMPAQUE ESTIBA, GUACAL, CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 498559.05,
                    precio_de_lista2: 498559.05,
                    alerta_mano_obra: 0.0
                }
            },
        ];
    if (indexItem === 10 && parte === 2)
        data.equipos = [
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "73246",
                    title: "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44.  TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 1428525.096,
                    precio_de_lista2: 1428525.096,
                    alerta_mano_obra: 26.22
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "73339",
                    title: "GABINETE FABRICADO EN LÁMINA GALVANIZADA CALIBRE 14 Y 16, 2200X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP56. TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 2131924.91,
                    precio_de_lista2: 2131924.91,
                    alerta_mano_obra: 26.22
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "70409",
                    title: "TABLERO AUTOSOPORTADO MODULAR, FABRICADO EN LÁMINA CALIBRE 14-16 PORCELANIZADA, CHAPA EN ACERO, IP55, PINTURA ELECTROSTATICA RAL 7035. CERTIFICADO UL y RETIE. MEDIDAS 2000x800x800 mm ",
                    cantidad: 1,
                    precio_de_lista: 4281527.527,
                    precio_de_lista2: 4281527.527,
                    alerta_mano_obra: 3.59
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "70538",
                    title: "PAREDES LATERALES ATORNILLABLES, IP55. 2000X800 mm. RAL7035",
                    cantidad: 1,
                    precio_de_lista: 1047059.14,
                    precio_de_lista2: 1047059.14,
                    alerta_mano_obra: 2.88
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "72651",
                    title: "Placa de Montaje Estándar 2000 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #16. +Juego de Soportes (x6 und)",
                    cantidad: 1,
                    precio_de_lista: 174121.999,
                    precio_de_lista2: 174121.999,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 4,
                equipo_selec: {
                    value: "72671",
                    title: "Placa de Montaje Estándar 400 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #18. +Juego de Soportes (x4 und)",
                    cantidad: 4,
                    precio_de_lista: 46713.69273,
                    precio_de_lista2: 186854.7709,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "72690",
                    title: "SOPORTE EN ANGULO INTERRUPTOR PARA TABLERO GEA",
                    cantidad: 1,
                    precio_de_lista: 74872.56,
                    precio_de_lista2: 74872.56,
                    alerta_mano_obra: 1.0
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "72689",
                    title: "CUBICULO DE MEDIDA PARA TABLERO GEA",
                    cantidad: 1,
                    precio_de_lista: 185841.9272,
                    precio_de_lista2: 185841.9272,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "69884",
                    title: "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X1000 MM",
                    cantidad: 1,
                    precio_de_lista: 417298.8471,
                    precio_de_lista2: 417298.8471,
                    alerta_mano_obra: 7.25
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "1738",
                    title: "BREAKER 3X(500-1250) A 85/55 KA 240/440V UNIDAD ELECTRONICA LIG. ETU330. NO MOTORIZABLE",
                    cantidad: 1,
                    precio_de_lista: 10380960,
                    precio_de_lista2: 10380960,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "125",
                    title: "BREAKER 3X(500-1250) A 50/50 KA 240/440V MICROLOGIC 2.0 E",
                    cantidad: 1,
                    precio_de_lista: 8869146.24,
                    precio_de_lista2: 8869146.24,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "1545",
                    title: "BREAKER 3X(500-1250) A 66/66 KA 240/500V TIPO ABIERTO FIJO CON UNIDAD ELECTRONICA ETU600. LSING.",
                    cantidad: 1,
                    precio_de_lista: 13480224.8,
                    precio_de_lista2: 13480224.8,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "2163",
                    title: "KIT DE TRANSFERENCIA 500-1250A CON INTERRUPTOR DE POTENCIA 3WT",
                    cantidad: 1,
                    precio_de_lista: 23075279.2,
                    precio_de_lista2: 23075279.2,
                    alerta_mano_obra: 5.05
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 2,
                equipo_selec: {
                    value: "132",
                    title: "BREAKER 3X(500-1250) A 50/50 KA 240/440V MICROLOGIC 2.0 MOTORIZADO + MX+XF+1SDE",
                    cantidad: 2,
                    precio_de_lista: 12665417.28,
                    precio_de_lista2: 25330834.56,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "501",
                    title: "PLACA DE ENCLAVAMIENTO Y CABLES GUAYAS PARA 2 BREAKER",
                    cantidad: 1,
                    precio_de_lista: 3252028,
                    precio_de_lista2: 3252028,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "22111",
                    title: "RELE DE TRANSFERENCIA AUTOMATICA, RED-RED Y RED - GENERADOR, 50-576AC, 1-3 FASES, DISPLAY GRAFICO 144X144 MM. CONTROL DE BAJO Y SOBRE VOLTAJE, PERDIDA DE FASE, ASIMETRIA, BAJA Y ALTA FRECUENCIA. RANGO DE ALIMENTACION AUXILIAR 90-260 VAC",
                    cantidad: 1,
                    precio_de_lista: 2609555.2,
                    precio_de_lista2: 2609555.2,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "59801",
                    title: "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MOTORIZADOS Y ATL 220V",
                    cantidad: 1,
                    precio_de_lista: 603964.2835,
                    precio_de_lista2: 603964.2835,
                    alerta_mano_obra: 11.68
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "22142",
                    title: "CONTROLADOR CONMUTADOR DE TRANSFERENCIAS AUTOMATICAS POWER",
                    cantidad: 1,
                    precio_de_lista: 1184000,
                    precio_de_lista2: 1184000,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "50853",
                    title: "FUENTE CONMUTADA 5A ,ENTRADA 90/264 Vac,SALIDA 24 Vdc. MONTAJE EN RIEL",
                    cantidad: 1,
                    precio_de_lista: 357499.296,
                    precio_de_lista2: 357499.296,
                    alerta_mano_obra: 0.35
                }
            },
            {
                nombre_item: "GABINETE DE BAJA TENSION 220V   (INDUSTRIA)",
                cantidad: 1,
                equipo_selec: {
                    value: "59802",
                    title: "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MOTORIZADOS Y COMAP 220V",
                    cantidad: 1,
                    precio_de_lista: 705994.0051,
                    precio_de_lista2: 705994.0051,
                    alerta_mano_obra: 11.68
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 4,
                equipo_selec: {
                    value: "74",
                    title: "BREAKER 3X(70-100) A 85/35 KA 240/440V",
                    cantidad: 4,
                    precio_de_lista: 774231.36,
                    precio_de_lista2: 3096925.44,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 2,
                equipo_selec: {
                    value: "77",
                    title: "BREAKER 3X(140-200) A 85/35 KA 240/440V",
                    cantidad: 2,
                    precio_de_lista: 1730117.76,
                    precio_de_lista2: 3460235.52,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 2,
                equipo_selec: {
                    value: "115",
                    title: "BREAKER 3X(160-400) A 85/42 KA 240/440V MICROLOGIC 2.3",
                    cantidad: 2,
                    precio_de_lista: 2792213.76,
                    precio_de_lista2: 5584427.52,
                    alerta_mano_obra: 0.15
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "123",
                    title: "BREAKER 3X(320-800) A 50/50 KA 240/440V MICROLOGIC 2.0 E",
                    cantidad: 1,
                    precio_de_lista: 6235400,
                    precio_de_lista2: 6235400,
                    alerta_mano_obra: 1.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "1499",
                    title: "BREAKER 3X(28-40) A 55/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 458172,
                    precio_de_lista2: 458172,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "1502",
                    title: "BREAKER 3X(56-80) A 55/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 503028,
                    precio_de_lista2: 503028,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "1505",
                    title: "BREAKER 3X(112-160) A 55/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 1028484,
                    precio_de_lista2: 1028484,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "1511",
                    title: "BREAKER 3X(22-32) A 85/36 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 503028,
                    precio_de_lista2: 503028,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "3574",
                    title: "BREAKER 3X(28-40) A 25/15 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 302592,
                    precio_de_lista2: 302592,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "03580",
                    title: "BREAKER 3X(112-160) A 25/15 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 773376,
                    precio_de_lista2: 773376,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "RESERVA NO EQUIPADA NI CABLEADA HASTA ***AMP",
                cantidad: 1,
                equipo_selec: {
                    value: "0",
                    title: "RESERVA NO EQUIPADA NI CABLEADA HASTA ***AMP",
                    cantidad: 1,
                    precio_de_lista: 0,
                    precio_de_lista2: 0,
                    alerta_mano_obra: 0
                }
            },
            {
                nombre_item: "MEDIDOR MULTIFUNCIONAL",
                cantidad: 1,
                equipo_selec: {
                    value: "23400",
                    title: "MEDIDOR MULTIFUNCIONAL, PANTALLA LCD GRAFICA COLORES. MEDIDAS DE VOLTAJE, CORRIENTE, POTENCIAS (ACTIVA, REACTIVA Y APARENTE), FACTOR DE POTENCIA, FRECUENCIA, CONTENIDO ARMONICO TOTAL EN VOLTAJE Y CORRIENTE. ENERGIA ACTIVA Y REACTIVA. CURVAS DE DATOS EN TIEMPO REAL. DIMENSIONES 96X96MM. SALIDA RELE 2 ALARMAS. COMUNICACIONES MODBUS-RTU RS485. EQUIPADO CON PUERTO USB Y SD PARA MEMORIA DE DATOS. ENTRADAS DE 1-5AMP, 480VAC. AUX 100-240 VAC/DC. INCLUYE MEMORIA USB Y SD DE 32GB.",
                    cantidad: 1,
                    precio_de_lista: 1728307.712,
                    precio_de_lista2: 1728307.712,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "MEDIDOR DE ENERGIA BIDIRECCIONAL",
                cantidad: 1,
                equipo_selec: {
                    value: "23486",
                    title: "MEDIDOR DE ENERGIA BIDIRECCIONAL MULTIFUNCIONAL, MULTITARIFA (CLASE 0.2S, PUERTO RS485 MODBUS RTU, 52 ALARMAS, 4ED/2SD, MAX Y MIN, THD/TDD, ARMONICO 63, ALMACENAMIENTO HISTORICOS DE KWH-KVAH Y EVENTOS. MEMORIA 1,1 MB. V ,I ,FP ,HZ ,DEMANDA PRESENTE,PREDICTIVA Y MAX, kWh, kVARh, kW, kVA, kVAR). 2 PUERTOS  ETHERNET (DAISY CHAIN)",
                    cantidad: 1,
                    precio_de_lista: 5569487.328,
                    precio_de_lista2: 5569487.328,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "ANALIZADOR DE REDES",
                cantidad: 1,
                equipo_selec: {
                    value: "23503",
                    title: "ANALIZADOR DE REDES 60 VARIABLES, CON COMUNICACIÓN ETHERNETH. THD. DISPLAY GRAFICO LCD. MEMORIA DE EVENTOS 320MB. ARMONICO 63. CONTROL HASTA 690 VAC, 4DI, 2DO",
                    cantidad: 1,
                    precio_de_lista: 3759929.6,
                    precio_de_lista2: 3759929.6,
                    alerta_mano_obra: 1.54
                }
            },
            {
                nombre_item: "TRANSFORMADOR DE CORRIENTE",
                cantidad: 3,
                equipo_selec: {
                    value: "24328",
                    title: "TRANSFORMADOR DE CORRIENTE DE 1000/5A CL 0,5 BURDEN  10 VA.",
                    cantidad: 3,
                    precio_de_lista: 68836.864,
                    precio_de_lista2: 206510.592,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "TRANSFORMADOR DE CORRIENTE",
                cantidad: 1,
                equipo_selec: {
                    value: "24328",
                    title: "TRANSFORMADOR DE CORRIENTE DE 1000/5A CL 0,5 BURDEN  10 VA.",
                    cantidad: 1,
                    precio_de_lista: 68836.864,
                    precio_de_lista2: 68836.864,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "KIT DE CABLEADO DE CONTROL ANALIZADOR DE REDES 220VAC",
                cantidad: 1,
                equipo_selec: {
                    value: "59818",
                    title: "KIT DE CABLEADO DE CONTROL ANALIZADOR DE REDES 220VAC",
                    cantidad: 1,
                    precio_de_lista: 393150.7872,
                    precio_de_lista2: 393150.7872,
                    alerta_mano_obra: 5.75
                }
            },
            {
                nombre_item: "MEDIDOR ELECTRONICO MULTIFUNCIONAL",
                cantidad: 1,
                equipo_selec: {
                    value: "23302",
                    title: "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S  CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
                    cantidad: 1,
                    precio_de_lista: 2720000,
                    precio_de_lista2: 2720000,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "BORNERA DE PRUEBA TIPO LANDIS",
                cantidad: 1,
                equipo_selec: {
                    value: "23314",
                    title: "BORNERA DE PRUEBA TIPO LANDIS",
                    cantidad: 1,
                    precio_de_lista: 256000,
                    precio_de_lista2: 256000,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "TRANSFORMADORES DE CORRIENTE",
                cantidad: 3,
                equipo_selec: {
                    value: "24601",
                    title: "TRANSFORMADORES DE CORRIENTE 100/5 CLASE 0,5S 2.5VA CALIBRADOS",
                    cantidad: 3,
                    precio_de_lista: 152000,
                    precio_de_lista2: 456000,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
                cantidad: 1,
                equipo_selec: {
                    value: "59821",
                    title: "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
                    cantidad: 1,
                    precio_de_lista: 266228.544,
                    precio_de_lista2: 266228.544,
                    alerta_mano_obra: 5.75
                }
            },
            {
                nombre_item: "TRANSFORMADOR DE CONTROL",
                cantidad: 1,
                equipo_selec: {
                    value: "25006",
                    title: "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
                    cantidad: 1,
                    precio_de_lista: 440000,
                    precio_de_lista2: 440000,
                    alerta_mano_obra: 0.37
                }
            },
            {
                nombre_item: "CABLEADO Y ACCESORIOS TRANSFORMADOR",
                cantidad: 1,
                equipo_selec: {
                    value: "93000",
                    title: "CABLEADO Y ACCESORIOS TRANSFORMADOR",
                    cantidad: 1,
                    precio_de_lista: 93000,
                    precio_de_lista2: 93000,
                    alerta_mano_obra: 1.0
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "72",
                    title: "BREAKER 3X(44-63) A 85/35 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 727902.08,
                    precio_de_lista2: 727902.08,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "BREAKER",
                cantidad: 1,
                equipo_selec: {
                    value: "1497",
                    title: "BREAKER 3X(18-25) A 55/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 458172,
                    precio_de_lista2: 458172,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "DPS",
                cantidad: 1,
                equipo_selec: {
                    value: "29756",
                    title: "TIPO 1+2, 3P 320 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
                    cantidad: 1,
                    precio_de_lista: 457775.616,
                    precio_de_lista2: 457775.616,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "DPS",
                cantidad: 1,
                equipo_selec: {
                    value: "29306",
                    title: "DPS Tipo I+II 12.5 KA 10/350, 65 KA 8/20 x polo 3P 277/480 VAC MODULAR. MODO COMUN",
                    cantidad: 1,
                    precio_de_lista: 3347206.4,
                    precio_de_lista2: 3347206.4,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "CABLEADO DPS",
                cantidad: 1,
                equipo_selec: {
                    value: "59842",
                    title: "CABLEADO DPS",
                    cantidad: 1,
                    precio_de_lista: 27200,
                    precio_de_lista2: 27200,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                cantidad: 1,
                equipo_selec: {
                    value: "91028",
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 196047.1,
                    precio_de_lista2: 196047.1,
                    alerta_mano_obra: 0.0
                }
            }
        ];
    if (indexItem === 11 && parte === 2)
        data.equipos = [
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "66030",
                    title: "GABINETE  EN LÁMINA COLD ROLLED CALIBRE 18 1200X800X300 mm. PINTURA ELECTROSTATICA RAL7035. IP44.",
                    cantidad: 1,
                    precio_de_lista: 564140.6808,
                    precio_de_lista2: 564140.6808,
                    alerta_mano_obra: 8.28
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "66067",
                    title: "GABINETE  EN LÁMINA GALVANIZADA CALIBRE 18 1200X800X300 mm. PINTURA ELECTROSTATICA RAL7035. IP65. CON TECHO.",
                    cantidad: 1,
                    precio_de_lista: 743912.397,
                    precio_de_lista2: 743912.397,
                    alerta_mano_obra: 8.28
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "69911",
                    title: "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 1200X800 MM",
                    cantidad: 1,
                    precio_de_lista: 217356.2979,
                    precio_de_lista2: 217356.2979,
                    alerta_mano_obra: 7.25
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 0.2,
                equipo_selec: {
                    value: "61546",
                    title: "FRENTE MUERTO EN POLICARBONATO PARA EVITAR ACCESO A PARTES ENERGIZADAS",
                    cantidad: 0.2,
                    precio_de_lista: 566328,
                    precio_de_lista2: 113265.6,
                    alerta_mano_obra: 7.25
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87732",
                    title: "BREAKER 3X(400)A 60/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 789041.152,
                    precio_de_lista2: 789041.152,
                    alerta_mano_obra: 0.15
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2127",
                    title: "BREAKER 3X400 A 50/36KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 952949.0592,
                    precio_de_lista2: 952949.0592,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "24",
                    title: "BREAKER 3X400A 85/20 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 1196652.576,
                    precio_de_lista2: 1196652.576,
                    alerta_mano_obra: 0.15
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "87715",
                    title: "BREAKER 3X(25)A 25/15KA 220/440VAC",
                    cantidad: 5,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 759452.16,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "87725",
                    title: "BREAKER 3X(160)A 65/30KA 220/440VAC",
                    cantidad: 5,
                    precio_de_lista: 232263.68,
                    precio_de_lista2: 1161318.4,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "87729",
                    title: "BREAKER 3X(250)A 65/30KA 220/440VAC",
                    cantidad: 4,
                    precio_de_lista: 232263.68,
                    precio_de_lista2: 929054.72,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "02095",
                    title: "BREAKER 3X40 A 25/18KA 240/415 V",
                    cantidad: 5,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 943513.92,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "02096",
                    title: "BREAKER 3X50 A 25/18KA 240/415 V",
                    cantidad: 5,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 943513.92,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "02097",
                    title: "BREAKER 3X63 A 25/18KA 240/415 V",
                    cantidad: 4,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 754811.136,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "02098",
                    title: "BREAKER 3X80 A 25/18KA 240/415 V",
                    cantidad: 5,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 943513.92,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "9",
                    title: "BREAKER 3X30A 25/12,5 KA 240/440V",
                    cantidad: 5,
                    precio_de_lista: 265360,
                    precio_de_lista2: 1326800,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "10",
                    title: "BREAKER 3X40A 25/12,5 KA 240/440V",
                    cantidad: 5,
                    precio_de_lista: 265360,
                    precio_de_lista2: 1326800,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "11",
                    title: "BREAKER 3X50A 25/12,5 KA 240/440V",
                    cantidad: 4,
                    precio_de_lista: 265360,
                    precio_de_lista2: 1061440,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "13",
                    title: "BREAKER 3X80A 25/12,5 KA 240/440V",
                    cantidad: 5,
                    precio_de_lista: 265360,
                    precio_de_lista2: 1326800,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 3,
                equipo_selec: {
                    value: "14",
                    title: "BREAKER 3X100A 25/12,5 KA 240/440V",
                    cantidad: 3,
                    precio_de_lista: 265360,
                    precio_de_lista2: 796080,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "4726",
                    title: "MINIBREAKER 1X16A 12/10KA 127/240VAC",
                    cantidad: 4,
                    precio_de_lista: 12699.136,
                    precio_de_lista2: 50796.544,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "4738",
                    title: "MINIBREAKER 2X16A 10KA 240VAC",
                    cantidad: 5,
                    precio_de_lista: 29558.784,
                    precio_de_lista2: 147793.92,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 3,
                equipo_selec: {
                    value: "4751",
                    title: "MINIBREAKER 3X20A 10KA 240VAC",
                    cantidad: 3,
                    precio_de_lista: 41746.432,
                    precio_de_lista2: 125239.296,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "5126",
                    title: "MINIBREAKER 1X16A  10 KA 120VAC",
                    cantidad: 4,
                    precio_de_lista: 19420.8,
                    precio_de_lista2: 77683.2,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "5138",
                    title: "MINIBREAKER 2X16A 10 KA 220V",
                    cantidad: 5,
                    precio_de_lista: 41350.4,
                    precio_de_lista2: 206752,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 3,
                equipo_selec: {
                    value: "5151",
                    title: "MINIBREAKER 3X20A 10 KA 220V",
                    cantidad: 3,
                    precio_de_lista: 74816,
                    precio_de_lista2: 224448,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 4,
                equipo_selec: {
                    value: "6059",
                    title: "MINIBREAKER 1X16A, 10KA, 230/400VAC",
                    cantidad: 4,
                    precio_de_lista: 24492.8,
                    precio_de_lista2: 97971.2,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 5,
                equipo_selec: {
                    value: "6076",
                    title: "MINIBREAKER 2X16A, 10KA, 230/400VAC",
                    cantidad: 5,
                    precio_de_lista: 48985.6,
                    precio_de_lista2: 244928,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 3,
                equipo_selec: {
                    value: "6094",
                    title: "MINIBREAKER 3X20A, 10KA, 230/400VAC",
                    cantidad: 3,
                    precio_de_lista: 82663.2,
                    precio_de_lista2: 247989.6,
                    alerta_mano_obra: 0.45
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87718",
                    title: "BREAKER 3X(50)A 25/15KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "02097",
                    title: "BREAKER 3X63 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "12",
                    title: "BREAKER 3X60A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360,
                    precio_de_lista2: 265360,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "29765",
                    title: "TIPO 2, 4P 150 VAC. 40kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
                    cantidad: 1,
                    precio_de_lista: 384784.384,
                    precio_de_lista2: 384784.384,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "59842",
                    title: "CABLEADO DPS",
                    cantidad: 1,
                    precio_de_lista: 27200,
                    precio_de_lista2: 27200,
                    alerta_mano_obra: 1.73
                }
            },
            {
                nombre_item: "GABINETE EN BAJA TENSION 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "91027",
                    title: "T. EMPAQUE CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 117800,
                    precio_de_lista2: 117800,
                    alerta_mano_obra: 0.0
                }
            }
        ];
    if (indexItem === 12 && parte === 2)
        data.equipos = [
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "73246",
                    title: "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
                    cantidad: 1,
                    precio_de_lista: 1428525.096,
                    precio_de_lista2: 1428525.096,
                    alerta_mano_obra: 26.22
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "72676",
                    title: "Placa de Montaje Estándar 400 x 800 mm, fabricada en LÁMINA Galvanizada Calibre #18. +Juego de Soportes (x4 und)",
                    cantidad: 1,
                    precio_de_lista: 38475.89375,
                    precio_de_lista2: 38475.89375,
                    alerta_mano_obra: 2.3
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "69878",
                    title: "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X800 MM",
                    cantidad: 1,
                    precio_de_lista: 356198.696,
                    precio_de_lista2: 356198.696,
                    alerta_mano_obra: 7.25
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87729",
                    title: "BREAKER 3X(250)A 65/30KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 232263.68,
                    precio_de_lista2: 232263.68,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2124",
                    title: "BREAKER 3X250 A 50/36KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 728864.5032,
                    precio_de_lista2: 728864.5032,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "21",
                    title: "BREAKER 3X250A 50/25 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 712712.32,
                    precio_de_lista2: 712712.32,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22001",
                    title: "RELE CORRECTOR FACTOR DE POTENCIA 5 PASOS 100-600 VAC",
                    cantidad: 1,
                    precio_de_lista: 1336819.2,
                    precio_de_lista2: 1336819.2,
                    alerta_mano_obra: 1.66
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22007",
                    title: "MODULO EXPANSION 2 PASOS DCRL, DCRG",
                    cantidad: 1,
                    precio_de_lista: 322300.8,
                    precio_de_lista2: 322300.8,
                    alerta_mano_obra: null
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22008",
                    title: "MODULO EXPANSION 3 PASOS DCRL, DCRG",
                    cantidad: 1,
                    precio_de_lista: 775843.2,
                    precio_de_lista2: 775843.2,
                    alerta_mano_obra: null
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22070",
                    title: "Controlador de FP 6 pasos POWER SAVE",
                    cantidad: 1,
                    precio_de_lista: 947128.864,
                    precio_de_lista2: 947128.864,
                    alerta_mano_obra: 1.66
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22603",
                    title: "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
                    cantidad: 1,
                    precio_de_lista: 64934.4,
                    precio_de_lista2: 64934.4,
                    alerta_mano_obra: 0.23
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "59823",
                    title: "KIT DE CABLEADO DE CONTROL RELÉ CORRECTOR FP 2-5 PASOS 220V",
                    cantidad: 1,
                    precio_de_lista: 254013.9936,
                    precio_de_lista2: 254013.9936,
                    alerta_mano_obra: 1.66
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "24322",
                    title: "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
                    cantidad: 1,
                    precio_de_lista: 64594.944,
                    precio_de_lista2: 64594.944,
                    alerta_mano_obra: 0.29
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87718",
                    title: "BREAKER 3X(50)A 25/15KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2096",
                    title: "BREAKER 3X50 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "11",
                    title: "BREAKER 3X50A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360,
                    precio_de_lista2: 265360,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22957",
                    title: "CAPACITOR 10/11/13 KVAR 208/220/240 VAC",
                    cantidad: 1,
                    precio_de_lista: 406400,
                    precio_de_lista2: 406400,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "23085",
                    title: "Condensador cilíndrico 10,0 KVAR 220V",
                    cantidad: 1,
                    precio_de_lista: 315315.84,
                    precio_de_lista2: 315315.84,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87715",
                    title: "BREAKER 3X(25)A 25/15KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "8",
                    title: "BREAKER 3X20A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360,
                    precio_de_lista2: 265360,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2092",
                    title: "BREAKER 3X20 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 201282.9696,
                    precio_de_lista2: 201282.9696,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14102",
                    title: "CONTACTOR  25AMP AC1, 11AMP AC3 240V, 9AMP AC3 440V, 220VAC, 1NA+1NC",
                    cantidad: 1,
                    precio_de_lista: 84110.4,
                    precio_de_lista2: 84110.4,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14151",
                    title: "RESISTENCIA DE PRECARGA 5 KVAR 240V / 9.7 KVAR 440V / 14 KVAR 550V)",
                    cantidad: 1,
                    precio_de_lista: 90161.28,
                    precio_de_lista2: 90161.28,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "12703",
                    title: "CONTACTOR CONDENSADOR 9,6/16,7/21 KVAR 220/440/480V (110V)",
                    cantidad: 1,
                    precio_de_lista: 343611.2,
                    precio_de_lista2: 343611.2,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "11108",
                    title: "CONTACTOR 25 KVAR 440 VAC / 15 KVAR 220VAC BOBINA A 220V",
                    cantidad: 1,
                    precio_de_lista: 618640.96,
                    precio_de_lista2: 618640.96,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "23083",
                    title: "Condensador cilíndrico 5,0 KVAR 220V",
                    cantidad: 1,
                    precio_de_lista: 185098.88,
                    precio_de_lista2: 185098.88,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22956",
                    title: "CAPACITOR 4/5/7 KVAR 208/220/240 VAC",
                    cantidad: 1,
                    precio_de_lista: 278080,
                    precio_de_lista2: 278080,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87717",
                    title: "BREAKER 3X(40)A 25/15KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "10",
                    title: "BREAKER 3X40A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360,
                    precio_de_lista2: 265360,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2095",
                    title: "BREAKER 3X40 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14108",
                    title: "CONTACTOR  40AMP AC1, 22AMP AC3, 220VAC, 1NA+1NC",
                    cantidad: 1,
                    precio_de_lista: 149054.4,
                    precio_de_lista2: 149054.4,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14154",
                    title: "RESISTENCIA DE PRECARGA 10 KVAR 240V / 18 KVAR 440V / 26 KVAR 550V)",
                    cantidad: 1,
                    precio_de_lista: 90161.28,
                    precio_de_lista2: 90161.28,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "12706",
                    title: "CONTACTOR CONDENSADOR 15/25/30 KVAR 220/440/480V (220V)",
                    cantidad: 1,
                    precio_de_lista: 449129.6,
                    precio_de_lista2: 449129.6,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "11106",
                    title: "CONTACTOR 20 KVAR 440 VAC / 10 KVAR 220VAC BOBINA A 220V",
                    cantidad: 1,
                    precio_de_lista: 482360,
                    precio_de_lista2: 482360,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "23085",
                    title: "Condensador cilíndrico 10,0 KVAR 220V",
                    cantidad: 1,
                    precio_de_lista: 315315.84,
                    precio_de_lista2: 315315.84,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "22957",
                    title: "CAPACITOR 10/11/13 KVAR 208/220/240 VAC",
                    cantidad: 1,
                    precio_de_lista: 406400,
                    precio_de_lista2: 406400,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "87721",
                    title: "BREAKER 3X(80)A 30/20KA 220/440VAC",
                    cantidad: 1,
                    precio_de_lista: 151890.432,
                    precio_de_lista2: 151890.432,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "13",
                    title: "BREAKER 3X80A 25/12,5 KA 240/440V",
                    cantidad: 1,
                    precio_de_lista: 265360,
                    precio_de_lista2: 265360,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "2098",
                    title: "BREAKER 3X80 A 25/18KA 240/415 V",
                    cantidad: 1,
                    precio_de_lista: 188702.784,
                    precio_de_lista2: 188702.784,
                    alerta_mano_obra: 0.1
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14112",
                    title: "CONTACTOR  60AMP AC1, 40AMP AC3, 220VAC, 2NA+2NC",
                    cantidad: 1,
                    precio_de_lista: 277295.04,
                    precio_de_lista2: 277295.04,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "14156",
                    title: "RESISTENCIA DE PRECARGA 20KVAR 240V / 33.3 KVAR 440V / 48KVAR 550V)",
                    cantidad: 1,
                    precio_de_lista: 90161.28,
                    precio_de_lista2: 90161.28,
                    alerta_mano_obra: 0.17
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "12710",
                    title: "CONTACTOR CONDENSADOR 30/50/60 KVAR 220/440/480V (220V)",
                    cantidad: 1,
                    precio_de_lista: 925315.2,
                    precio_de_lista2: 925315.2,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "11110",
                    title: "CONTACTOR 33 KVAR 440 VAC / 20 KVAR 220VAC BOBINA A 220V",
                    cantidad: 1,
                    precio_de_lista: 796323.536,
                    precio_de_lista2: 796323.536,
                    alerta_mano_obra: 0.41
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "23088",
                    title: "Condensador cilíndrico 20,0 KVAR 220V",
                    cantidad: 1,
                    precio_de_lista: 456975.04,
                    precio_de_lista2: 456975.04,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 2,
                equipo_selec: {
                    value: "22957",
                    title: "CAPACITOR 10/11/13 KVAR 208/220/240 VAC",
                    cantidad: 2,
                    precio_de_lista: 406400,
                    precio_de_lista2: 812800,
                    alerta_mano_obra: 1.39
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "30182",
                    title: "MOTOR PARA REJILLA DE VENTILACION DE 4 y 6\". 120X120X38.4 mm. 200-240 VAC. 162M3/Hr",
                    cantidad: 1,
                    precio_de_lista: 82930.1088,
                    precio_de_lista2: 82930.1088,
                    alerta_mano_obra: 1.2
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 2,
                equipo_selec: {
                    value: "30110",
                    title: "REJILLA CON FILTRO 4\" IP54",
                    cantidad: 2,
                    precio_de_lista: 49693.2128,
                    precio_de_lista2: 99386.4256,
                    alerta_mano_obra: 0.0
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "30198",
                    title: "MOTOR PARA REJILLA DE VENTILACION DE 8\". 172x150x50 mm. 200-240 VAC. 336M3/Hr",
                    cantidad: 1,
                    precio_de_lista: 184505.3056,
                    precio_de_lista2: 184505.3056,
                    alerta_mano_obra: 1.2
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 2,
                equipo_selec: {
                    value: "30116",
                    title: "REJILLA CON FILTRO 8\" IP54",
                    cantidad: 2,
                    precio_de_lista: 87145.52,
                    precio_de_lista2: 174291.04,
                    alerta_mano_obra: 0.0
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "30125",
                    title: "Ventilador 45-50 m3/h  6\"   150X150 mm    230 V",
                    cantidad: 1,
                    precio_de_lista: 345116.8,
                    precio_de_lista2: 345116.8,
                    alerta_mano_obra: 1.2
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "30126",
                    title: "Filtro de salida  6\"  150X150 mm",
                    cantidad: 1,
                    precio_de_lista: 71225.6,
                    precio_de_lista2: 71225.6,
                    alerta_mano_obra: 1.2
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "59839",
                    title: "KIT DE CABLEADO DE CONTROL EXTRACTORES/VENTILADORES",
                    cantidad: 1,
                    precio_de_lista: 139265.7197,
                    precio_de_lista2: 139265.7197,
                    alerta_mano_obra: 1.2
                }
            },
            {
                nombre_item: "GABINETE BANCO DE CONDENSADORES 75 KVAR 220V",
                cantidad: 1,
                equipo_selec: {
                    value: "91028",
                    title: "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                    cantidad: 1,
                    precio_de_lista: 196047.1,
                    precio_de_lista2: 196047.1,
                    alerta_mano_obra: 0.0
                }
            }
        ];
    if (indexItem === 13 && parte === 2)
        data.equipos = [
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "73246",
                        "title": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
                        "cantidad": 1,
                        "precio_de_lista": 1428525.096,
                        "precio_de_lista2": 1428525.096,
                        "alerta_mano_obra": 26.22
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 3,
                    "equipo_selec": {
                        "value": "72676",
                        "title": "Placa de Montaje Estándar 400 x 800 mm, fabricada en LÁMINA Galvanizada Calibre #18. +Juego de Soportes (x4 und)",
                        "cantidad": 3,
                        "precio_de_lista": 38475.89375,
                        "precio_de_lista2": 115427.6812,
                        "alerta_mano_obra": 2.3
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "69878",
                        "title": "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X800 MM",
                        "cantidad": 1,
                        "precio_de_lista": 356198.696,
                        "precio_de_lista2": 356198.696,
                        "alerta_mano_obra": 7.25
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "15",
                        "title": "BREAKER 3X125A 50/25 KA 240/440V",
                        "cantidad": 1,
                        "precio_de_lista": 590095.168,
                        "precio_de_lista2": 590095.168,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "2109",
                        "title": "BREAKER 3X125 A 30/25KA 240/415 V",
                        "cantidad": 1,
                        "precio_de_lista": 352638.3276,
                        "precio_de_lista2": 352638.3276,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22001",
                        "title": "RELE CORRECTOR FACTOR DE POTENCIA 5 PASOS 100-600 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 1336819.2,
                        "precio_de_lista2": 1336819.2,
                        "alerta_mano_obra": 1.66
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22007",
                        "title": "MODULO EXPANSION 2 PASOS DCRL, DCRG",
                        "cantidad": 1,
                        "precio_de_lista": 322300.8,
                        "precio_de_lista2": 322300.8,
                        "alerta_mano_obra": null
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22008",
                        "title": "MODULO EXPANSION 3 PASOS DCRL, DCRG",
                        "cantidad": 1,
                        "precio_de_lista": 775843.2,
                        "precio_de_lista2": 775843.2,
                        "alerta_mano_obra": null
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22603",
                        "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 64934.4,
                        "precio_de_lista2": 64934.4,
                        "alerta_mano_obra": 0.23
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "59827",
                        "title": "KIT DE CABLEADO DE CONTROL RELÉ CORRECTOR FP 6-8 PASOS 440V",
                        "cantidad": 1,
                        "precio_de_lista": 804070.56,
                        "precio_de_lista2": 804070.56,
                        "alerta_mano_obra": 1.66
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "24322",
                        "title": "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
                        "cantidad": 1,
                        "precio_de_lista": 64594.944,
                        "precio_de_lista2": 64594.944,
                        "alerta_mano_obra": 0.29
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "9",
                        "title": "BREAKER 3X30A 25/12,5 KA 240/440V",
                        "cantidad": 1,
                        "precio_de_lista": 265360,
                        "precio_de_lista2": 265360,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "2094",
                        "title": "BREAKER 3X32 A 25/18KA 240/415 V",
                        "cantidad": 1,
                        "precio_de_lista": 188702.784,
                        "precio_de_lista2": 188702.784,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22969",
                        "title": "CAPACITOR 19/20 KVAR 460/480 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 318080,
                        "precio_de_lista2": 318080,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22939",
                        "title": "CAPACITOR 20 KVAR 440 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 365683.2,
                        "precio_de_lista2": 365683.2,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "23100",
                        "title": "Condensador cilíndrico 20,0 KVAR 440V",
                        "cantidad": 1,
                        "precio_de_lista": 320614.72,
                        "precio_de_lista2": 320614.72,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "9",
                        "title": "BREAKER 3X30A 25/12,5 KA 240/440V",
                        "cantidad": 1,
                        "precio_de_lista": 265360,
                        "precio_de_lista2": 265360,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "14106",
                        "title": "CONTACTOR  40AMP AC1, 18AMP AC3, 220VAC, 1NA+1NC",
                        "cantidad": 1,
                        "precio_de_lista": 119592,
                        "precio_de_lista2": 119592,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "14153",
                        "title": "RESISTENCIA DE PRECARGA 8.5 KVAR 240V / 16.7 KVAR 440V / 24 KVAR 550V)",
                        "cantidad": 1,
                        "precio_de_lista": 90161.28,
                        "precio_de_lista2": 90161.28,
                        "alerta_mano_obra": 0.17
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "12702",
                        "title": "CONTACTOR CONDENSADOR 7,5/12,5/15 KVAR 220/440/480V (220V)",
                        "cantidad": 1,
                        "precio_de_lista": 303027.2,
                        "precio_de_lista2": 303027.2,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "11104",
                        "title": "CONTACTOR 17 KVAR 440 VAC / 9 KVAR 220VAC BOBINA A 220V",
                        "cantidad": 1,
                        "precio_de_lista": 406472,
                        "precio_de_lista2": 406472,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22938",
                        "title": "CAPACITOR 15 KVAR 440 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 334924.8,
                        "precio_de_lista2": 334924.8,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "23100",
                        "title": "Condensador cilíndrico 20,0 KVAR 440V",
                        "cantidad": 1,
                        "precio_de_lista": 320614.72,
                        "precio_de_lista2": 320614.72,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "11",
                        "title": "BREAKER 3X50A 25/12,5 KA 240/440V",
                        "cantidad": 1,
                        "precio_de_lista": 265360,
                        "precio_de_lista2": 265360,
                        "alerta_mano_obra": 0.1
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "14112",
                        "title": "CONTACTOR  60AMP AC1, 40AMP AC3, 220VAC, 2NA+2NC",
                        "cantidad": 1,
                        "precio_de_lista": 277295.04,
                        "precio_de_lista2": 277295.04,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "14156",
                        "title": "RESISTENCIA DE PRECARGA 20KVAR 240V / 33.3 KVAR 440V / 48KVAR 550V)",
                        "cantidad": 1,
                        "precio_de_lista": 90161.28,
                        "precio_de_lista2": 90161.28,
                        "alerta_mano_obra": 0.17
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "12703",
                        "title": "CONTACTOR CONDENSADOR 9,6/16,7/21 KVAR 220/440/480V (110V)",
                        "cantidad": 1,
                        "precio_de_lista": 343611.2,
                        "precio_de_lista2": 343611.2,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "12012",
                        "title": "CONTACTOR PARA CONDENSADOR DE 17,5/30 KVAR 230/440VAC (440VAC), 1NA",
                        "cantidad": 1,
                        "precio_de_lista": 537292.8,
                        "precio_de_lista2": 537292.8,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "11110",
                        "title": "CONTACTOR 33 KVAR 440 VAC / 20 KVAR 220VAC BOBINA A 220V",
                        "cantidad": 1,
                        "precio_de_lista": 796323.536,
                        "precio_de_lista2": 796323.536,
                        "alerta_mano_obra": 0.41
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "22946",
                        "title": "CAPACITOR 30 KVAR 480 VAC",
                        "cantidad": 1,
                        "precio_de_lista": 471628.8,
                        "precio_de_lista2": 471628.8,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "23100",
                        "title": "Condensador cilíndrico 20,0 KVAR 440V",
                        "cantidad": 1,
                        "precio_de_lista": 320614.72,
                        "precio_de_lista2": 320614.72,
                        "alerta_mano_obra": 1.39
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30063",
                        "title": "Ventilador 55 m3/h  6\"  148.5 x   148.5 mm   230 V",
                        "cantidad": 1,
                        "precio_de_lista": 513799.8374,
                        "precio_de_lista2": 513799.8374,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30065",
                        "title": "Filtro de salida   6\"    148.5 x   148.5 mm",
                        "cantidad": 1,
                        "precio_de_lista": 137106.5597,
                        "precio_de_lista2": 137106.5597,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30125",
                        "title": "Ventilador 45-50 m3/h  6\"  150X150 mm   230 V",
                        "cantidad": 1,
                        "precio_de_lista": 345116.8,
                        "precio_de_lista2": 345116.8,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30126",
                        "title": "Filtro de salida  6\"  150X150 mm",
                        "cantidad": 1,
                        "precio_de_lista": 71225.6,
                        "precio_de_lista2": 71225.6,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30112",
                        "title": "EXTRACTOR 6\" CAUDAL 170-204 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
                        "cantidad": 1,
                        "precio_de_lista": 154997.4272,
                        "precio_de_lista2": 154997.4272,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30113",
                        "title": "REJILLA CON FILTRO 6\" IP54",
                        "cantidad": 1,
                        "precio_de_lista": 65582.0704,
                        "precio_de_lista2": 65582.0704,
                        "alerta_mano_obra": 0.0
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30115",
                        "title": "EXTRACTOR 8\" CAUDAL 305-332 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
                        "cantidad": 1,
                        "precio_de_lista": 297510.752,
                        "precio_de_lista2": 297510.752,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "30116",
                        "title": "REJILLA CON FILTRO 8\" IP54",
                        "cantidad": 1,
                        "precio_de_lista": 87145.52,
                        "precio_de_lista2": 87145.52,
                        "alerta_mano_obra": 0.0
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "59839",
                        "title": "KIT DE CABLEADO DE CONTROL EXTRACTORES/VENTILADORES",
                        "cantidad": 1,
                        "precio_de_lista": 139265.7197,
                        "precio_de_lista2": 139265.7197,
                        "alerta_mano_obra": 1.2
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "5136",
                        "title": "MINIBREAKER 2X6A 10 KA 220V",
                        "cantidad": 1,
                        "precio_de_lista": 41350.4,
                        "precio_de_lista2": 41350.4,
                        "alerta_mano_obra": 0.45
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 2,
                    "equipo_selec": {
                        "value": "6074",
                        "title": "MINIBREAKER 2X6A, 10KA, 230/400VAC",
                        "cantidad": 2,
                        "precio_de_lista": 48985.6,
                        "precio_de_lista2": 97971.2,
                        "alerta_mano_obra": 0.45
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "25006",
                        "title": "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
                        "cantidad": 1,
                        "precio_de_lista": 440000,
                        "precio_de_lista2": 440000,
                        "alerta_mano_obra": 0.37
                    }
                },
                {
                    "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
                    "cantidad": 1,
                    "equipo_selec": {
                        "value": "91028",
                        "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
                        "cantidad": 1,
                        "precio_de_lista": 196047.1,
                        "precio_de_lista2": 196047.1,
                        "alerta_mano_obra": 0.0
                    }
                }
            ]
    if (indexItem === 14 && parte === 2)
        data.equipos = [
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69023",
            "title": "GABINETE PARA MEDIDA SEMIDIRECTA FABRICADO EN LÁMINA GALVANIZADA CALIBRE 16. CON PINTURA ELECTROSTATICA RAL 7035. IP65. 1500X800X300 mm",
            "cantidad": 1,
            "precio_de_lista": 1325753.617,
            "precio_de_lista2": 1325753.617,
            "alerta_mano_obra": 21.62
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "PENDIENTE VALOR TGA PARA EPM SALIDA DESENTRALIZADA PARA TABLEROS DE CONTADORES (PREGUNTAR A ELVER CODIGO O VALOR)",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "87729",
            "title": "BREAKER 3X(250)A 65/30KA 220/440VAC",
            "cantidad": 1,
            "precio_de_lista": 232263.68,
            "precio_de_lista2": 232263.68,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "21",
            "title": "BREAKER 3X250A 50/25 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 712712.32,
            "precio_de_lista2": 712712.32,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "2124",
            "title": "BREAKER 3X250 A 50/36KA 240/415 V",
            "cantidad": 1,
            "precio_de_lista": 728864.5032,
            "precio_de_lista2": 728864.5032,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23304",
            "title": "MEDIDOR ELECTRÓNICO MULTIFUNCIONAL, CLASE 1. 5-120 AMPERIOS, 3*127/208VOLTIOS CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA Y OPCIÓN DE COMUNICACIÓN. NO COMPATIBLE MV90 VALIDADO EPM Y CON PROTOCOLO",
            "cantidad": 1,
            "precio_de_lista": 1520000,
            "precio_de_lista2": 1520000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23314",
            "title": "BORNERA DE PRUEBA TIPO LANDIS",
            "cantidad": 1,
            "precio_de_lista": 256000,
            "precio_de_lista2": 256000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "24630",
            "title": "TRANSFORMADORES DE CORRIENTE 200/5 CLASE 0,5 5VA CALIBRADOS",
            "cantidad": 3,
            "precio_de_lista": 112000,
            "precio_de_lista2": 336000,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59821",
            "title": "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
            "cantidad": 1,
            "precio_de_lista": 266228.544,
            "precio_de_lista2": 266228.544,
            "alerta_mano_obra": 5.75
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23302",
            "title": "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
            "cantidad": 1,
            "precio_de_lista": 2720000,
            "precio_de_lista2": 2720000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23314",
            "title": "BORNERA DE PRUEBA TIPO LANDIS",
            "cantidad": 1,
            "precio_de_lista": 256000,
            "precio_de_lista2": 256000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "24602",
            "title": "TRANSFORMADORES DE CORRIENTE 200/5 CLASE 0,5S 2.5VA CALIBRADOS",
            "cantidad": 3,
            "precio_de_lista": 152000,
            "precio_de_lista2": 456000,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59821",
            "title": "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
            "cantidad": 1,
            "precio_de_lista": 266228.544,
            "precio_de_lista2": 266228.544,
            "alerta_mano_obra": 5.75
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "87717",
            "title": "BREAKER 3X(40)A 25/15KA 220/440VAC",
            "cantidad": 5,
            "precio_de_lista": 151890.432,
            "precio_de_lista2": 759452.16,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "87718",
            "title": "BREAKER 3X(50)A 25/15KA 220/440VAC",
            "cantidad": 5,
            "precio_de_lista": 151890.432,
            "precio_de_lista2": 759452.16,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "87719",
            "title": "BREAKER 3X(63)A 25/15KA 220/440VAC",
            "cantidad": 4,
            "precio_de_lista": 151890.432,
            "precio_de_lista2": 607561.728,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "02097",
            "title": "BREAKER 3X63 A 25/18KA 240/415 V",
            "cantidad": 5,
            "precio_de_lista": 188702.784,
            "precio_de_lista2": 943513.92,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "02098",
            "title": "BREAKER 3X80 A 25/18KA 240/415 V",
            "cantidad": 5,
            "precio_de_lista": 188702.784,
            "precio_de_lista2": 943513.92,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "02135",
            "title": "BREAKER 3X(40-50) A 35/25KA 240/415 V",
            "cantidad": 4,
            "precio_de_lista": 234699.0876,
            "precio_de_lista2": 938796.3504,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "02136",
            "title": "BREAKER 3X(50-63) A 35/25KA 240/415 V",
            "cantidad": 5,
            "precio_de_lista": 234699.0876,
            "precio_de_lista2": 1173495.438,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "9",
            "title": "BREAKER 3X30A 25/12,5 KA 240/440V",
            "cantidad": 5,
            "precio_de_lista": 265360,
            "precio_de_lista2": 1326800,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "10",
            "title": "BREAKER 3X40A 25/12,5 KA 240/440V",
            "cantidad": 5,
            "precio_de_lista": 265360,
            "precio_de_lista2": 1326800,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "11",
            "title": "BREAKER 3X50A 25/12,5 KA 240/440V",
            "cantidad": 4,
            "precio_de_lista": 265360,
            "precio_de_lista2": 1061440,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "13",
            "title": "BREAKER 3X80A 25/12,5 KA 240/440V",
            "cantidad": 5,
            "precio_de_lista": 265360,
            "precio_de_lista2": 1326800,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "14",
            "title": "BREAKER 3X100A 25/12,5 KA 240/440V",
            "cantidad": 3,
            "precio_de_lista": 265360,
            "precio_de_lista2": 796080,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "4727",
            "title": "MINIBREAKER 1X20A 12/10KA 127/240VAC",
            "cantidad": 4,
            "precio_de_lista": 12699.136,
            "precio_de_lista2": 50796.544,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "4739",
            "title": "MINIBREAKER 2X20A 10KA 240VAC",
            "cantidad": 5,
            "precio_de_lista": 29558.784,
            "precio_de_lista2": 147793.92,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "4751",
            "title": "MINIBREAKER 3X20A 10KA 240VAC",
            "cantidad": 3,
            "precio_de_lista": 41746.432,
            "precio_de_lista2": 125239.296,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "5126",
            "title": "MINIBREAKER 1X16A  10 KA 120VAC",
            "cantidad": 4,
            "precio_de_lista": 19420.8,
            "precio_de_lista2": 77683.2,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "5138",
            "title": "MINIBREAKER 2X16A 10 KA 220V",
            "cantidad": 5,
            "precio_de_lista": 41350.4,
            "precio_de_lista2": 206752,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "5151",
            "title": "MINIBREAKER 3X20A 10 KA 220V",
            "cantidad": 3,
            "precio_de_lista": 74816,
            "precio_de_lista2": 224448,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 4,
        "equipo_selec": {
            "value": "6059",
            "title": "MINIBREAKER 1X16A, 10KA, 230/400VAC",
            "cantidad": 4,
            "precio_de_lista": 24492.8,
            "precio_de_lista2": 97971.2,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 5,
        "equipo_selec": {
            "value": "6076",
            "title": "MINIBREAKER 2X16A, 10KA, 230/400VAC",
            "cantidad": 5,
            "precio_de_lista": 48985.6,
            "precio_de_lista2": 244928,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 3,
        "equipo_selec": {
            "value": "6094",
            "title": "MINIBREAKER 3X20A, 10KA, 230/400VAC",
            "cantidad": 3,
            "precio_de_lista": 82663.2,
            "precio_de_lista2": 247989.6,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "RESERVA NO EQUIPADA NI CABLEADA HASTA ***AMP",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "12",
            "title": "BREAKER 3X60A 25/12,5 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 265360,
            "precio_de_lista2": 265360,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "02136",
            "title": "BREAKER 3X(50-63) A 35/25KA 240/415 V",
            "cantidad": 1,
            "precio_de_lista": 234699.0876,
            "precio_de_lista2": 234699.0876,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "29752",
            "title": "TIPO 1+2, 3P 150 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
            "cantidad": 1,
            "precio_de_lista": 457775.616,
            "precio_de_lista2": 457775.616,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59842",
            "title": "CABLEADO DPS",
            "cantidad": 1,
            "precio_de_lista": 27200,
            "precio_de_lista2": 27200,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+N+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 875474.6208,
            "precio_de_lista2": 875474.6208,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "ITEM SIN CODIGO",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 3699209.349,
            "precio_de_lista2": 3699209.349,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE DE MEDIDA BT CON TOTALIZADOR",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91027",
            "title": "T. EMPAQUE CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 117800,
            "precio_de_lista2": 117800,
            "alerta_mano_obra": 0
        }
    }
]
    if (indexItem === 15 && parte === 2)
        data.equipos = [
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69029",
            "title": "GABINETE PARA 12 CONTADORES. FABRICADO SEGÚN NORMA EPM. CON PINTURA ELECTROSTATICA RAL 7035. IP20. 2200X750X300 mm",
            "cantidad": 1,
            "precio_de_lista": 1064563.243,
            "precio_de_lista2": 1064563.243,
            "alerta_mano_obra": 17.37
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69045",
            "title": "GABINETE PARA 12 CONTADORES. FABRICADO SEGÚN NORMA ELECTRICARIBE. CON PINTURA ELECTROSTATICA RAL 7035. IP20. 1850X1000X400 mm",
            "cantidad": 1,
            "precio_de_lista": 1458656.237,
            "precio_de_lista2": 1458656.237,
            "alerta_mano_obra": 17.37
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "87725",
            "title": "BREAKER 3X(160)A 65/30KA 220/440VAC",
            "cantidad": 1,
            "precio_de_lista": 232263.68,
            "precio_de_lista2": 232263.68,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "17",
            "title": "BREAKER 3X160A 50/25 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 699655.864,
            "precio_de_lista2": 699655.864,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "2110",
            "title": "BREAKER 3X160 A 35/25KA 240/415 V",
            "cantidad": 1,
            "precio_de_lista": 480012.7068,
            "precio_de_lista2": 480012.7068,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": "23334",
            "title": "MEDIDOR DIRECTOS 5-100 AMPERIOS, 2X120/208 VOLTIOS. CALIBRADO PARA REDES EPM (ACTIVA)",
            "cantidad": 12,
            "precio_de_lista": 288000,
            "precio_de_lista2": 3456000,
            "alerta_mano_obra": 0.99
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": "23341",
            "title": "MEDIDOR DIRECTOS 5-100 AMPERIOS, 3X120/208 VOLTIOS. CALIBRADO PARA REDES EPM (ACTIVA Y REACTIVA)",
            "cantidad": 12,
            "precio_de_lista": 416000,
            "precio_de_lista2": 4992000,
            "alerta_mano_obra": 0.99
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO CONTADOR 3F EN THHN # 8 TIPO EPM",
            "cantidad": 12,
            "precio_de_lista": 136408.272,
            "precio_de_lista2": 1636899.264,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO CONTADOR 3F EN THHN # 2 TIPO EPM",
            "cantidad": 12,
            "precio_de_lista": 490065.576,
            "precio_de_lista2": 5880786.912,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO CONTADOR 2F EN THHN # 8 TIPO EPM",
            "cantidad": 12,
            "precio_de_lista": 98116.4184,
            "precio_de_lista2": 1177397.021,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO CONTADOR 2F EN THHN # 2 TIPO EPM",
            "cantidad": 12,
            "precio_de_lista": 345676.5312,
            "precio_de_lista2": 4148118.374,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": "4742",
            "title": "MINIBREAKER 2X40A 10KA 240VAC",
            "cantidad": 12,
            "precio_de_lista": 29558.784,
            "precio_de_lista2": 354705.408,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": "6132",
            "title": "MINIBREAKER 2X40A, 15/6KA, 220/400VAC",
            "cantidad": 12,
            "precio_de_lista": 42862.4,
            "precio_de_lista2": 514348.8,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 12,
        "equipo_selec": {
            "value": "5142",
            "title": "MINIBREAKER 2X40A 10 KA 220V",
            "cantidad": 12,
            "precio_de_lista": 42963.2,
            "precio_de_lista2": 515558.4,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+N+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 412467.276,
            "precio_de_lista2": 412467.276,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 2384879.717,
            "precio_de_lista2": 2384879.717,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE DE CONTADORES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91028",
            "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 196047.1,
            "precio_de_lista2": 196047.1,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "RESERVA NO EQUIPADA NI CABLEADA HASTA ***AMP",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23400",
            "title": "MEDIDOR MULTIFUNCIONAL, PANTALLA LCD GRAFICA COLORES. MEDIDA DIRECTA/SEMIDIRECTA/INDIRECTA. CL 0.2S. BIDEIRECCIONAL. PUERTO DE COMUNICACION RS485 Y ETHERNET. PROTOCOLO MODBUS RTU-TCP/IP. REGISTRO DE DATOS Y PERFILES DE CARGA (DEMANDA, FACTOR DE POTENCIA, ARMONICOS).",
            "cantidad": 1,
            "precio_de_lista": 1728307.712,
            "precio_de_lista2": 1728307.712,
            "alerta_mano_obra": 1.54
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23486",
            "title": "MEDIDOR DE ENERGIA BIDIRECCIONAL MULTIFUNCIONAL, MULTITARIFAS. CL 0,2S. PARA CT'S Y VT'S. COMUNICACION RS485 CON PROTOCOLO MODBUS. PERFILES DE CARGA.",
            "cantidad": 1,
            "precio_de_lista": 5569487.328,
            "precio_de_lista2": 5569487.328,
            "alerta_mano_obra": 1.54
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "24323",
            "title": "ANALIZADOR DE REDES 60 VARIABLES, CON COMUNICACION ETHERNET-RS485 Y USB.",
            "cantidad": 1,
            "precio_de_lista": 3759929.6,
            "precio_de_lista2": 3759929.6,
            "alerta_mano_obra": 1.54
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 3,
        "equipo_selec": {
            "value": "24328",
            "title": "TRANSFORMADOR DE CORRIENTE DE 1000/5A CL 0,5 BURDEN 10VA.",
            "cantidad": 3,
            "precio_de_lista": 68836.864,
            "precio_de_lista2": 206510.592,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "24322",
            "title": "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
            "cantidad": 1,
            "precio_de_lista": 68836.864,
            "precio_de_lista2": 68836.864,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59818",
            "title": "KIT DE CABLEADO DE CONTROL ANALIZADOR DE REDES 220VAC",
            "cantidad": 1,
            "precio_de_lista": 393150.7872,
            "precio_de_lista2": 393150.7872,
            "alerta_mano_obra": 5.75
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23302",
            "title": "MEDIDOR ELECTRONICO MULTIFUNCIONAL 3*58/100...277/480V. CLASE 0,5S CALIBRADO BIDIRECCIONAL, CON PERFIL DE CARGA, CON OPCION DE COMUNICACIÓN. COMPATIBLE MV90. VERIFICADO Y CON PROTOCOLO.",
            "cantidad": 1,
            "precio_de_lista": 2720000,
            "precio_de_lista2": 2720000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23314",
            "title": "BORNERA DE PRUEBA TIPO LANDIS",
            "cantidad": 1,
            "precio_de_lista": 256000,
            "precio_de_lista2": 256000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 3,
        "equipo_selec": {
            "value": "24601",
            "title": "TRANSFORMADORES DE CORRIENTE 100/5 CLASE 0,5S 2.5VA CALIBRADOS",
            "cantidad": 3,
            "precio_de_lista": 152000,
            "precio_de_lista2": 456000,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59821",
            "title": "KIT DE CABLEADO DE CONTROL CONTADOR ELECTRONICO BT",
            "cantidad": 1,
            "precio_de_lista": 266228.544,
            "precio_de_lista2": 266228.544,
            "alerta_mano_obra": 5.75
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "25006",
            "title": "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
            "cantidad": 1,
            "precio_de_lista": 440000,
            "precio_de_lista2": 440000,
            "alerta_mano_obra": 0.37
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y ACCESORIOS TRANSFORMADOR",
            "cantidad": 1,
            "precio_de_lista": 93000,
            "precio_de_lista2": 93000,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 220/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "1497",
            "title": "BREAKER 3X(18-25) A 55/25 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 458172,
            "precio_de_lista2": 458172,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "29756",
            "title": "TIPO 1+2, 3P 320 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
            "cantidad": 1,
            "precio_de_lista": 457775.616,
            "precio_de_lista2": 457775.616,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "29842",
            "title": "DPS Tipo I+II 12.5 KA 10/350, 65 KA 8/20 x polo 3P 277/480 VAC MOX",
            "cantidad": 1,
            "precio_de_lista": 3347206.4,
            "precio_de_lista2": 3347206.4,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59842",
            "title": "CABLEADO DPS",
            "cantidad": 1,
            "precio_de_lista": 27200,
            "precio_de_lista2": 27200,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+N+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 3574906.744,
            "precio_de_lista2": 3574906.744,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "ITEM SIN CODIGO",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 6018524.62,
            "precio_de_lista2": 6018524.62,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "ANALIZADOR DE REDES",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91028",
            "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 196047.1,
            "precio_de_lista2": 196047.1,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "73246",
            "title": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
            "cantidad": 1,
            "precio_de_lista": 1428525.096,
            "precio_de_lista2": 1428525.096,
            "alerta_mano_obra": 26.22
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "73339",
            "title": "GABINETE FABRICADO EN LÁMINA GALVANIZADA CALIBRE 14 Y 16, 2000X1200X600 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
            "cantidad": 1,
            "precio_de_lista": 2131924.91,
            "precio_de_lista2": 2131924.91,
            "alerta_mano_obra": 26.22
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "70409",
            "title": "TABLERO AUTOSOPORTADO MODULAR, FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16. CON PINTURA ELECTROSTATICA RAL 7035. IP44. 2000X1000X600 mm",
            "cantidad": 1,
            "precio_de_lista": 4281527.527,
            "precio_de_lista2": 4281527.527,
            "alerta_mano_obra": 3.59
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "70538",
            "title": "PAREDES LATERALES ATORNILLABLES, IP55. 2000X800 mm. RAL7035",
            "cantidad": 1,
            "precio_de_lista": 1047059.14,
            "precio_de_lista2": 1047059.14,
            "alerta_mano_obra": 2.88
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72651",
            "title": "Placa de Montaje Estándar 2000 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #18.",
            "cantidad": 1,
            "precio_de_lista": 174121.999,
            "precio_de_lista2": 174121.999,
            "alerta_mano_obra": 2.3
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 4,
        "equipo_selec": {
            "value": "72671",
            "title": "Placa de Montaje Estándar 400 x 1000 mm, fabricada en LÁMINA Galvanizada Calibre #18. +Juego de Soportes (x4 und)",
            "cantidad": 4,
            "precio_de_lista": 46713.69273,
            "precio_de_lista2": 186854.7709,
            "alerta_mano_obra": 2.3
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72690",
            "title": "SOPORTE EN ANGULO INTERRUPTOR PARA TABLERO GEA",
            "cantidad": 1,
            "precio_de_lista": 74872.56,
            "precio_de_lista2": 74872.56,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72689",
            "title": "CUBICULO DE MEDIDA PARA TABLERO GEA",
            "cantidad": 1,
            "precio_de_lista": 185841.9272,
            "precio_de_lista2": 185841.9272,
            "alerta_mano_obra": 2.3
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69884",
            "title": "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTROSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X1000 MM",
            "cantidad": 1,
            "precio_de_lista": 417298.8471,
            "precio_de_lista2": 417298.8471,
            "alerta_mano_obra": 7.25
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "1738",
            "title": "BREAKER 3X(500-1250) A 85/55 KA 240/440V UNIDAD ELECTRONICA",
            "cantidad": 1,
            "precio_de_lista": 10380960,
            "precio_de_lista2": 10380960,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "125",
            "title": "BREAKER 3X(500-1250) A 50/50 KA 240/440V MICROLOGIC 2.0 E",
            "cantidad": 1,
            "precio_de_lista": 8869146.24,
            "precio_de_lista2": 8869146.24,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "1545",
            "title": "BREAKER 3X(500-1250) A 66/66 KA 240/500V TIPO ABIERTO FIJO CON PROTECCION ELECTRONICA",
            "cantidad": 1,
            "precio_de_lista": 13480224.8,
            "precio_de_lista2": 13480224.8,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "2163",
            "title": "KIT DE TRANSFERENCIA 500-1250A CON INTERRUPTOR DE POTENCIA MOTORIZADO",
            "cantidad": 1,
            "precio_de_lista": 23075279.2,
            "precio_de_lista2": 23075279.2,
            "alerta_mano_obra": 5.05
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 2,
        "equipo_selec": {
            "value": "132",
            "title": "BREAKER 3X(500-1250) A 50/50 KA 240/440V MICROLOGIC 2.0 MOTORIZADO",
            "cantidad": 2,
            "precio_de_lista": 12665417.28,
            "precio_de_lista2": 25330834.56,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "501",
            "title": "PLACA DE ENCLAVAMIENTO Y CABLES GUAYAS PARA 2 BREAKERS",
            "cantidad": 1,
            "precio_de_lista": 3252028,
            "precio_de_lista2": 3252028,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22111",
            "title": "RELE DE TRANSFERENCIA AUTOMATICA, RED-RED Y RED - GENERADOR",
            "cantidad": 1,
            "precio_de_lista": 2609555.2,
            "precio_de_lista2": 2609555.2,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59801",
            "title": "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MANUALES",
            "cantidad": 1,
            "precio_de_lista": 603964.2835,
            "precio_de_lista2": 603964.2835,
            "alerta_mano_obra": 11.68
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22142",
            "title": "CONTROLADOR CONMUTADOR DE TRANSFERENCIA ATS",
            "cantidad": 1,
            "precio_de_lista": 1184000,
            "precio_de_lista2": 1184000,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "5007",
            "title": "FUENTE CONMUTADA 5A ,ENTRADA 90/264 Vac,SALIDA 24 Vdc, MONTAJE RIEL DIN",
            "cantidad": 1,
            "precio_de_lista": 357499.296,
            "precio_de_lista2": 357499.296,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, CON PINTURA ELECTROSTATICA RAL7035. IP44.",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59802",
            "title": "KIT DE CABLEADO DE CONTROL TRANSFERENCIA CON INTERRUPTORES MOTORIZADOS",
            "cantidad": 1,
            "precio_de_lista": 705994.0051,
            "precio_de_lista2": 705994.0051,
            "alerta_mano_obra": 11.68
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "73246",
            "title": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
            "cantidad": 1,
            "precio_de_lista": 1428525.096,
            "precio_de_lista2": 1428525.096,
            "alerta_mano_obra": 26.22
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69878",
            "title": "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTROSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X800 MM",
            "cantidad": 1,
            "precio_de_lista": 356198.696,
            "precio_de_lista2": 356198.696,
            "alerta_mano_obra": 7.25
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "15",
            "title": "BREAKER 3X125A 50/25 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 590095.168,
            "precio_de_lista2": 590095.168,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "2091",
            "title": "BREAKER 3X125 A 30/25KA 240/415 V",
            "cantidad": 1,
            "precio_de_lista": 352638.3276,
            "precio_de_lista2": 352638.3276,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22001",
            "title": "RELE CORRECTOR FACTOR DE POTENCIA 5 PASOS 100-600 VAC",
            "cantidad": 1,
            "precio_de_lista": 1336819.2,
            "precio_de_lista2": 1336819.2,
            "alerta_mano_obra": 1.66
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22007",
            "title": "MODULO EXPANSION 2 PASOS DCRL, DCRG",
            "cantidad": 1,
            "precio_de_lista": 322300.8,
            "precio_de_lista2": 322300.8,
            "alerta_mano_obra": null
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22008",
            "title": "MODULO EXPANSION 3 PASOS DCRL, DCRG",
            "cantidad": 1,
            "precio_de_lista": 775843.2,
            "precio_de_lista2": 775843.2,
            "alerta_mano_obra": null
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22603",
            "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
            "cantidad": 1,
            "precio_de_lista": 64934.4,
            "precio_de_lista2": 64934.4,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59827",
            "title": "KIT DE CABLEADO DE CONTROL RELÉ CORRECTOR FP 6-8 PASOS 440 VAC Y/O 220 VAC",
            "cantidad": 1,
            "precio_de_lista": 804070.56,
            "precio_de_lista2": 804070.56,
            "alerta_mano_obra": 1.66
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "24322",
            "title": "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA. PASO FIJO 2X0KVAR",
            "cantidad": 1,
            "precio_de_lista": 64594.944,
            "precio_de_lista2": 64594.944,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "9",
            "title": "BREAKER 3X30A 25/12,5 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 265360,
            "precio_de_lista2": 265360,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "2100",
            "title": "BREAKER 3X32A 25/18KA 240/415 V",
            "cantidad": 1,
            "precio_de_lista": 188702.784,
            "precio_de_lista2": 188702.784,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22969",
            "title": "CAPACITOR 19/20 KVAR 460/480 VAC",
            "cantidad": 1,
            "precio_de_lista": 318080,
            "precio_de_lista2": 318080,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22939",
            "title": "CAPACITOR 20 KVAR 440 VAC",
            "cantidad": 1,
            "precio_de_lista": 365683.2,
            "precio_de_lista2": 365683.2,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23100",
            "title": "Condensador cilíndrico 20,0 KVAR 440V",
            "cantidad": 1,
            "precio_de_lista": 320614.72,
            "precio_de_lista2": 320614.72,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO POTENCIA INTERRUPTORES, CONDENSADOR Y CONTACTOR DE LOS PASOS MOVILES 15KVAR",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "9",
            "title": "BREAKER 3X30A 25/12,5 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 265360,
            "precio_de_lista2": 265360,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "14106",
            "title": "CONTACTOR  40AMP AC1, 18AMP AC3, 220VAC, 1NA+1NC",
            "cantidad": 1,
            "precio_de_lista": 119592,
            "precio_de_lista2": 119592,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "14153",
            "title": "RESISTENCIA DE PRECARGA 8.5 KVAR 240V / 16.7 KVAR 440V / 24 KVAR 550V)",
            "cantidad": 1,
            "precio_de_lista": 90161.28,
            "precio_de_lista2": 90161.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "12702",
            "title": "CONTACTOR CONDENSADOR 7,5/12,5/15 KVAR 220/440/480V (220V)",
            "cantidad": 1,
            "precio_de_lista": 303027.2,
            "precio_de_lista2": 303027.2,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11104",
            "title": "CONTACTOR 17 KVAR 440 VAC / 9 KVAR 220VAC BOBINA A 220V",
            "cantidad": 1,
            "precio_de_lista": 406472,
            "precio_de_lista2": 406472,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22938",
            "title": "CAPACITOR 15 KVAR 440 VAC",
            "cantidad": 1,
            "precio_de_lista": 334924.8,
            "precio_de_lista2": 334924.8,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23100",
            "title": "Condensador cilíndrico 20,0 KVAR 440V",
            "cantidad": 1,
            "precio_de_lista": 320614.72,
            "precio_de_lista2": 320614.72,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO POTENCIA INTERRUPTORES, CONDENSADOR Y CONTACTOR DE LOS PASOS MOVILES 30KVAR",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11",
            "title": "BREAKER 3X50A 25/12,5 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 265360,
            "precio_de_lista2": 265360,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "14112",
            "title": "CONTACTOR  60AMP AC1, 40AMP AC3, 220VAC, 2NA+2NC",
            "cantidad": 1,
            "precio_de_lista": 277295.04,
            "precio_de_lista2": 277295.04,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "14156",
            "title": "RESISTENCIA DE PRECARGA 20KVAR 240V / 33.3 KVAR 440V / 48KVAR 550V)",
            "cantidad": 1,
            "precio_de_lista": 90161.28,
            "precio_de_lista2": 90161.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "12703",
            "title": "CONTACTOR CONDENSADOR 9,6/16,7/21 KVAR 220/440/480V (110V)",
            "cantidad": 1,
            "precio_de_lista": 343611.2,
            "precio_de_lista2": 343611.2,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "12012",
            "title": "CONTACTOR PARA CONDENSADOR DE 17,5/30 KVAR 230/440VAC (440VAC), 1NA",
            "cantidad": 1,
            "precio_de_lista": 537292.8,
            "precio_de_lista2": 537292.8,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11110",
            "title": "CONTACTOR 33 KVAR 440 VAC / 20 KVAR 220VAC BOBINA A 220V",
            "cantidad": 1,
            "precio_de_lista": 796323.536,
            "precio_de_lista2": 796323.536,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22946",
            "title": "CAPACITOR 30 KVAR 480 VAC",
            "cantidad": 1,
            "precio_de_lista": 471628.8,
            "precio_de_lista2": 471628.8,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "23100",
            "title": "Condensador cilíndrico 20,0 KVAR 440V",
            "cantidad": 1,
            "precio_de_lista": 320614.72,
            "precio_de_lista2": 320614.72,
            "alerta_mano_obra": 1.39
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO POTENCIA INTERRUPTORES, CONDENSADOR Y CONTACTOR DE LOS PASOS MOVILES",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30063",
            "title": "Ventilador 55 m3/h  6\"  148.5 x   148.5 mm   230 V",
            "cantidad": 1,
            "precio_de_lista": 513799.8374,
            "precio_de_lista2": 513799.8374,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30065",
            "title": "Filtro de salida   6\"    148.5 x   148.5 mm",
            "cantidad": 1,
            "precio_de_lista": 137106.5597,
            "precio_de_lista2": 137106.5597,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30125",
            "title": "Ventilador 45-50 m3/h  6\"  150X150 mm   230 V",
            "cantidad": 1,
            "precio_de_lista": 345116.8,
            "precio_de_lista2": 345116.8,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30126",
            "title": "Filtro de salida  6\"  150X150 mm",
            "cantidad": 1,
            "precio_de_lista": 71225.6,
            "precio_de_lista2": 71225.6,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30112",
            "title": "EXTRACTOR 6\" CAUDAL 170-204 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
            "cantidad": 1,
            "precio_de_lista": 154997.4272,
            "precio_de_lista2": 154997.4272,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30113",
            "title": "REJILLA CON FILTRO 6\" IP54",
            "cantidad": 1,
            "precio_de_lista": 65582.0704,
            "precio_de_lista2": 65582.0704,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30115",
            "title": "EXTRACTOR 8\" CAUDAL 305-332 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
            "cantidad": 1,
            "precio_de_lista": 297510.752,
            "precio_de_lista2": 297510.752,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30116",
            "title": "REJILLA CON FILTRO 8\" IP54",
            "cantidad": 1,
            "precio_de_lista": 87145.52,
            "precio_de_lista2": 87145.52,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59839",
            "title": "KIT DE CABLEADO DE CONTROL EXTRACTORES/VENTILADORES",
            "cantidad": 1,
            "precio_de_lista": 139265.7197,
            "precio_de_lista2": 139265.7197,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "5136",
            "title": "MINIBREAKER 2X6A 10 KA 220V",
            "cantidad": 1,
            "precio_de_lista": 41350.4,
            "precio_de_lista2": 41350.4,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 2,
        "equipo_selec": {
            "value": "6074",
            "title": "MINIBREAKER 2X6A, 10KA, 230/400VAC",
            "cantidad": 2,
            "precio_de_lista": 48985.6,
            "precio_de_lista2": 97971.2,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "25006",
            "title": "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
            "cantidad": 1,
            "precio_de_lista": 440000,
            "precio_de_lista2": 440000,
            "alerta_mano_obra": 0.37
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y ACCESORIOS TRANSFORMADOR",
            "cantidad": 1,
            "precio_de_lista": 93000,
            "precio_de_lista2": 93000,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+N+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 2531644.037,
            "precio_de_lista2": 2531644.037,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "ITEM SIN CODIGO",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 196047.1,
            "precio_de_lista2": 196047.1,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "GABINETE BANCO DE CONDENSADORES 75 KVAR 460V",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91028",
            "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 196047.1,
            "precio_de_lista2": 196047.1,
            "alerta_mano_obra": 0
        }
    }
]
    if (indexItem === 16 && parte === 2)
        data.equipos = [
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "73487",
            "title": "GABINETE FABRICADO EN LÁMINA ________ CALIBRE __ Y __, _____X600X____ mm. PINTURA ELECTROSTATICA RAL7035. IP54. TIPO CCM_GEA",
            "cantidad": 1,
            "precio_de_lista": 3637253.756,
            "precio_de_lista2": 3637253.756,
            "alerta_mano_obra": 39.8
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "73489",
            "title": "GABINETE PARA DUCTO CCM FABRICADO EN LÁMINA ________ CALIBRE __ Y __, _____X600X____ mm. PINTURA ELECTROSTATICA RAL7035. IP54. TIPO CCM_GEA",
            "cantidad": 1,
            "precio_de_lista": 825780.8907,
            "precio_de_lista2": 825780.8907,
            "alerta_mano_obra": 29.8
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "78",
            "title": "BREAKER 3X(175-250) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 1733780.16,
            "precio_de_lista2": 1733780.16,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "437",
            "title": "MANDO ROTATIVO PROLONGADO ESTANDAR",
            "cantidad": 1,
            "precio_de_lista": 343169.28,
            "precio_de_lista2": 343169.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "437",
            "title": "MANDO ROTATIVO PROLONGADO ESTANDAR",
            "cantidad": 1,
            "precio_de_lista": 343169.28,
            "precio_de_lista2": 343169.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11268",
            "title": "CONTACTOR 80AMP AC1, 65AMP AC3, 220VAC, 1NO + 1NC",
            "cantidad": 1,
            "precio_de_lista": 609883.832,
            "precio_de_lista2": 609883.832,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11288",
            "title": "BLOQUE DE CONTACTOS AUXILIARES FRONTALES 2NO/2NC",
            "cantidad": 1,
            "precio_de_lista": 56048,
            "precio_de_lista2": 56048,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "20076",
            "title": "RELE TERMICO 48A-65A",
            "cantidad": 1,
            "precio_de_lista": 351912,
            "precio_de_lista2": 351912,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "41801",
            "title": "SELECTOR 3 POSICIONES CON RETENCION",
            "cantidad": 1,
            "precio_de_lista": 17890.304,
            "precio_de_lista2": 17890.304,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "22603",
            "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
            "cantidad": 2,
            "precio_de_lista": 64934.4,
            "precio_de_lista2": 129868.8,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59830",
            "title": "KIT DE CABLEADO DE CONTROL ARRANQUE DIRECTO",
            "cantidad": 1,
            "precio_de_lista": 347796.8333,
            "precio_de_lista2": 347796.8333,
            "alerta_mano_obra": 4
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "437",
            "title": "MANDO ROTATIVO PROLONGADO ESTANDAR",
            "cantidad": 1,
            "precio_de_lista": 343169.28,
            "precio_de_lista2": 343169.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "11264",
            "title": "CONTACTOR 60AMP AC1, 40AMP AC3, 220VAC, 1NO + 1NC",
            "cantidad": 2,
            "precio_de_lista": 331576,
            "precio_de_lista2": 663152,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11260",
            "title": "CONTACTOR 50AMP AC1, 32AMP AC3, 220VAC, 1NO + 1NC",
            "cantidad": 1,
            "precio_de_lista": 222456,
            "precio_de_lista2": 222456,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11288",
            "title": "BLOQUE DE CONTACTOS AUXILIARES FRONTALES 2NO/2NC",
            "cantidad": 1,
            "precio_de_lista": 56048,
            "precio_de_lista2": 56048,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11289",
            "title": "BLOQUE DE CONTACTOS AUXILIARES FRONTALES TEMPORIZADO 1NO",
            "cantidad": 1,
            "precio_de_lista": 139128,
            "precio_de_lista2": 139128,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "20074",
            "title": "RELE TERMICO 30A-40A",
            "cantidad": 1,
            "precio_de_lista": 301568,
            "precio_de_lista2": 301568,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "41801",
            "title": "SELECTOR 3 POSICIONES CON RETENCION",
            "cantidad": 1,
            "precio_de_lista": 17890.304,
            "precio_de_lista2": 17890.304,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22720",
            "title": "TEMPORIZADOR ELECTRONICO AL TRABAJO 1NA-NC 24-48VDC/24-240VAC. Temporizacion Multiescala 0.1 Seg - 10 dias.",
            "cantidad": 1,
            "precio_de_lista": 298096,
            "precio_de_lista2": 298096,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "22603",
            "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
            "cantidad": 2,
            "precio_de_lista": 64934.4,
            "precio_de_lista2": 129868.8,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59831",
            "title": "KIT DE CABLEADO DE CONTROL ARRANQUE ESTRELLA - DELTA",
            "cantidad": 1,
            "precio_de_lista": 376190.5805,
            "precio_de_lista2": 376190.5805,
            "alerta_mano_obra": 5
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "437",
            "title": "MANDO ROTATIVO PROLONGADO ESTANDAR",
            "cantidad": 1,
            "precio_de_lista": 343169.28,
            "precio_de_lista2": 343169.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11268",
            "title": "CONTACTOR 80AMP AC1, 65AMP AC3, 220VAC, 1NO + 1NC",
            "cantidad": 1,
            "precio_de_lista": 609883.832,
            "precio_de_lista2": 609883.832,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "41801",
            "title": "SELECTOR 3 POSICIONES CON RETENCION",
            "cantidad": 1,
            "precio_de_lista": 17890.304,
            "precio_de_lista2": 17890.304,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 3,
        "equipo_selec": {
            "value": "22603",
            "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
            "cantidad": 3,
            "precio_de_lista": 64934.4,
            "precio_de_lista2": 194803.2,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59832",
            "title": "KIT DE CABLEADO DE CONTROL VARIADORES O ARRANCADORES SUAVES (SIN SALIDAS)",
            "cantidad": 1,
            "precio_de_lista": 347796.8333,
            "precio_de_lista2": 347796.8333,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "437",
            "title": "MANDO ROTATIVO PROLONGADO ESTANDAR",
            "cantidad": 1,
            "precio_de_lista": 343169.28,
            "precio_de_lista2": 343169.28,
            "alerta_mano_obra": 0.17
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "11268",
            "title": "CONTACTOR 80AMP AC1, 65AMP AC3, 220VAC, 1NO + 1NC",
            "cantidad": 1,
            "precio_de_lista": 609883.832,
            "precio_de_lista2": 609883.832,
            "alerta_mano_obra": 0.41
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "41801",
            "title": "SELECTOR 3 POSICIONES CON RETENCION",
            "cantidad": 1,
            "precio_de_lista": 17890.304,
            "precio_de_lista2": 17890.304,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 3,
        "equipo_selec": {
            "value": "22603",
            "title": "RELEVO 8 PINES CON BASE, 2 CONTACTOS 230 VAC",
            "cantidad": 3,
            "precio_de_lista": 64934.4,
            "precio_de_lista2": 194803.2,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59832",
            "title": "KIT DE CABLEADO DE CONTROL VARIADORES O ARRANCADORES SUAVES (SIN SALIDAS)",
            "cantidad": 1,
            "precio_de_lista": 347796.8333,
            "precio_de_lista2": 347796.8333,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "50608",
            "title": "MODULO DE EXTENSION LOGO 4E/4S 115/230 VAC",
            "cantidad": 1,
            "precio_de_lista": 438015.6,
            "precio_de_lista2": 438015.6,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "50608",
            "title": "MODULO DE EXTENSION LOGO 4E/4S 115/230 VAC",
            "cantidad": 1,
            "precio_de_lista": 438015.6,
            "precio_de_lista2": 438015.6,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "6106",
            "title": "MINIBREAKER 1X2A, 10/6KA, 220/400VAC",
            "cantidad": 0,
            "precio_de_lista": 36739.2,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "6109",
            "title": "MINIBREAKER 1X6A, 10/6KA, 220/400VAC",
            "cantidad": 0,
            "precio_de_lista": 21431.2,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "22371",
            "title": "RELE INTERPOSICION, 6A, 250V, BOBINA 110-125 VAC/CD CON BASE. TORNILLO",
            "cantidad": 0,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.23
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44551",
            "title": "BORNERA 27A CONDUCTOR 20 A 12 AWG",
            "cantidad": 0,
            "precio_de_lista": 3273.6,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44576",
            "title": "BORNERA PORTAFUSIBLE 6.3A",
            "cantidad": 0,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44590",
            "title": "FRENO TIPO RIEL DIN",
            "cantidad": 0,
            "precio_de_lista": 6448,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44591",
            "title": "TAPA BORNERA CBC.2-CBC10/GR",
            "cantidad": 0,
            "precio_de_lista": 1785.6,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44590",
            "title": "FRENO TIPO RIEL DIN",
            "cantidad": 0,
            "precio_de_lista": 6448,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "44613",
            "title": "Referenciado para borneras CBC-CBD-HMM o para montaje multiple solo para bornera CBC.2; la presentación es tira por 20 tags personalizable. (La marcación por TAG requerida debe ser informada en su orden de compra)",
            "cantidad": 0,
            "precio_de_lista": 8233.6,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "50792",
            "title": "SWICHE INDUSTRIAL ETHERNET ADMINISTRABLE. 5TX",
            "cantidad": 0,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "50751",
            "title": "SIMATIC HMI, KTP400 BASIC, BASIC PANEL, MANDO POR TECLAS/TACTIL, PANTALLA TFT 4\", 65536 COLORES.",
            "cantidad": 0,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1.54
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "50803",
            "title": "FUENTE DE ALIMENTACION ESTABILIZADA. ENTRADA: 100-230 VAC (110-300 VDC) SALIDA: 24 VDC 5 AMP",
            "cantidad": 0,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "6106",
            "title": "MINIBREAKER 1X2A, 10/6KA, 220/400VAC",
            "cantidad": 0,
            "precio_de_lista": 36739.2,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 0,
        "equipo_selec": {
            "value": "6109",
            "title": "MINIBREAKER 1X6A, 10/6KA, 220/400VAC",
            "cantidad": 0,
            "precio_de_lista": 21431.2,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 40,
        "equipo_selec": {
            "value": "59841",
            "title": "PUNTO DE CONEXIÓN QUE INCLUYE: 2 MTS CABLE CENTELSA VEHICULO CALIBRE 16, TERMINALES PUNTERAS TUBULARES EN AMBAS PUNTAS, CORREAS Y ACCERORIOS, MARCACION EN CADA PUNTAS ORIGEN-DESTINO EN TERMOENCOGIBLE",
            "cantidad": 40,
            "precio_de_lista": 21773.52496,
            "precio_de_lista2": 870940.9984,
            "alerta_mano_obra": 0.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30063",
            "title": "Ventilador 55 m3/h 6\" 148.5 x 148.5 mm 230 V",
            "cantidad": 1,
            "precio_de_lista": 513799.8374,
            "precio_de_lista2": 513799.8374,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30065",
            "title": "Filtro de salida 6\" 148.5 x 148.5 mm",
            "cantidad": 1,
            "precio_de_lista": 137106.5597,
            "precio_de_lista2": 137106.5597,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30125",
            "title": "Ventilador 45-50 m3/h 6\" 150X150 mm 230 V",
            "cantidad": 1,
            "precio_de_lista": 345116.8,
            "precio_de_lista2": 345116.8,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30126",
            "title": "Filtro de salida 6\" 150X150 mm",
            "cantidad": 1,
            "precio_de_lista": 71225.6,
            "precio_de_lista2": 71225.6,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "51019",
            "title": "LAMPARA LED 9W 110VAC",
            "cantidad": 1,
            "precio_de_lista": 21600,
            "precio_de_lista2": 21600,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30109",
            "title": "EXTRACTOR 4\" CAUDAL 52-62 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
            "cantidad": 1,
            "precio_de_lista": 136919.7984,
            "precio_de_lista2": 136919.7984,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30110",
            "title": "REJILLA CON FILTRO 4\" IP54",
            "cantidad": 1,
            "precio_de_lista": 49693.2128,
            "precio_de_lista2": 49693.2128,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30115",
            "title": "EXTRACTOR 8\" CAUDAL 305-332 M3/H 220VAC (INCLUYE REJILLA, FILTRO Y ESFERA FILTRANTE)",
            "cantidad": 1,
            "precio_de_lista": 297510.752,
            "precio_de_lista2": 297510.752,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "30116",
            "title": "REJILLA CON FILTRO 8\" IP54",
            "cantidad": 1,
            "precio_de_lista": 87145.52,
            "precio_de_lista2": 87145.52,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59836",
            "title": "KIT DE CABLEADO DE CONTROL ILUMINACION CON MICROSWICHE",
            "cantidad": 1,
            "precio_de_lista": 137950.4275,
            "precio_de_lista2": 137950.4275,
            "alerta_mano_obra": 1.36
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59837",
            "title": "KIT DE CABLEADO DE CONTROL CALEFACCION CON TERMOSTATO",
            "cantidad": 1,
            "precio_de_lista": 279736.1914,
            "precio_de_lista2": 279736.1914,
            "alerta_mano_obra": 1.36
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59838",
            "title": "KIT DE CABLEADO DE CONTROL CALEFACCION CON HIGROSTATO",
            "cantidad": 1,
            "precio_de_lista": 389855.7024,
            "precio_de_lista2": 389855.7024,
            "alerta_mano_obra": 1.36
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59839",
            "title": "KIT DE CABLEADO DE CONTROL EXTRACTORES/VENTILADORES",
            "cantidad": 1,
            "precio_de_lista": 139265.7197,
            "precio_de_lista2": 139265.7197,
            "alerta_mano_obra": 1.2
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "4736",
            "title": "MINIBREAKER 2X6A 10KA 240VAC",
            "cantidad": 2,
            "precio_de_lista": 29558.784,
            "precio_de_lista2": 59117.568,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "5136",
            "title": "MINIBREAKER 2X6A 10 KA 220V",
            "cantidad": 2,
            "precio_de_lista": 41350.4,
            "precio_de_lista2": 82700.8,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 2,
        "equipo_selec": {
            "value": "6126",
            "title": "MINIBREAKER 2X6A, 10/6KA, 220/400VAC",
            "cantidad": 2,
            "precio_de_lista": 42862.4,
            "precio_de_lista2": 85724.8,
            "alerta_mano_obra": 0.45
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "25006",
            "title": "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
            "cantidad": 1,
            "precio_de_lista": 440000,
            "precio_de_lista2": 440000,
            "alerta_mano_obra": 0.37
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y ACCESORIOS TRANSFORMADOR",
            "cantidad": 1,
            "precio_de_lista": 64000,
            "precio_de_lista2": 64000,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "72",
            "title": "BREAKER 3X(44-63) A 85/35 KA 240/440V",
            "cantidad": 1,
            "precio_de_lista": 727902.08,
            "precio_de_lista2": 727902.08,
            "alerta_mano_obra": 0.1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "29756",
            "title": "TIPO 1+2, 3P 320 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
            "cantidad": 1,
            "precio_de_lista": 457775.616,
            "precio_de_lista2": 457775.616,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "29355",
            "title": "DPS Tipo I+II 12.5 KA 10/350, 65 KA 8/20 x polo 3P 277/480 VAC MODULAR. MODO COMUN. CON SEÑALIZACION",
            "cantidad": 1,
            "precio_de_lista": 3688057.6,
            "precio_de_lista2": 3688057.6,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "59842",
            "title": "CABLEADO DPS",
            "cantidad": 1,
            "precio_de_lista": 27200,
            "precio_de_lista2": 27200,
            "alerta_mano_obra": 1.73
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+N+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 2513440.394,
            "precio_de_lista2": 2513440.394,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "ITEM SIN CODIGO",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 4644352.138,
            "precio_de_lista2": 4644352.138,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CCM 460 VAC",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91029",
            "title": "T. EMPAQUE ESTIBA, GUACAL, CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 498559.05,
            "precio_de_lista2": 498559.05,
            "alerta_mano_obra": 0
        }
    }
]
    if (indexItem === 17 && parte === 2) //18
        data.equipos = [
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "69320",
            "title": "CELDA METAL CLAD EN MEDIA TENSION 2300X850X1330, CERTIFICADA BAJO IEC 62671-200, Icc 25 kA, Accesibilidad AFLR, 17,5 kV, hasta 1250 AMP.",
            "cantidad": 1,
            "precio_de_lista": 12239354.55,
            "precio_de_lista2": 12239354.55,
            "alerta_mano_obra": 57.5
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "4501",
            "title": "BREAKER MEDIA TENSIÓN FIJO EN VACIO. 17.5 KV, 630 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA Y MANDO MOTORIZADO)",
            "cantidad": 1,
            "precio_de_lista": 22952442.88,
            "precio_de_lista2": 22952442.88,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "4503",
            "title": "BREAKER MEDIA TENSIÓN FIJO EN VACIO. 17.5 KV, 1250 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA Y MANDO MOTORIZADO)",
            "cantidad": 1,
            "precio_de_lista": 32892614.08,
            "precio_de_lista2": 32892614.08,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "4502",
            "title": "BREAKER MEDIA TENSIÓN EXTRAIBLE EN VACIO. 17.5 KV, 630 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA, MANDO MOTORIZADO, CASETTE Y PALANCA DE EXTRACCIÓN)",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1.1
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "04526",
            "title": "FEMALE CONTACT 1 5 ",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "04527",
            "title": "AERO WIRING BOX ",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22193",
            "title": "RELE DE CORRIENTE Y TENSION UNIVERSAL CON ENTRADAS PARA LPCT Y LPVT Y COMUNICACIÓN RS485",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": "22188",
            "title": "TRANSFORMADOR CORRIENTE TOROIDAL LPCT",
            "cantidad": 3,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y MONTAJE DE RELE Y TRANSFORMADORES",
            "cantidad": 1,
            "precio_de_lista": 640000,
            "precio_de_lista2": 640000,
            "alerta_mano_obra": 10
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": null,
            "title": "TRANSFOMADORES DE CORRIENTE DE 40-80/5 17,5 KV INTERIOR ITER:8KA IDIN:20KA 5VA",
            "cantidad": 3,
            "precio_de_lista": 3520000,
            "precio_de_lista2": 10560000,
            "alerta_mano_obra": 5
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22243",
            "title": "Relé de protección corrientes. (48-230 Vac/ 24-220 Vdc). 50P, 50/51 N/G, 50/51 P, CLP Y 86. 1 ENTRADA Y UNA SALIDA",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22190",
            "title": "RELE DE CORRIENTE UNIVERSAL CON ENTRADA PARA TC´S",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22231",
            "title": "RELE CORRIENTE MT. PROTECCIONES DE CORRIENTE.",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 2.88
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y MONTAJE DE RELE Y TRANSFORMADORES",
            "cantidad": 1,
            "precio_de_lista": 640000,
            "precio_de_lista2": 640000,
            "alerta_mano_obra": 10
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": null,
            "title": "TRANSFOMADORES DE CORRIENTE DE 40-80/5 17,5 KV INTERIOR ITER:8KA IDIN:20KA 5VA",
            "cantidad": 3,
            "precio_de_lista": 2880000,
            "precio_de_lista2": 8640000,
            "alerta_mano_obra": 5
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": null,
            "title": "TRANSFOMADORES DE POTENCIAL 13200/120 V INTERIOR 25VA",
            "cantidad": 3,
            "precio_de_lista": 3520000,
            "precio_de_lista2": 10560000,
            "alerta_mano_obra": 5
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": "51205",
            "title": "FUSIBLE 24 KV 0.63 AMP",
            "cantidad": 3,
            "precio_de_lista": 1363200,
            "precio_de_lista2": 4089600,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 3,
        "equipo_selec": {
            "value": "51230",
            "title": "CLIPS PARA FUSIBLE",
            "cantidad": 3,
            "precio_de_lista": 73440,
            "precio_de_lista2": 220320,
            "alerta_mano_obra": 0.35
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22246",
            "title": "RELÉ DE PROTECCIÓN CORRIENTE, VOLTAJE Y FRECUENCIA EN MT ",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 2.5
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22192",
            "title": "RELE DE CORRIENTE Y TENSION UNIVERSAL CON ENTRADAS PARA TP´S Y TC´S Y COMUNICACIÓN RS485",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 0.29
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "22232",
            "title": "RELE CORRIENTE MT. PROTECCIONES DE CORRIENTE Y TENSIÓN. 8I/9O, 1 ZONE INTER, MODBUS",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 2.88
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "CABLEADO Y MONTAJE DE RELE Y TRANSFORMADORES",
            "cantidad": 1,
            "precio_de_lista": 960000,
            "precio_de_lista2": 960000,
            "alerta_mano_obra": 15
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "MIMICO ",
            "cantidad": 1,
            "precio_de_lista": 160000,
            "precio_de_lista2": 160000,
            "alerta_mano_obra": 2
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Barraje principal 3F+T. Según norma.",
            "cantidad": 1,
            "precio_de_lista": 2329585.091,
            "precio_de_lista2": 2329585.091,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "ITEM SIN CODIGO",
            "cantidad": 1,
            "precio_de_lista": 0,
            "precio_de_lista2": 0,
            "alerta_mano_obra": 1
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": null,
            "title": "Mano de obra Fabricación",
            "cantidad": 1,
            "precio_de_lista": 6947744.101,
            "precio_de_lista2": 6947744.101,
            "alerta_mano_obra": 0
        }
    },
    {
        "nombre_item": "CELDA DE MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
        "cantidad": 1,
        "equipo_selec": {
            "value": "91028",
            "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
            "cantidad": 1,
            "precio_de_lista": 196047.1,
            "precio_de_lista2": 196047.1,
            "alerta_mano_obra": 0
        }
    }
]
    if (indexItem === 18 && parte === 2)
        data.equipos = [
  {
    "nombre_item": "DOBLETIRO EN MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
    "cantidad": 2,
    "equipo_selec": {
      "value": 69320,
      "title": "CELDA METAL CLAD EN MEDIA TENSION 2300X850X1330, CERTIFICADA BAJO IEC 62671-200, Icc 25 kA, Accesibilidad AFLR, 17,5 kV, hasta 1250 AMP.",
      "cantidad": 2,
      "precio_de_lista": 12239354.55,
      "precio_de_lista2": 12239354.55,
      "alerta_mano_obra": 57.5
    }
  },
  {
    "nombre_item": "DOBLETIRO EN MEDIA TENSIÓN TIPO METAL CLAD CERTIFICADA BAJO IEC 62271-200, ICC 25 KA, ARCO INTERNO ALFR, 17,5KV",
    "cantidad": 2,
    "equipo_selec": {
      "value": null,
      "title": "COMPLEMENTO DUCTO DE ENTRADA E INSTALACION DE TP´S. 2300X850X400",
      "cantidad": 2,
      "precio_de_lista": 1120000,
      "precio_de_lista2": 1120000,
      "alerta_mano_obra": 15
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4501,
      "title": "BREAKER MEDIA TENSIÓN FIJO EN VACIO. 17.5 KV, 630 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA Y MANDO MOTORIZADO)",
      "cantidad": 2,
      "precio_de_lista": 22952442.88,
      "precio_de_lista2": 22952442.88,
      "alerta_mano_obra": 1.1
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4503,
      "title": "BREAKER MEDIA TENSIÓN FIJO EN VACIO. 17.5 KV, 1250 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA Y MANDO MOTORIZADO)",
      "cantidad": 2,
      "precio_de_lista": 32892614.08,
      "precio_de_lista2": 32892614.08,
      "alerta_mano_obra": 1.1
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4502,
      "title": "BREAKER MEDIA TENSIÓN EXTRAIBLE EN VACIO. 17.5 KV, 630 AMP, 25 KA, W-VACI. (INCLUYE BOBINA DE CIERRE, APERTURA, MANDO MOTORIZADO, CASETTE Y PALANCA DE EXTRACCIÓN)",
      "cantidad": 2,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 1.1
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4516,
      "title": "BOBINA DE MINIMA TENSIÓN 110-125VDC",
      "cantidad": 2,
      "precio_de_lista": 470758.72,
      "precio_de_lista2": 470758.72,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4526,
      "title": "FEMALE CONTACT 1 5",
      "cantidad": 2,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "EQUIPOS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 4527,
      "title": "AERO WIRING BOX",
      "cantidad": 2,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S SCHNEIDER",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22193,
      "title": "RELE DE CORRIENTE Y TENSION UNIVERSAL CON ENTRADAS PARA LPCT Y LPVT Y COMUNICACIÓN RS485",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S SCHNEIDER",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22188,
      "title": "TRANSFORMADOR CORRIENTE TOROIDAL LPCT",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 0.29
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S SCHNEIDER",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "CABLEADO Y MONTAJE DE RELE Y TRANSFORMADORES",
      "cantidad": 1,
      "precio_de_lista": 480000,
      "precio_de_lista2": 480000,
      "alerta_mano_obra": 10
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 3,
    "equipo_selec": {
      "value": null,
      "title": "TRANSFOMADORES DE CORRIENTE DE 40-80/5 17,5 KV INTERIOR ITER:8KA IDIN:20KA 5VA",
      "cantidad": 3,
      "precio_de_lista": 3520000,
      "precio_de_lista2": 3520000,
      "alerta_mano_obra": 5
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22243,
      "title": "Relé de protección corrientes. (48-230 Vac/ 24-220 Vdc). 50P, 50/51 N/G, 50/51 P, CLP Y 86. 1 ENTRADA Y UNA SALIDA",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22190,
      "title": "RELE DE CORRIENTE UNIVERSAL CON ENTRADA PARA TC´S",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 0.29
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22210,
      "title": "Relé de protección corrientes. (60-240 VAC/DC). PROTECIONES: 46BC, 46NPS, 49, 50, 50N/G, 51, 51N/G, 51C, 50BF, 51 SEF, 81 HBL2, 50SEF. 3 Entradas y 3 Salidas digitales (88VAC/DC). Puerto de comunicaciones Frontal USB y Serial RJ485 Opcional.",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22231,
      "title": "RELE CORRIENTE MT. PROTECCIONES DE CORRIENTE.",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 2.88
    }
  },
  {
    "nombre_item": "CON EQUIPOS DE PROTECCION CORRIENTE Y TC´S EN RESINA",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "CABLEADO Y MONTAJE DE RELE Y TRANSFORMADORES",
      "cantidad": 1,
      "precio_de_lista": 640000,
      "precio_de_lista2": 640000,
      "alerta_mano_obra": 10
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 6,
    "equipo_selec": {
      "value": null,
      "title": "TRANSFORMADORES DE POTENCIAL 13200/120 V INTERIOR 200VA",
      "cantidad": 6,
      "precio_de_lista": 3520000,
      "precio_de_lista2": 3520000,
      "alerta_mano_obra": 5
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 6,
    "equipo_selec": {
      "value": 51205,
      "title": "FUSIBLE 24 KV 0.63 AMP",
      "cantidad": 6,
      "precio_de_lista": 1363200,
      "precio_de_lista2": 1363200,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 6,
    "equipo_selec": {
      "value": 51230,
      "title": "CLIPS PARA FUSIBLE",
      "cantidad": 6,
      "precio_de_lista": 73440,
      "precio_de_lista2": 73440,
      "alerta_mano_obra": 0.35
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 6,
    "equipo_selec": {
      "value": 99053,
      "title": "PARARRAYOS DISTRIBUCION POLIM. 12KV 10KA",
      "cantidad": 6,
      "precio_de_lista": 291200,
      "precio_de_lista2": 291200,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22111,
      "title": "RELE DE TRANSFERENCIA AUTOMATICA, RED-RED Y RED - GENERADOR, 50-576AC, 1-3 FASES, DISPLAY GRAFICO 144X144 MM. CONTROL DE BAJO Y SOBRE VOLTAJE, PERDIDA DE FASE, ASIMETRIA, BAJA Y ALTA FRECUENCIA. RANGO DE ALIMENTACION AUXILIAR 90-260 VAC",
      "cantidad": 1,
      "precio_de_lista": 2609555.2,
      "precio_de_lista2": 2609555.2,
      "alerta_mano_obra": 1.73
    }
  },
  {
    "nombre_item": "EQUIPO DE MANIOBRA TRANSFERENCIA",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "CABLEADO Y MONTAJE DE TRANSFERENCIA",
      "cantidad": 1,
      "precio_de_lista": 1600000,
      "precio_de_lista2": 1600000,
      "alerta_mano_obra": 15
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 2,
    "equipo_selec": {
      "value": null,
      "title": "MIMICO",
      "cantidad": 2,
      "precio_de_lista": 160000,
      "precio_de_lista2": 160000,
      "alerta_mano_obra": 2
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "Barraje principal 3F+T. Según norma.",
      "cantidad": 1,
      "precio_de_lista": 7765283.635,
      "precio_de_lista2": 7765283.635,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "ITEM SIN CODIGO",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "Mano de obra Fabricación",
      "cantidad": 1,
      "precio_de_lista": 9921390.379,
      "precio_de_lista2": 9921390.379,
      "alerta_mano_obra": null
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 91028,
      "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
      "cantidad": 2,
      "precio_de_lista": 196047.1,
      "precio_de_lista2": 196047.1,
      "alerta_mano_obra": 0
    }
  }
]
    if (indexItem === 19 && parte === 2) //20
        data.equipos = [
  {
    "nombre_item": "GABINETE DE SINCRONISMO",
    "cantidad": 2,
    "equipo_selec": {
      "value": 73246,
      "title": "GABINETE FABRICADO EN LÁMINA COLD ROLLED CALIBRE 14 Y 16, 2000X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP44. TIPO GEA-C",
      "cantidad": 2,
      "precio_de_lista": 1428525.096,
      "precio_de_lista2": 1428525.096,
      "alerta_mano_obra": 26.22
    }
  },
  {
    "nombre_item": "GABINETE DE SINCRONISMO",
    "cantidad": 2,
    "equipo_selec": {
      "value": 73339,
      "title": "GABINETE FABRICADO EN LÁMINA GALVANIZADA CALIBRE 14 Y 16, 2200X800X800 mm. PINTURA ELECTROSTATICA RAL7035. IP56. TIPO GEA-C",
      "cantidad": 2,
      "precio_de_lista": 2131924.91,
      "precio_de_lista2": 2131924.91,
      "alerta_mano_obra": 26.22
    }
  },
  {
    "nombre_item": "GABINETE DE SINCRONISMO",
    "cantidad": 2,
    "equipo_selec": {
      "value": 72690,
      "title": "SOPORTE EN ANGULO INTERRUPTOR PARA TABLERO GEA",
      "cantidad": 2,
      "precio_de_lista": 74872.56,
      "precio_de_lista2": 74872.56,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "GABINETE DE SINCRONISMO",
    "cantidad": 2,
    "equipo_selec": {
      "value": 72689,
      "title": "CUBICULO DE MEDIDA PARA TABLERO GEA",
      "cantidad": 2,
      "precio_de_lista": 185841.9272,
      "precio_de_lista2": 185841.9272,
      "alerta_mano_obra": 2.3
    }
  },
  {
    "nombre_item": "GABINETE DE SINCRONISMO",
    "cantidad": 2,
    "equipo_selec": {
      "value": 69878,
      "title": "FRENTE MUERTO EN LÁMINA COLD ROLLED CALIBRE 16. PINTURA ELECTOSTATICA RAL7035. CON BISAGRAS TIPO MARIPOSA Y CHAPAS TIPO PIBOTE. 2000X800 MM",
      "cantidad": 2,
      "precio_de_lista": 356198.696,
      "precio_de_lista2": 356198.696,
      "alerta_mano_obra": 7.25
    }
  },
  {
    "nombre_item": "TOTALIZADOR SIEMENS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 2165,
      "title": "KIT DE TRANSFERENCIA 800-2000A CON INTERRUPTOR DE POTENCIA 3WT",
      "cantidad": 2,
      "precio_de_lista": 34785899.2,
      "precio_de_lista2": 34785899.2,
      "alerta_mano_obra": 5.05
    }
  },
  {
    "nombre_item": "TOTALIZADOR SIEMENS",
    "cantidad": 2,
    "equipo_selec": {
      "value": 1880,
      "title": "BOBINA DE MINIMA TENSIÓN 220-240VAC",
      "cantidad": 2,
      "precio_de_lista": 428624,
      "precio_de_lista2": 428624,
      "alerta_mano_obra": 0.17
    }
  },
  {
    "nombre_item": "TOTALIZADOR SCHNEIDER",
    "cantidad": 2,
    "equipo_selec": {
      "value": 227,
      "title": "BREAKER 3X(800-2000) A 65/65 KA 240/440V MICROLOGIC 2.0E FIJO",
      "cantidad": 2,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 1.1
    }
  },
  {
    "nombre_item": "TOTALIZADOR SCHNEIDER",
    "cantidad": 2,
    "equipo_selec": {
      "value": 509,
      "title": "ACCIONAMIENTO ELECTRICO POR MOTOR PARA MASTERPACT NW FIJO 220 VAC FIJO",
      "cantidad": 2,
      "precio_de_lista": 1216000,
      "precio_de_lista2": 1216000,
      "alerta_mano_obra": 0.17
    }
  },
  {
    "nombre_item": "TOTALIZADOR SCHNEIDER",
    "cantidad": 2,
    "equipo_selec": {
      "value": 519,
      "title": "BOBINA DE DISPARO POR EMISIÓN DE CORRIENTE (MX) 220 VAC/DC. INT. FIJO",
      "cantidad": 2,
      "precio_de_lista": 832000,
      "precio_de_lista2": 832000,
      "alerta_mano_obra": 0.17
    }
  },
  {
    "nombre_item": "TOTALIZADOR SCHNEIDER",
    "cantidad": 2,
    "equipo_selec": {
      "value": 524,
      "title": "BOBINA DE DISPARO POR SUBTENSIÓN (MN) 220 VAC/DC. INT. FIJO",
      "cantidad": 2,
      "precio_de_lista": 1039755.36,
      "precio_de_lista2": 1039755.36,
      "alerta_mano_obra": 0.17
    }
  },
  {
    "nombre_item": "TOTALIZADOR SCHNEIDER",
    "cantidad": 2,
    "equipo_selec": {
      "value": 529,
      "title": "BOBINA DE CIERRE (XF) 220 VAC/DC. INT. FIJO",
      "cantidad": 2,
      "precio_de_lista": 832000,
      "precio_de_lista2": 832000,
      "alerta_mano_obra": 0.17
    }
  },
  {
    "nombre_item": "TRANSFORMADORES",
    "cantidad": 6,
    "equipo_selec": {
      "value": 24326,
      "title": "TRANSFORMADOR DE CORRIENTE DE 2000/5A CL 0,5 BURDEN 15 VA.",
      "cantidad": 6,
      "precio_de_lista": 133597.696,
      "precio_de_lista2": 133597.696,
      "alerta_mano_obra": 0.29
    }
  },
  {
    "nombre_item": "CONTROL SINCRONISMO",
    "cantidad": 1,
    "equipo_selec": {
      "value": 22148,
      "title": "Genset Controller for Advanced PARALLELING APPLICATIONS",
      "cantidad": 1,
      "precio_de_lista": 14896000,
      "precio_de_lista2": 14896000,
      "alerta_mano_obra": 1.73
    }
  },
  {
    "nombre_item": "CONTROL SINCRONISMO",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "KIT CABLEADO DE CONTROL DE CONTROLADOR",
      "cantidad": 1,
      "precio_de_lista": 1550000,
      "precio_de_lista2": 1550000,
      "alerta_mano_obra": 12
    }
  },
  {
    "nombre_item": "ANALIZADOR DE REDES",
    "cantidad": 1,
    "equipo_selec": {
      "value": 23401,
      "title": "MEDIDOR MULTIFUNCIONAL, PANTALLA LCD. MEDIDAS DE VOLTAJE, CORRIENTE, POTENCIAS (ACTIVA, REACTIVA Y APARENTE), FACTOR DE POTENCIA, FRECUENCIA, ENERGIA ACTIVA Y REACTIVA. DIMENSIONES 96X96MM. COMUNICACIONES MODBUS-RTU RS485. ENTRADA DE 1-5AMP, 480VAC. AUX 100-240 VAC/DC",
      "cantidad": 1,
      "precio_de_lista": 465106.432,
      "precio_de_lista2": 465106.432,
      "alerta_mano_obra": 1.54
    }
  },
  {
    "nombre_item": "ANALIZADOR DE REDES",
    "cantidad": 1,
    "equipo_selec": {
      "value": 23464,
      "title": "MEDIDOR DE ENERGIA MULTIFUNCIONAL (I+V+FP+HZ+80-480 VAC)",
      "cantidad": 1,
      "precio_de_lista": 867968.64,
      "precio_de_lista2": 867968.64,
      "alerta_mano_obra": 1.54
    }
  },
  {
    "nombre_item": "ANALIZADOR DE REDES",
    "cantidad": 1,
    "equipo_selec": {
      "value": 23484,
      "title": "MEDIDOR DE ENERGIA BIDIRECCIONAL MULTIFUNCIONAL (CLASE 0.5S, MULTITARIFA, 35 ALARMAS, 2ED/2SD+2RELE, MAX Y MIN, THD/TDD, ARMONICO 31, MEMORIA 256 KB, V,I,FP,HZ,DEMANDA PRESENTE, PREDICTIVA Y MAX, kWh, kVARh, kW, kVA, kVAR)",
      "cantidad": 1,
      "precio_de_lista": 2864246.048,
      "precio_de_lista2": 2864246.048,
      "alerta_mano_obra": 1.54
    }
  },
  {
    "nombre_item": "ANALIZADOR DE REDES",
    "cantidad": 3,
    "equipo_selec": {
      "value": 24322,
      "title": "TRANSFORMADOR DE CORRIENTE DE 600/5 A CL 0,5 BURDEN 5VA.",
      "cantidad": 3,
      "precio_de_lista": 64594.944,
      "precio_de_lista2": 64594.944,
      "alerta_mano_obra": 0.29
    }
  },
  {
    "nombre_item": "ANALIZADOR DE REDES",
    "cantidad": 1,
    "equipo_selec": {
      "value": 59818,
      "title": "KIT DE CABLEADO DE CONTROL ANALIZADOR DE REDES 220VAC",
      "cantidad": 1,
      "precio_de_lista": 393150.7872,
      "precio_de_lista2": 393150.7872,
      "alerta_mano_obra": 5.75
    }
  },
  {
    "nombre_item": "TRANSFORMADOR DE CONTROL",
    "cantidad": 2,
    "equipo_selec": {
      "value": 25006,
      "title": "TRANSFORMADOR DE CONTROL 480-460-440/220-110 V 300 VA",
      "cantidad": 2,
      "precio_de_lista": 440000,
      "precio_de_lista2": 440000,
      "alerta_mano_obra": 0.37
    }
  },
  {
    "nombre_item": "TRANSFORMADOR DE CONTROL",
    "cantidad": 2,
    "equipo_selec": {
      "value": null,
      "title": "CABLEADO Y ACCESORIOS TRANSFORMADOR",
      "cantidad": 2,
      "precio_de_lista": 93000,
      "precio_de_lista2": 93000,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "DPS",
    "cantidad": 1,
    "equipo_selec": {
      "value": 87722,
      "title": "BREAKER 3X(100)A 30/20KA 220/440VAC",
      "cantidad": 1,
      "precio_de_lista": 151890.432,
      "precio_de_lista2": 151890.432,
      "alerta_mano_obra": 0.1
    }
  },
  {
    "nombre_item": "DPS",
    "cantidad": 1,
    "equipo_selec": {
      "value": 12,
      "title": "BREAKER 3X60A 25/12,5 KA 240/440V",
      "cantidad": 1,
      "precio_de_lista": 265360,
      "precio_de_lista2": 265360,
      "alerta_mano_obra": 0.1
    }
  },
  {
    "nombre_item": "DPS",
    "cantidad": 1,
    "equipo_selec": {
      "value": 29752,
      "title": "TIPO 1+2, 3P 150 VAC. 12.5 kA (10/350), 65kA (8/20) X POLO. INCLUYE CONTACTO DE ESTADO.",
      "cantidad": 1,
      "precio_de_lista": 457775.616,
      "precio_de_lista2": 457775.616,
      "alerta_mano_obra": 1.73
    }
  },
  {
    "nombre_item": "DPS",
    "cantidad": 1,
    "equipo_selec": {
      "value": 59842,
      "title": "CABLEADO DPS",
      "cantidad": 1,
      "precio_de_lista": 27200,
      "precio_de_lista2": 27200,
      "alerta_mano_obra": 1.73
    }
  },
  {
    "nombre_item": "ACOMPAÑAMIENTO Y PUESTA EN MARCHA",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "DIA DE INGENIERO ESPECIALISTA EN SINCRONISMO INCLUYE SERVICIO DE PROGRAMACION Y PUESTA EN MARCHA (NO INCLUYE ALIMENTACION , HOSPEDAJE, TIQUETES )",
      "cantidad": 1,
      "precio_de_lista": 3875000,
      "precio_de_lista2": 3875000,
      "alerta_mano_obra": 1
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "Barraje principal 3F+N+T. Según norma.",
      "cantidad": 1,
      "precio_de_lista": 14631139.34,
      "precio_de_lista2": 14631139.34,
      "alerta_mano_obra": 0
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "ITEM SIN CODIGO",
      "cantidad": 1,
      "precio_de_lista": 0,
      "precio_de_lista2": 0,
      "alerta_mano_obra": 10
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": null,
      "title": "Mano de obra Fabricación",
      "cantidad": 1,
      "precio_de_lista": 6886425.871,
      "precio_de_lista2": 6886425.871,
      "alerta_mano_obra": 0
    }
  },
  {
    "nombre_item": "OTROS",
    "cantidad": 1,
    "equipo_selec": {
      "value": 91028,
      "title": "T. EMPAQUE ESTIBA, CARTON Y STRECH",
      "cantidad": 1,
      "precio_de_lista": 196047.1,
      "precio_de_lista2": 196047.1,
      "alerta_mano_obra": 0
    }
  }
]
// num de equipos por item = 8,15,   ....3,
}


export function rellenarDemoOfertaSuper(form,parte = 1) {
    const inicial = parte === 1 ? 0 : 10
    const final = parte === 1 ? 10 : 20
    for (let i = inicial; i < final; i++) {
        form.daItems.push({nombre_item: ' ' + (i + 1), equipo_selec: null, cantidad: 1});
    }

    const valueRAn = Math.floor(Math.random() * 9 + 10)

    form.dataOferta.descripcion = 'nombre genenerico ' + valueRAn;
    form.dataOferta.empresa = 'empresa genenerico ' + valueRAn;
    form.dataOferta.ciudad = 'Medellin ' + valueRAn;
    form.dataOferta.proyecto = 'proyecto genenerico ' + valueRAn;
    console.log("🚀 ~ rellenarDemoOferta ~ form: ", form);

    // Si en el futuro quieres añadir más campos, hazlo aquí centralizadamente.
}
