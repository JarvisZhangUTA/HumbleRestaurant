@extends('header')

@section('content')
    <link href="css/fileinput.min.css" rel="stylesheet" type="text/css">
    <input id="id" value="{{$restaurant->id}}" type="hidden">
    <input id="lat" value="{{$restaurant->latitude}}" type="hidden">
    <input id="lng" value="{{$restaurant->longitude}}" type="hidden">

    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-4 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a class="list-group-item" href="/profileUserPage">Basic Info</a>
                <a class="list-group-item" href="/profilePasswordPage">Password</a>
                @if($_SESSION['role'] == 'restaurant')
                    <a class="list-group-item active" href="/profileRestaurantPage.0">Restaurant</a>
                @elseif($_SESSION['role'] == 'admin')
                    <a class="list-group-item" href="/profileNewRestaurantPage">Register restaurant</a>
                @endif
                <a class="list-group-item" href="/profileReceiptPage">View Receipts</a>
                <a class="list-group-item" href="/logout">Logout</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8" style="padding-bottom: 20px;">
            <div class="row">
                <div class="col-md-8">
                    <label for="percentageDonation">Percentage Donation</label>
                    <input id="percentageDonation" value="{{$restaurant->percentageDonation}}"

                           @if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
                           disabled
                           @endif

                           type="number" class="form-control" name="percentageDonation" size="50">
                </div>
                <div class="col-md-4">
                    <label for="funds">Balance</label>
                    <input id="funds" value="{{$restaurant->fund}}"

                           @if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
                           disabled
                           @endif

                           type="number" class="form-control" name="funds" size="50">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                <label for="restaurantName">Restaurant Name</label>
                <input id="restaurantName" value="{{$restaurant->name}}" type="text" class="form-control" name="restaurantName" size="50">
                </div>
                <div class="col-md-4">
                <label for="phone">Phone Number</label>
                <input id="phone" value="{{$restaurant->phone}}" type="text" class="form-control" name="phone" size="50">
                </div>
            </div>

            <label for="address">Restaurant Location</label>
            <img id="address_loading" src="img/loading.gif" style="margin-bottom:3px;height:12px; width:12px; display: none;">
            <input id="address" value="{{$restaurant->address}}" type="text" class="form-control" name="address" size="50">

            <label for="info">Information Section</label>
            <textarea id="info" class="form-control" rows="5" style="z-index: 0; resize: none;">{{$restaurant->info}}</textarea>

            <label for="summary">A brief introduction to your restaurant</label>
            <textarea id="summary" class="form-control" rows="5" style="z-index: 0; resize: none;">{{$restaurant->summary}}</textarea>

            <br><br>
            <button id="confirm" type="button" class="btn btn-success">Save change</button>
            <a href="/profileRestaurantImgPage.{{$restaurant->id}}" style="margin-left: 10px;">Edit Image</a>
        </div>
    </div>

    <div id="alertMsg" class="alert alert-info"></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/editRestaurant.js"></script>
@endsection