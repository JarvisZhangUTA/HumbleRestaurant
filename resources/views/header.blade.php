<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Humble Restaurants</title>

        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Humble Restaurants</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                        <li><a href="/getDonationRankPage">Donation</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        @if(!isset($_SESSION['role']))
                            <li><a href="/loginPage">Login</a></li>
                        @else
                            <li><a href="/profileUserPage">{{$_SESSION['email']}}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" style="padding-top: 90px;">
            @yield('content')
        </div>
    </body>
</html>
