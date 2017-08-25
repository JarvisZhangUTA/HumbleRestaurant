@extends('header')

@section('content')
    <link href="css/fileinput.min.css" rel="stylesheet" type="text/css">

    <div class="row">
        <div class="col-md-6">
            <label for="amount">Amount</label>
            <input id="amount" type="text" class="form-control" name="amount" size="50">
            <br>
            <form id="img_form" method="post" style="height: 30px;" enctype="multipart/form-data">
                <input class="file" data-show-preview="false" style="display:none;"
                       name = 'img_file' id="img_file" type="file">
            </form>
        </div>
    </div>
    
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fileinput.min.js"></script>
    <script src="js/uploadReceipt.js"></script>
@endsection