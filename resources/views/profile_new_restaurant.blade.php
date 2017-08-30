@extends('header')

@section('content')
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-4 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a class="list-group-item" href="/profileUserPage">Basic Info</a>
                <a class="list-group-item" href="/profilePasswordPage">Password</a>
                @if($_SESSION['role'] == 'restaurant')
                    <a class="list-group-item" href="/profileRestaurantPage.0">Restaurant</a>
                @elseif($_SESSION['role'] == 'admin')
                    <a class="list-group-item active" href="#">Register restaurant</a>
                @endif
                <a class="list-group-item" href="/profileReceiptPage">Receipts</a>
                <a class="list-group-item"  href="/logout">Logout</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <label for="email">Email</label>
            <input id="email" type="text" class="form-control" name="email" size="50">

            <br><br>
            <button id="confirm" type="button" class="btn btn-success">Send email</button>
            <button id="signUp" style="margin-left: 10px;" type="button" class="btn btn-default">
                <a href="/restaurantSignPage.0">Create an account</a>
            </button>
        </div>
    </div>

    <div id="alertMsg" class="alert alert-info"></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sendEmail.js"></script>
@endsection