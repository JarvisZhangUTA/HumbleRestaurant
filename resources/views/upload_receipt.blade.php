@extends('header')

@section('content')
    <link href="css/fileinput.min.css" rel="stylesheet" type="text/css">


    <div class="row">
        <div class="col-md-4" style="height: 60%;">
            <input name="uploadFile" type="file" id="uploadFile" class="file-loading" />
        </div>
        <div class="col-md-6">
            <h3>Receipt upload</h3>
            <label for="user">Email</label>
            <input id="user" type="text" readonly="readonly"
                   class="form-control" value="{{$_SESSION['email']}}" name="user" size="50">
            <label for="date">Date</label>
            <input id="date" type="date" readonly="readonly"
                   class="form-control" value="{{date("Y-m-d")}}" name="date" size="50">
            <label for="amount">Payment Amount</label>
            <input id="amount" type="text" class="form-control" name="amount" size="50">

            <input id="rid" type="hidden" value="{{$id}}">
            <input id="uid" type="hidden" value="{{$_SESSION['id']}}">

            <br>
            <input id="submit" type="submit" value="Submit" class="btn btn-primary pull-right">
        </div>
    </div>


    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fileinput.min.js"></script>
    <script src="js/uploadReceipt.js"></script>
    <div id="alertMsg" class="alert alert-danger"></div>
@endsection