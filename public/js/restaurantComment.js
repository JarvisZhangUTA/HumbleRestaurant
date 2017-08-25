$(function(){
    var reply_score = 0;
    var page = 1;
    var types = ['','danger','warning','info','primary','success'];

    $('.carousel').carousel();

    $('.comment_star').on("click", function (e){
        var id = parseInt($(this).attr('id'));

        for(var i = 0; i <= id; i++){
            var cur_i = $('#'+i);
            cur_i.removeClass('btn-default');
            cur_i.addClass('btn-warning');
        }

        reply_score = id + 1;

        for(var j = id + 1; j < 5; j++){
            var cur_j = $('#'+j);
            cur_j.removeClass('btn-warning');
            cur_j.addClass('btn-default');
        }
    });
    
    $('#btn_reply').on("click",function (e) {
        $.ajax({
            url: "/addRating",
            type: "post",
            data: {
                rid : $('#rid').val(),
                score : reply_score,
                comment : $('#comment').val()
            },
            success: function(data){
                if(data.result == 1){
                    window.location.href ='/restaurant.' + $('#rid').val();
                }else{
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                    setTimeout('dismissAlert()',2000);
                }
            }
        });
    });


    $('#reply_more').on("click",function (e) {
        page++;
        $.ajax({
            url: "/getRestaurantRatings",
            type: "get",
            data: {
                rid : $('#rid').val(),
                page : page
            },
            success: function(data){
                var ratings = data.data;
                for(var i = 0; i < ratings.length; i++){
                    var comment = "<hr><div><p class=pull-right>"+ratings[i].created_at+"</p>";
                    comment += '<h2>' + ratings[i].name + '</h2><div class="btn-group">';
                    for(var j = 1; j < 6; j++){
                        if(ratings[i].score > j){
                            comment += "<button type='button' class='btn btn-"+types[ratings[i].score]+" btn-xs' aria-label='Left Align'>";
                        }else{
                            comment += "<button type='button' class='btn btn-grey btn-default btn-xs' aria-label='Left Align'>";
                        }
                        comment += "<span style='padding-bottom: 1px;' class='glyphicon glyphicon-star' aria-hidden='true'></span></button>";
                    }
                    comment += "</div><p style='font-style: italic; color: #5e5e5e; margin-top: 10px'>\"" + ratings[i].comment + "\"</p>";
                    $('#reply_more').before(comment);
                }

                if(ratings.length < 10)
                    $('#reply_more').hide();
            }
        });
    });
});

function dismissAlert() {
    $(".alert").hide();
}

function initMap() {

    var lat = parseFloat($("#lat").val());
    var lng = parseFloat($("#lng").val());

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: {lat: lat , lng: lng}
    });
    var marker = new google.maps.Marker({
        position: {lat: lat , lng: lng},
        map: map
    });
}
