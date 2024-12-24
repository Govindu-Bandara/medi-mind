<!DOCTYPE html>
<html>
<head>
    <title>Medicine Added to Medi Mind</title>
</head>
<body>
    <h1>Medicine Added to Medi Mind</h1>
    <p>Hello,</p>
    <p>Your medicine has been successfully added to the Medi Mind system.</p>
    <p><strong>Medicine Name:</strong> {{ $medicineName }}</p>
    <p><strong>Dosage:</strong> {{ $dosage }}</p>
    <p><strong>Times:</strong> {{ implode(', ', $times->pluck('time')->toArray()) }}</p>
    <p>Thank you for using Medi Mind!</p>
</body>
</html>
