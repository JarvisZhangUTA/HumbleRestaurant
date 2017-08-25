@extends('header')

@section('content')
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-4 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a class="list-group-item" href="/profileUserPage">Basic Info</a>
                <a class="list-group-item active" href="#">Password</a>
                @if($_SESSION['role'] == 'restaurant')
                    <a class="list-group-item" href="/profileRestaurantPage.0">Restaurant</a>
                @elseif($_SESSION['role'] == 'admin')
                    <a class="list-group-item" href="/profileNewRestaurantPage">Register restaurant</a>
                @endif
                <a class="list-group-item" href="/logout">Logout</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control" name="password" size="50">

            <label for="newPass">New Password</label>
            <input id="newPass" type="password" class="form-control" name="newPass" size="50">

            <label for="confirmPass">Confirm new password</label>
            <input id="confirmPass" type="password" class="form-control" name="confirmPass" size="50">
            <br><br>
            <button id="confirm" type="button" class="btn btn-success">Save change</button>
            <a id="cancel" href="/" style="margin-left: 10px;">Cancel</a>
        </div>
    </div>

    <div id="alertMsg" class="alert alert-info"></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/editPassword.js"></script>
@endsection