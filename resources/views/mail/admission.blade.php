<!-- resources/views/emails/admission.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Confirmation</title>
</head>
<body>
    <h1 style="color: blue">Welcome, {{ $student->firstname }} {{ $student->lastname }}!</h1>
    <p>We are pleased to inform you that you have been admitted to the {{ $student->course->name }} course.</p>
    <p>Here are your details:</p>
    <img src="{{$student->getImageURL()}}" alt="" height="70" width="70">
    <ul>
        <li><strong>Student ID:</strong> {{ $student->student_id }}</li>
        <li><strong>Email:</strong> {{ $student->email }}</li>
        <li><strong>Date of Birth:</strong> {{ $student->dob }}</li>
    </ul>
    <p>We look forward to your participation in our courses.</p>
</body>
</html>
