<!DOCTYPE html>
<html>
<head>
    <title>Email Confirmation</title>
</head>
<body>   
    <h3>Your data has been stored successfully.</h3>
    <h3>Your Details shown here:</h3>
    <ul>
        <li><strong>Name:</strong> {{ $requestDetails->name }}</li>
        <li><strong>Email:</strong> {{ $requestDetails->email }}</li>
        <li><strong>Phone:</strong> {{ $requestDetails->phone }}</li>
        <li><strong>Business:</strong> {{ $requestDetails->business }}</li>
    </ul>
</body>
</html>
