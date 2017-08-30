@extends('header')

@section('content')
    <link href="css/fileinput.min.css" rel="stylesheet" type="text/css">

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

        <input id="id" value="{{$id}}" type="hidden">

        <div class="col-xs-12 col-sm-8">

            <form id="img_form" method="post" style="height: 30px;" enctype="multipart/form-data" action="{{"/img-upload.".$id}}">
                <input class="file" data-show-preview="false" style="display:none;"
                       name = 'img_file' id="img_file" type="file">
            </form>

            @foreach ($images as $image)
                <div class="file-preview-frame" data-template="image">
                    <div class="kv-file-content">
                        <img src="{{ $image->url }}" style="width: auto; height: 160px;" class="file-preview-image">
                    </div>

                    <div style="padding: 5px;" class="pull-right">
                        @if($default == $image->url)
                            <button type="button" value="{{ $image->url }}" class="btn btn-xs btn-primary disabled">Default Image</button>
                        @else
                            <button id="btn_default" type="button" value="{{ $image->url }}" class="btn btn-xs btn-primary">Set as Default</button>
                        @endif

                        <button id="btn_delete" type="button" value="{{ $image->url }}" class="btn btn-xs btn-danger">delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fileinput.min.js"></script>
    <script src="js/editRestaurantImg.js"></script>
@endsection