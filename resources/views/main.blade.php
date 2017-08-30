<?php $type = ['','danger','warning','info','primary','success'];?>
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

    <header class="intro-header" >
        <div class="container">
            <div class="intro-message">
                <h1><b>Humble Restaurants</b></h1>
                <h4><b>2250</b> restaurants and <b>898,126</b> donations</h4>

                <hr class="intro-divider">
                <br>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="input-group input-group-lg">
                            <div class="form-control" style="padding: 0;">
                                <label for="input_search_name" style="margin: 10px;" class="pull-left">Find</label>
                                <input style="margin-top: 10px; width: 40%;"
                                       id="input_search_name"
                                       placeholder="Restaurant Name"
                                       type="text" class="input_trans pull-left">
                                <div style="width: 1px; height: 70%;
                                        margin: 5px;
                                        background-color: #9d9d9d;"
                                     class="pull-left"></div>

                                <label for="input_search_loc" style="margin: 10px;" class="pull-left">
                                    Near
                                </label>

                                <input style="margin-top: 10px; width: 30%;"
                                       placeholder="Location"

                                       id="input_search_loc" type="text" class="input_trans pull-left">
                                <datalist id="browsers">
                                    <option value="Current Location">
                                </datalist>
                            </div>
                            <span class="input-group-btn">
                                <button id="btn_search" class="btn btn-default" type="button">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="margin-top: 80px;">
        <input id="pages" value="{{$pages}}" type="hidden">

        <div class="center-block" style="width: 400px; text-align: center;">
            <h3 style="font-style: italic; color: #5e5e5e;">Welcome to our restaurants</h3>
            <hr>
            <p>We got some results for you</p>
        </div>

        <div class="row" style="margin-top: 60px;">
            <div id="card-columns" class="card-columns">
                @foreach ($restaurants as $restaurant)
                    <div class="card">
                        @if($restaurant->url == '')
                            <img class="card-img-top" style="width: 100%;" alt="{{$restaurant->name}}" src="/img/restaurant_default.jpg">
                        @else
                            <img class="card-img-top" style="width: 100%;" src="{{$restaurant->url}}" alt="{{$restaurant->name}}">
                        @endif

                        <div class="card-block">
                            <h4 class="card-title">{{ $restaurant->name }}</h4>
                            <hr>
                            <div class="card-subtitle btn-group" style="margin-bottom: 10px;">
                                @for($i = 1; $i < 6; $i++)
                                    @if($restaurant->rating >= $i)
                                        <button type="button" class="btn btn-{{$type[$restaurant->rating]}} btn-xs" aria-label="Left Align">
                                            <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                @endfor
                            </div>
                            <p class="card-text" style="max-height: 80px; overflow: hidden;">
                            {{ $restaurant->summary }}
                            </p>
                            <div style="height: 20px;">
                                <a href="/restaurant.{{$restaurant->id}}" class="pull-right btn-xs btn-default">View more</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>


        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjgTs-FAYqJqYXcm1Jjmzqp5xjsHq8eFM">
        </script>
    </div>


    <div class="footer text-center" style="margin-top: 40px; padding: 20px; background-color: #0f0f0f;">
            <p style="color: white;">Copyright © Humble Restaurants 2017</p>
    </div>
</body>
</html>

