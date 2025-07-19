<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $oferta->codigo_oferta }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-family: sans-serif;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background-color: rgba(227, 233, 255, 0.49);
            color: #090000;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .col-linea {
            width: 8%;
        }

        .col-descripcion {
            width: 35%;
        }

        .col-tipo {
            width: 10%;
        }

        .col-referencia {
            width: 15%;
        }

        .col-marca {
            width: 15%;
        }

        .col-unidad {
            width: 10%;
        }

        .col-cantidad {
            width: 10%;
        }

        .header-container {
            text-align: center;
            margin-bottom: 15px;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .header-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 10px;
        }

        .header-logos img {
            height: 60px;
            object-fit: contain;
        }

        .header-text {
            font-size: 12px;
            color: #333;
            font-weight: 500;
            line-height: 1.4;
            margin: 10px auto;
            max-width: 90%;
        }
    </style>


</head>
<body>
<div style="text-align: center;">


    <div class="header-container">
        <div class="header-logos">
            <img src="{{ public_path('demco-logo-ultimo.png') }}" alt="Logo DEMCO">
            <img src="{{ public_path('madeincolombia.png') }}" alt="Hecho en Colombia">
        </div>

    </div>
    <h2>Cotización</h2>
    <h3 style="color: red;">{{ $oferta->codigo_oferta }}</h3>
</div>

<table>
    <tr>
        <th>Cliente</th>
        <td>{{ $user->name }}</td>
    </tr>
    <tr>
        <th>Cargo</th>
        <td>{{ $user->cargo }}</td>
    </tr>
    <tr>
        <th>Empresa</th>
        <td>{{ $oferta->empresa }}</td>
    </tr>
    <tr>
        <th>Ciudad</th>
        <td>{{ $oferta->ciudad }}</td>
    </tr>
    <tr>
        <th>Proyecto</th>
        <td>{{ $oferta->proyecto }}</td>
    </tr>
    <tr>
        <th>Fecha</th>
        <td>{{ \Carbon\Carbon::parse($oferta->fecha)->format('d/m/Y') }}</td>
    </tr>
</table>

<p class="header-text">
    DEMCO INGENIERÍA, es una empresa dinámica dedicada al diseño, construcción y puesta en servicio de
    subestaciones y tableros eléctricos en media y baja tensión, desarrollando proyectos con altas
    especificaciones en ingeniería, en alianza con reconocidas empresas.
</p>

@foreach ($oferta->items as $index => $item)
    <h4> {{ $index + 1 }} : {{$item->nombre}}</h4>
    <table>
        <thead>
        <tr>
            <th class="col-linea">Línea</th>
            <th class="col-descripcion">Descripción</th>
            <th class="col-tipo">Tipo</th>
            <th class="col-referencia">Referencia</th>
            <th class="col-marca">Marca</th>
            <th class="col-unidad">Unidad</th>
            <th class="col-cantidad">Cant</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($item->equipos as $linea => $equipo)
            <tr>
                <td>{{ $linea + 1 }}</td>
                <td>{{ $equipo->descripcion }}</td>
                <td>{{ $equipo->tipo_fabricante }}</td>
                <td>{{ $equipo->referencia_fabricante }}</td>
                <td>{{ $equipo->marca }}</td>
                <td>{{ $equipo->unidad_de_compra }}</td>
                <td>{{ $equipo->cantidadpdf }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p><strong>Valor Unitario Item:</strong> ${{ number_format($item->valor_unitario_item, 0, ',', '.') }}
    <p><strong>Valor Total Item:</strong>
        ${{ number_format(($item->valor_total_item), 0, ',', '.') }}
    </p>
@endforeach

</div>

<div style="page-break-inside: avoid;">
    <h3 style="text-align: center;">Resumen de Oferta</h3>
    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th colspan="3">Nombre</th>
            <th colspan="1">Cantidad</th>
            <th colspan="3">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($oferta->items as $i => $item)
            <tr>
                <td> {{ $i + 1 }} </td>
                <td colspan="3"> {{ $item->nombre ?? 'SIN NOMBRE' }} </td>
                <td colspan="1"> {{ $item->cantidad }} </td>
                <td colspan="3"> ${{ number_format($item->valor_total_item, 0, ',', '.') }} </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5"><strong>Total Oferta Antes de IVA</strong></td>
            <td colspan="3"><strong>${{ number_format($totalOferta, 0, ',', '.') }}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
