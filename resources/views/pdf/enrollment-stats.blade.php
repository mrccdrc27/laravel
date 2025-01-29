<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Statistics</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Enrollment Statistics for Faculty</h2>
    <table>
        <thead>
            <tr>
                <th>Course Title</th>
                <th>Male</th>
                <th>Female</th>
                <th>Total Enrollment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->title }}</td>
                    <td>{{ $enrollment->male }}</td>
                    <td>{{ $enrollment->female }}</td>
                    <td>{{ $enrollment->totalEnrollment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
