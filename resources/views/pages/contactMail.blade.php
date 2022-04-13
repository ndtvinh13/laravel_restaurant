<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Mail</title>
</head>
<body>

    <div>
        <div>You received an email from : <b>{{$name}}<b></div>
        <br>
        
        <div><em><u>Name</u></em>  {{$name}}</div>
        <div><em><u>Email</u></em>:  {{$email}}</div>
        <div><em><u>Subject</u></em>:  {{$subject}}</div>
        <br>
        <div><em><u>Message</u></em>:  {{$info}}<br><br></div>
    </div>

</body>
</html>