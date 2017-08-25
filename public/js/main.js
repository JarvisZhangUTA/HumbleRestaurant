$(function() {
    var pages = parseInt($('#pages').val());
    var curPage = 1;
    var types = ['','danger','warning','info','primary','success'];

    if(curPage < pages){
        var content = '';
        content += "<div id='footer_card' class='btn card card-inverse card-primary text-center' style='height: 160px'>";
        content += "<div class='card-block'>";
        content += "<blockquote class='card-blockquote'>";
        content += "<h3 style='pull-right'>";
        content += "Load more results";
        content += "</h3>";
        content += "<footer id='footer_content' style='color: #ffffff'>"
        content += curPage + " of " + pages + " pages"
        content += "</footer>"
        content += "</blockquote>";
        content += "</div>";
        content += "</div>";

        $("#card-columns").append(content);
    }

    $("#footer_card").on("click", function (e){
        curPage++;
        $.ajax({
            url: "/main."+ curPage,
            type: "get",
            data: {
            },
            success: function(data){
                var restaurants = data.data.restaurants;
                for(var i = 0; i < restaurants.length; i++){
                    var content = '';
                    var restaurant = restaurants[i];

                    content += "<div class='card'>";
                    if(restaurant.url == '')
                        content += "<img class='card-img-top' style='width: 100%;' src='/img/restaurant_default.jpg'>";
                    else
                        content += "<img class='card-img-top' style='width: 100%; max-height: 400px;' src='"+ restaurant.url +"'>";

                    content += "<div class='card-block'>";
                    content += "<h4 class='card-title'>";
                    content += restaurant.name;
                    content += "</h4><hr>";
                    content += "<div class='card-subtitle' style='margin-bottom: 10px;'>";

                    for(var j = 1; j < 6; j++){
                        if(restaurant.rating >= j){
                            content += "<button type='button' class='btn btn-"+types[ratings[i].score]+" btn-xs' aria-label='Left Align'>";
                        }else{
                            content += "<button type='button' class='btn btn-grey btn-default btn-xs' aria-label='Left Align'>";
                        }
                        content += "<span style='padding-bottom: 1px;' class='glyphicon glyphicon-star' aria-hidden='true'></span></button>";
                    }

                    content += "</div>";
                    content += "<p class='card-text' style='max-height: 80px; overflow: hidden;'>";
                    content += restaurant.summary;
                    content += "</p>";
                    content += "<div style='height: 20px;'>"
                    content += "<a href='/restaurant." + restaurant.id + "' class='btn-sm btn-default pull-right'>View more</a>";
                    content += "</div></div>";

                    content += "</div>";
                    $('#footer_card').before(content);
                    $('#footer_content').text( curPage + " of " + pages + " pages");
                }

                if(curPage == pages)
                     $('#footer_card').hide();
            }
        });
    });

    var lat,lng;

    $("#btn_search").on("click", function (e){
        var address = $("#input_search_loc").val();
        if(address != ""){
            $.ajax({
                url: "https://maps.googleapis.com/maps/api/geocode/json?",
                type: "get",
                data: {
                    address: address,
                    key: "AIzaSyCjgTs-FAYqJqYXcm1Jjmzqp5xjsHq8eFM"
                },
                success: function (data) {
                    lat = data.results[0].geometry.location.lat;
                    lng = data.results[0].geometry.location.lng;
                    searchRestaurant(lat, lng);
                }
            });
        }else{
            navigator.geolocation.getCurrentPosition(function(position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;
                searchRestaurant(lat, lng);
            }, function() {});
        }
    });
});

function searchRestaurant(lat,lng) {
    var search = $("#input_search_name").val();
    if(search == "") search = "null";
    window.location.href= '/searchRestaurantPage&lat='+lat+"&lng="+lng +"&search="+search+"&page="+1+"&miles="+10;
}


