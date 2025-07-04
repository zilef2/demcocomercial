/*
    *** MENU of global.ts ***
-- this Project

 --DATE functions
 DiferenciaMinutos
 IsDate_GOES_formatDate
 formatToVue
 formatDate
 monthName
 TransformTdate

 --MATH  functions

 number_format
 CalcularEdad
 CalcularSexo
 CalcularAvg

 --STRING FUNCTIONS

 sinTildes
 NoUnderLines
 ReemplazarTildes
 PrimerosCaracteres
 PrimerasPalabras
 textoSinEspaciosLargos

 --ARRAY

 vectorSelect
*/

import {toInteger} from "lodash";

//<editor-fold desc="This Project">
// this Project
export function LookForValueInArray(arrayOfObjects: Object[], searchValue): String {
    if (arrayOfObjects === null) return null
    //ex: { title: '123', value: 1 },
    let foundObject = '';
    if (typeof searchValue == 'string') {
        for (const obj of arrayOfObjects) {
            if (obj['title'] === searchValue) {
                console.log("🧈 " + obj['value'] + " searchValue:", searchValue);
                foundObject = obj['value'];
                break;
            }
        }
    } else {
        for (const obj of arrayOfObjects) {
            if (obj['title'] === searchValue['title']) {
                foundObject = obj['value'];
                break;
            }
        }
    }

    return foundObject;
}

export function popObj(obj) {
    let keys = Object.keys(obj).map(Number);
    let lastKey = Math.max(...keys);
    delete obj[lastKey];
    return obj;
}
export function pushObj(obj, value) {
  let keys = Object.keys(obj).map(Number);
  let nextKey = keys.length ? Math.max(...keys) + 1 : 0;
  obj[nextKey] = value;
  return obj;
}

// end this Project
//</editor-fold>


// DATE functions

//maded by gpt 3.5
export function DiferenciaMinutos(hora1: string, hora2: string): number {
    // Convertir las horas a objetos Date
    const date1: Date = new Date(`2000-01-01T${hora1}`);
    const date2: Date = new Date(`2000-01-01T${hora2}`);

    // Obtener la representación numérica de las horas (en milisegundos)
    const time1: number = date1.getTime();

    const time2: number = date2.getTime();
    console.log(time1)
    console.log('lostimes')
    console.log(time2)

    // Obtener la diferencia en milisegundos y convertirla a minutos
    const diferenciaMs: number = (time1 - time2);
    // const diferenciaMs:number = Math.abs(time1 - time2);
    return Math.floor(diferenciaMs / (1000 * 60));
}

export function IsDate_GOES_formatDate(text: string): String {
    const [day, month, year] = text.split('/').map(Number);
    let date = new Date(year, month - 1, day);
    let Ndate = toInteger(date)
    const ANumber = !isNaN(Ndate);

    if (!(ANumber)) {
        return "No es una fecha";
        // throw new Error("El texto no es una fecha válida");
    }

    return formatToVue(date);
}

export function formatToVue(date): String {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}

export function formatDate(date, isDateTime: string): string {
    if (date === '' || date === null || date === undefined) return '';
    let validDate = new Date(date)
    validDate = new Date(validDate.getTime() + (5 * 60 * 60 * 1000)) //correccion con GTM -5
    // console.log("🧈 debu validDate:", validDate);
    const day = validDate.getDate().toString().padStart(2, "0");
    // getMonthName(1)); // January
    const month = monthName((validDate.getMonth() + 1).toString().padStart(2, "0"));
    let year = validDate.getFullYear();
    let anioActual = new Date().getFullYear();
    if (isDateTime == 'conLaHora') {

        let hora = validDate.getHours();
        const AMPM = hora >= 12 ? ' PM' : ' AM';
        hora = hora % 12 || 12;
        let hourAndtime = hora + ':' + (validDate.getMinutes() < 10 ? '0' : '') + validDate.getMinutes() + AMPM;
        if (anioActual == year) {
            return `${day}-${month} | ${hourAndtime}`;
        } else {
            let Stringyear = year.toString().slice(-2);
            return `${day}-${month}-${Stringyear} | ${hourAndtime}`;
        }
    } else {
        if (anioActual == year) {
            return `${day}-${month}`;
        } else {
            let Stringyear = year.toString().slice(-2);
            return `${day}-${month}-${Stringyear}`;
        }
    }
}

export function TimeTo12Format(timeString) {
    if (timeString === null) return '';
    const [hours, minutes, seconds] = timeString.split(':');

    // Convert the time to 12-hour format and add 'am' or 'pm'
    const timeIn12HourFormat = new Date(2023, 7, 5, parseInt(hours), parseInt(minutes)).toLocaleString('es-CO', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true,
    });
    return timeIn12HourFormat;
}

