@extends('header')

@section('content')

    <?php
    $type = ['','danger','warning','info','primary','success'];
    ?>

    <input type="hidden" id="rid" value="{{$restaurant->id}}">
    <input type="hidden" id="lat" value="{{$restaurant->latitude}}">
    <input type="hidden" id="lng" value="{{$restaurant->longitude}}">

    <div class="row">
        <div class="col-md-offset-1 col-md-5">
            <header>
                <h1><b>{{ $restaurant->name }}</b></h1>
            </header>
            <p style="font-style: italic; color: #5e5e5e;">"{{ $restaurant->summary }}"</p>
            <div>
                @if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin')
                    <a href="/profileRestaurantPage.{{$restaurant->id}}" class="btn btn-default">Edit Info</a>
                @endif
                @if(isset($_SESSION['role']) && $_SESSION['role'] == 'user')
                    <a href="/uploadReceiptPage.{{$restaurant->id}}" class="btn btn-default">Upload Receipt</a>
                @endif
            </div>
        </div>

        <span class="col-md-6">
            <div id="carousel-img" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-img" data-slide-to="0" class="active"></li>
                    @for($i = 1 ; $i < sizeof($images) ; $i++)
                        <li data-target="#carousel-img" data-slide-to="{{$i}}"></li>
                    @endfor
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @if(sizeof($images) > 0)
                        <div class="item active">
                            <img src="{{$images[0]->url}}"/>
                        </div>
                    @else
                        <div class="item active">
                            <img src="img/restaurant_default.jpg"/>
                        </div>
                    @endif

                    @for($i = 1 ; $i < sizeof($images) ; $i++)
                        <div class="item">
                            <img src="{{$images[$i]->url}}" alt="..." />
                        </div>
                    @endfor
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-img" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="right carousel-control" href="#carousel-img" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            {{--<img src="https://www.scandichotels.com/imagevault/publishedmedia/qn6infvg30381stkubky/scandic-sundsvall-city-restaurant-verket-10.jpg" alt="" />--}}
        </span>
    </div>

    <div class="row" style="margin-top: 60px;">
        <div class="col-md-offset-1 col-md-7">
            <div class="row">
                @include('rating')
            </div>

            <div class="row comment">
                <div class="form-group">
                    <label for="comment">Leave a Comment :</label>
                    <textarea class="form-control" rows="5" id="comment" style="margin-bottom: 10px; z-index: 0; resize: none;"></textarea>
                    @for($i = 0 ; $i < 5 ; $i++)
                        <button id="{{$i}}" type="button" class="comment_star btn btn-default" aria-label="Left Align">
                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                        </button>
                    @endfor

                    <button id="btn_reply" class="btn btn-default btn-sm pull-right">Submit</button>
                </div>

                @include('reply')

                @if(sizeof($ratings) >= 10)
                    <a id="reply_more" class="btn btn-default pull-right" style="margin: 10px 0;">Load More</a>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="rating-block" style="margin-top: 10px;">
                <div class="row">
                <div class="col-sm-6" style="text-align: center">
                    <span class="h2" style="font-weight:bold">
                        {{$restaurant->percentageDonation}}%
                        </span>
                    <p style="color: #5e5e5e;">
                        payment will be given to charity.
                    </p>
                </div>
                <div class="col-sm-6" style="text-align: center">
                    <span class="h2" style="font-weight:bold">
                    ${{$restaurant->donation}}
                    </span>
                    <p style="color: #5e5e5e;">
                    has been given in this place.
                    </p>
                </div>
                </div>
            </div>
            <div class="rating-block" style="margin-top: 10px;">
                <p><span class="glyphicon glyphicon-phone"></span>  {{ $restaurant->phone }}</p>
                <p><span class="glyphicon glyphicon-map-marker"></span>  {{ $restaurant->address }}</p>
            </div>
            <div class="rating-block" style="margin-top: 10px;">
                <div id="map"></div>
            </div>
            <div class="rating-block" style="margin-top: 10px;">
                {!! $restaurant->info !!}
            </div>
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/restaurantComment.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjgTs-FAYqJqYXcm1Jjmzqp5xjsHq8eFM&callback=initMap">
    </script>

    <div id="alertMsg" style="position: fixed;right: 10px;bottom: 10px;" class="alert alert-danger"></div>
@endsection