<?php $type = ['','danger','warning','info','primary','success']; $index=0;?>
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

            <div class="navbar-form navbar-left">
                <div style="margin-top: 3px;" class="input-group input-group-sm">
                    <div class="form-control" style="padding: 0;">
                        <label for="input_search_name" style="margin: 5px;" class="pull-left">Find</label>
                        <input style="margin-top: 4px; width: 40%;"
                               id="input_search_name"
                               placeholder="Restaurant Name"
                               type="text" class="input_trans pull-left">
                        <div style="width: 1px; height: 70%;
                                            margin: 5px;
                                            background-color: #9d9d9d;"
                             class="pull-left"></div>

                        <label for="input_search_loc" style="margin: 5px;" class="pull-left">
                            Near
                        </label>

                        <input style="margin-top: 4px; width: 30%;"
                               placeholder="Your Location"
                               id="input_search_loc" type="text" class="input_trans pull-left">
                    </div>
                    <span class="input-group-btn">
                        <button id="btn_search" class="btn btn-default" type="button">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>

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
<input type="hidden" id="restaurants" value="{{json_encode($restaurants)}}">
<input type="hidden" id="search" value="{{$search}}">
<input type="hidden" id="lat" value="{{$lat}}">
<input type="hidden" id="lng" value="{{$lng}}">

<div class="container" style="padding-top: 90px;">
    <div class="row">
        <div id="restaurant_section" class="col-md-7">
            @foreach($restaurants as $restaurant)
                <div class="row">
                    <div class="col-md-3">
                        <a style="margin-bottom: 0;" href="/restaurant.{{$restaurant->id}}" class="thumbnail">
                            @if($restaurant->url != "")
                                <img src="{{$restaurant->url}}">
                            @else
                                <img src="img/restaurant_default.jpg">
                            @endif
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @for($i = 1; $i < 6; $i++)
                                        @if($restaurant->rating >= $i)
                                            <button type="button" class="btn btn-{{$type[$restaurant->rating]}} btn-sm" aria-label="Left Align">
                                                <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                <span style="padding-bottom: 1px;" class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </button>
                                        @endif
                                    @endfor
                                </div>
                                <h4 style="margin-top: 10px;">
                                    <strong>
                                        <a href="/restaurant.{{$restaurant->id}}">{{++$index}} {{$restaurant->name}}</a>
                                    </strong>
                                </h4>
                            </div>

                            <div class="col-md-6">
                                <p>
                                    {{$restaurant->address}}
                                </p>
                            </div>
                        </div>
                        <div>
                            <p style="font-style: italic; color: #5e5e5e; margin-top: 10px">
                                "{{substr($restaurant->summary,0,150)}}..."
                            </p>
                        </div>
                    </div>

                </div>

                <hr>
            @endforeach
        </div>
        <div class="col-md-5">
            <div id="map" style="height: 60%; width: 100%;"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-offset-5">
        <button id="btn_prev" class="btn btn-default">Prev</button>
        <button id="btn_next" class="btn btn-default">Next</button>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjgTs-FAYqJqYXcm1Jjmzqp5xjsHq8eFM&callback=initMap">
</script>
<script src="js/search.js"></script>

<div class="footer text-center" style="margin-top: 40px; padding: 20px; background-color: #0f0f0f;">
    <p style="color: white;">Copyright © Humble Restaurants 2017</p>
</div>
</body>
</html>