export function formatTime(date): string {
    let validDate
    if (date) {
        validDate = new Date(date)
    } else {
        validDate = new Date()
    }
    // validDate = new Date(validDate.getTime() + (5 * 60 * 60 * 1000))

    let hora = validDate.getHours();
    let hourAndtime = (hora < 10 ? '0' : '') + hora + ':' + (validDate.getMinutes() < 10 ? '0' : '') + validDate.getMinutes() + ':00';

    return `${hourAndtime}`;
}


export function monthName(monthNumber) {
    if (monthNumber == 1) return 'Enero';
    if (monthNumber == 2) return 'Febrero';
    if (monthNumber == 3) return 'Marzo';
    if (monthNumber == 4) return 'Abril';
    if (monthNumber == 5) return 'Mayo';
    if (monthNumber == 6) return 'Junio';
    if (monthNumber == 7) return 'Julio';
    if (monthNumber == 8) return 'Agosto';
    if (monthNumber == 9) return 'Septiembre';
    if (monthNumber == 10) return 'Octubre';
    if (monthNumber == 11) return 'Noviembre';
    if (monthNumber == 12) return 'Diciembre';
}

export function TransformTdate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = ('0' + (date.getMonth() + 1)).slice(-2);
    const day = ('0' + date.getDate()).slice(-2);
    const hours = ('0' + date.getHours()).slice(-2);
    const minutes = ('0' + date.getMinutes()).slice(-2);
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

// fin DATE functions


// MATH  functions
export function CalcularAvg(TheArray, NameValue = '', isTime = false) {
    let sum: number
    sum = 0
    if (NameValue === '') {
        TheArray.forEach((value, index, array) => {
            sum += parseFloat(value);
        })
    } else {
        if (isTime) { //time like: 14:18

            TheArray.forEach((value, index, array) => {
                let justHour = value[NameValue].split(':')[0];
                justHour = parseInt(justHour);
                sum += justHour;
            })
        } else {
            TheArray.forEach((value, index, array) => {
                let val = value[NameValue].replace(',', '.')
                sum += parseFloat(val);
            })
        }
    }
    let NewSum = sum / TheArray.length
    const result = number_format(NewSum, 1, false);
    return result;
}

export function number_format(amount, decimals, isPesos: boolean) {
    amount += '';
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
    decimals = decimals || 0;

    if (isNaN(amount) || amount === 0)
        return parseFloat("0").toFixed(decimals);
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split(' '),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    if (isPesos)
        return '$' + amount_parts.join(' ');
    return amount_parts.join(' ');
}

export function formatPesosCol(number): string {
    number = Math.round(number);
    const formattedNumber = number.toLocaleString('en-US', {
        minimumFractionDigits: 0, // Mínimo de dígitos decimales (en este caso, 0)
        maximumFractionDigits: 0 // Máximo de dígitos decimales (en este caso, 0)
    });

    // Reemplazar la coma por un punto como separador decimal
    return '$ ' + formattedNumber;
    // return '$ ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "'");
}

export function CalcularEdad(nacimiento) {
    const anioHoy = new Date().getFullYear();
    const anioNacimiento = new Date(nacimiento).getFullYear();
    return anioHoy - anioNacimiento;
}

export function CalcularSexo(value) {
    return value == 0 ? 'Masculino' : 'Femenino'
}


//STRING FUNCTIONS
export function sinTildes(value) {
    let pattern = /[^a-zA-Z0-9\s]/g;
    let replacement = '';
    let result = value.replace(pattern, replacement);
    return result
}

export function NoUnderLines(value) {
    return value.replace(/[^a-zA-Z0-9]/g, ' ');
}


export function ReemplazarTildes(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

export function PrimerosCaracteres(texto, caracteres = 15) {
    if (texto) {

        if (texto.length > caracteres + 5) {

            const primeros = texto.substring(0, caracteres);
            return primeros + '...';
        }
        return texto
    }
}

export function PrimerasPalabras(texto, palabras = 10) {
    if (texto) {
        const firstWords = texto.split(" ");
        if (firstWords.length > palabras) {
            const primeros = firstWords.slice(0, palabras).join(" ");
            return primeros + '...';
        }
        return texto
    }
}

export function textoSinEspaciosLargos(texto) {
    return texto.replace(/\s+/g, ' ');
}


//array functions
export function vectorSelect(vectorSelect, propsVector, genero = 'uno') {
    vectorSelect = propsVector.map(
        generico => (
            {label: generico.nombre, value: generico.id}
        )
    )
    vectorSelect.unshift({label: 'Seleccione ' + genero, value: 0})
    return vectorSelect;
}

/*
watch(() => form.tipoRes, (newX) => {
    data.selectedPrompID = 'Selecciona un promp'
})
*/
