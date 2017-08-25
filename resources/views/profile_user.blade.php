@extends('header')

@section('content')
<div class="row row-offcanvas row-offcanvas-right">
    <div class="col-xs-4 col-sm-3 sidebar-offcanvas" id="sidebar">
        <div class="list-group">
            <a class="list-group-item active" href="#">Basic Info</a>
            <a class="list-group-item" href="/profilePasswordPage">Password</a>
            @if($_SESSION['role'] == 'restaurant')
                <a class="list-group-item" href="/profileRestaurantPage.0">Restaurant</a>
            @elseif($_SESSION['role'] == 'admin')
                <a class="list-group-item" href="/profileNewRestaurantPage">Register restaurant</a>
            @endif
            <a class="list-group-item" href="/logout">Logout</a>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6">
        <label for="name">User name</label>
        <input id="name" value="{{$user->name}}" type="text" class="form-control" name="name" size="30">

        <label for="email">Email</label>
        <input id="email" value="{{$user->email}}" type="text" class="form-control" name="email" size="30">
        <br><br>
        <button id="confirm" type="button" class="btn btn-success">Save change</button>
        <a id="cancel" href="/" style="margin-left: 10px;">Cancel</a>
    </div>
</div>

<div id="alertMsg" class="alert alert-info"></div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/editUser.js"></script>
@endsection