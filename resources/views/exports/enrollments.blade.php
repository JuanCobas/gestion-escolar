<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Inscripciones</title>
</head>
<body>
    @foreach ($enrollments as $studentName => $studentEnrollments)
        <h3>{{ $studentName }}</h3>
        <table border="1">
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
                @foreach ($studentEnrollments as $enrollment)
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
        <br>
    @endforeach
</body>
</html>