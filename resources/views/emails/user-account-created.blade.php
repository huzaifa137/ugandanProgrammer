<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Acoount has been created</title>
</head>
<body>
    
    <p>Dear {{$firstname}} {{$lastname}},</p>

    <p>We are thrilled to inform you that your account has been successfully created on our platform! Welcome aboard!</p>
    <p><strong>Account Details</strong></p>
    <ol>
        <li>Firstname : {{$firstname}}</li>
        <li>Lastname  : {{$lastname}}</li>
        <li>username  : {{$username}}</li>
        <li>Email     : {{$email}}</li>
        <li>passsword : {{$password}}</li>
    </ol>

    <p>With your new account, you now have access to a plethora of exciting features and resources designed to enhance your experience with us. Whether you're here to explore our products, connect with like-minded individuals, or access exclusive content, we're confident you'll find everything you need to make the most out of your time here.</p>

    <p>Here are a few key points to get you started:</p>
</body>
</html>