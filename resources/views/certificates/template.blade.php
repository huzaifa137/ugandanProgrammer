<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .certificate {
            border: 10px solid #4a90e2;
            padding: 50px;
        }

        h1 {
            font-size: 3rem;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This certifies that</p>
        <h2>{{ $user->name }}</h2>
        <p>has successfully completed the course:</p>
        <h3>{{ $course->title }}</h3>
        <p>Date: {{ now()->format('F j, Y') }}</p>
    </div>
</body>

</html>
