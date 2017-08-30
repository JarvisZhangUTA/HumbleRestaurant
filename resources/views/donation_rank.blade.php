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
                <li><a href="/">Home</a></li>
                <li class="active"><a href="/getDonationRankPage">Donation</a></li>
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

    <div class="row">
        <div class="col-md-3">
            <h3>Numbers</h3>
            <br>
            <table>
                <tr>
                    <td style="padding:0 30px 10px 0;"><span style="font-style: italic; color: #5e5e5e;">Totally payments</span></td>
                    <td style="padding:0 10px 10px 0;"><span style="color: #5e5e5e;">${{$payment}}</span></td>
                </tr>
                <tr>
                    <td style="padding:0 30px 10px 0;"><span style="font-style: italic; color: #5e5e5e;">Donations</span></td>
                    <td style="padding:0 10px 10px 0;"><span style="color: #5e5e5e;">${{$donation}}</span></td>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            <h3>Restaurants</h3>
            <br>
            @for($i = 1; $i <= sizeof($restaurants); $i++)
                <div style="padding: 10px 0;">
                    @if($i < 5)
                        <img class="pull-left" style="width: 18px; height: 18px;" src="img/rank{{$i}}.png">
                    @else
                        <div class="pull-left" style="text-align:center; vertical-align: middle;
                            width: 18px; height: 18px;">{{$i}}</div>
                    @endif

                <a style="margin-left: 20px;" href="/restaurant.{{$restaurants[$i-1]->id}}" >{{$restaurants[$i-1]->name}}</a>
                <div class="pull-right">${{$restaurants[$i-1]->donation}}</div>
                </div>
            @endfor
        </div>
        <div class="col-md-4">
            <h3>Contributors</h3>
            <br>
            @for($i = 1; $i <= sizeof($users); $i++)
                <div style="padding: 10px 0;">
                @if($i < 5)
                    <img class="pull-left" style="width: 18px; height: 18px;" src="img/rank{{$i}}.png">
                @else
                    <div class="pull-left" style="text-align:center; vertical-align: middle; width: 18px; height: 18px;">
                        {{$i}}
                    </div>
                @endif
                <a style="margin-left: 20px;" >{{$users[$i-1]->name}}</a>
                <div class="pull-right">${{$users[$i-1]->donation}}</div>
                </div>
            @endfor
        </div>
    </div>
</div>
</body>
</html>
