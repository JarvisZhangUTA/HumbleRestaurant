$(function(){

    $("#prev").on("click", function (e){
        if($(this).hasClass('disabled'))
            return;
        page--;
        refreshPage(page);

    });

    $("#next").on("click", function (e){
        if($(this).hasClass('disabled'))
            return;
        page ++;
        refreshPage(page);
    });
});

var page = 1;

function showImg(element) {
    var url = element.alt;
    $("#receipt_img").attr("src", url);
    $("#imgModel").modal('show');
}

function deleteReceipt(element) {
    var id = element.value;
    $.ajax({
        url: "/deleteReceipt",
        type: "post",
        data: {
            "id" : id
        },
        success: function(data){
            refreshPage(page);
        }
    });
}

function verifyReceipt(element) {
    var id = element.value;
    $.ajax({
        url: "/verifyReceipt",
        type: "post",
        data: {
            "id" : id
        },
        success: function(data){
            refreshPage(page);
        }
    });
}

function refreshPage(page) {
    $.ajax({
        url: "/getReceipt",
        type: "get",
        data: {
            "page" : page
        },
        success: function(data){
            var receipts = data.receipts;
            var table = $("#table_body");
            table.empty();

            var content = "";

            for(var i = 0; i < receipts.length; i++){
                content += "<tr><td>";
                content += "<img src='img/receipt.png' style='width: 30px; height: 30px;' alt='" +
                    receipts[i].url +"' class='img-responsive' onclick='showImg(this)'>";
                content += "</td><td style='vertical-align: middle'>";
                content += receipts[i].date;
                content += "</td><td style='vertical-align: middle'><strong>";
                content += receipts[i].amount.toFixed(2);
                content += "</strong></td><td style='vertical-align: middle'><strong style='color: #67b168;'>";
                content += receipts[i].donation.toFixed(2);
                content += "</strong> </td><td>";

                if($("#role").val() != 'user')
                if(receipts[i].verified == '0'){
                    content += "<button id='verify_receipt' onclick='verifyReceipt(this)' class='btn btn-success'value='"
                    +receipts[i].id + "'> Allow </button>";
                    content += " <button id='reject_receipt' onclick='deleteReceipt(this)' class='btn' value='"
                    +receipts[i].id + "'>Reject </button>";
                }else{
                    content += "<button id='delete_receipt' onclick='deleteReceipt(this)' class='btn btn-default' value='"
                    +receipts[i].id+"'>Delete </button>";
                }

                content += "</td></tr>"
            }

            table.append(content);

            if(page == 1) {
                $("#prev").addClass("disabled");
            }else {
                $("#prev").removeClass("disabled");
            }

            if(receipts.length != 10) {
                $("#next").addClass("disabled");
            }else {
                $("#next").removeClass("disabled");
            }
        }
    });
}
