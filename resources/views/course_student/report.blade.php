<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Inscripciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-header {
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Informe de Inscripciones</h2>
    </div>

    @foreach ($enrollmentsGrouped as $studentName => $enrollments)
        
        <div class="student-header">{{ $studentName }}</div>

        
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Curso</th>
                    <th>Comisión</th>
                    <th>Aula</th>
                    <th>Horario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->subject_name }}</td>
                        <td>{{ $enrollment->course_name }}</td>
                        <td>{{ $enrollment->commission_name }}</td>
                        <td>{{ $enrollment->aula }}</td>
                        <td>{{ $enrollment->horario }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>