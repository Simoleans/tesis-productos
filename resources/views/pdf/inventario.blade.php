<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Productos</title>
    <style>
        table {
            border-collapse: collapse; /* Elimina el espacio entre bordes */
            width: 100%; /* Ancho completo */
        }

        th, td {
            border: 1px solid #ccc; /* Borde de 1px gris claro */
            padding: 8px; /* Espacio interior de las celdas */
            text-align: left; /* Alineación de texto a la izquierda */
        }

        th {
            background-color: #f2f2f2; /* Color de fondo del encabezado */
            font-weight: bold; /* Texto en negrita */
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Usuario</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $s)
                <tr>
                    <td>{{ $s->product->name }}</td>
                    <td>{{ $s->type == 1 ? 'Entrada' : 'Salida' }}</td>
                    <td>{{ $s->user->name }}</td>
                    <td>{{ $s->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
