@extends('header')

@section('content')
    <input id="role" type="hidden" value="{{$_SESSION['role']}}">

    <div class="row row-offcanvas row-offcanvas-left">
        <div class="col-xs-4 col-sm-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a class="list-group-item" href="/profileUserPage">Basic Info</a>
                <a class="list-group-item" href="#">Password</a>
                @if($_SESSION['role'] == 'restaurant')
                    <a class="list-group-item" href="/profileRestaurantPage.0">Restaurant</a>
                @elseif($_SESSION['role'] == 'admin')
                    <a class="list-group-item" href="/profileNewRestaurantPage">Register restaurant</a>
                @endif
                <a class="list-group-item active" href="/profileReceiptPage">View Receipts</a>
                <a class="list-group-item" href="/logout">Logout</a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8" style="padding-bottom: 20px;">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>date</th>
                        <th>Payment</th>
                        <th>Donation</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    @foreach($receipts as $receipt)
                        <tr>
                            <td>
                                <img src="img/receipt.png"
                                     onclick='showImg(this)'
                                     style="width: 30px; height: 30px;"
                                     alt="{{$receipt->url}}"
                                     class="img-responsive btn_img">
                            </td>
                            <td style="vertical-align: middle">{{$receipt->date}}</td>
                            <td style="vertical-align: middle">
                                <strong>
                                {{number_format($receipt->amount,2)}}
                                </strong>
                            </td>
                            <td style="vertical-align: middle">
                                <strong style="color: #67b168;">
                                {{number_format($receipt->donation,2)}}
                                </strong>
                            </td>
                            <td>
                                @if($_SESSION['role'] != 'user')
                                @if($receipt->verified == 0)
                                    <button
                                            onclick='verifyReceipt(this)'
                                            class="btn btn-success verify_receipt"
                                            value="{{$receipt->id}}">
                                        Confirm
                                    </button>
                                    <button
                                            onclick='deleteReceipt(this)'
                                            class="btn reject_receipt"
                                            value="{{$receipt->id}}">
                                        Reject
                                    </button>
                                @else
                                    <button
                                            onclick='deleteReceipt(this)'
                                            class="btn btn-default delete_receipt"
                                            value="{{$receipt->id}}">
                                        Delete
                                    </button>
                                @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pull-right">
                <button id="prev" class="btn btn-default disabled">Prev</button>
                @if(sizeof($receipts) == 10)
                    <button id="next" class="btn btn-default">Next</button>
                @else
                    <button id="next" class="btn btn-default disabled">Next</button>
                @endif
            </div>

        </div>
    </div>

    <div class="modal fade" id="imgModel" tabindex="-1" role="dialog"
         aria-labelledby="imgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="imgLabel">Receipt</h4>
                </div>
                <div class="modal-body">
                    <img id="receipt_img" style="height: 300px;" class="img-responsive">
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/editReceipt.js"></script>
@endsection