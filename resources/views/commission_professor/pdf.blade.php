<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Comisiones y Profesores</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Informe de Comisiones y Profesores</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Comisión</th>
                <th>Curso</th>
                <th>Materia</th>
                <th>Hora</th>
                <th>Aula</th>
                <th>Profesores</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->id }}</td>
                    <td>{{ $assignment->name }}</td>
                    <td>{{ $assignment->course->name ?? 'No asignado' }}</td>
                    <td>{{ $assignment->course->subject->name ?? 'No asignado' }}</td>
                    <td>{{ $assignment->horario ?? 'No asignado' }}</td>
                    <td>{{ $assignment->aula ?? 'No asignada' }}</td>
                    <td>{{ $assignment->professors->pluck('name')->join(', ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>