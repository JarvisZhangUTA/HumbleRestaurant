<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Humble Restaurants</title>

    <style type="text/css">
        button{
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
            border-radius: 6px;
            margin-top: 20px;
        }
        .jumbotron {
            padding: 30px;
            margin: 30px;
            color: inherit;
            background-color: #eee;
        }
        .jumbotron h1 {
            color: inherit;
        }
        .jumbotron p {
            margin-bottom: 15px;
            font-size: 21px;
            font-weight: 200;
        }
    </style>
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>Hello!</h1>
            <p>
                You got an invitation to join the Humble Restaurants!
                Click the following link to sign up an account.
            </p>
            hrs.jarviszhang.com/restaurantSignPage.{{ $code }}
        </div>
    </div>
</body>
</html>
