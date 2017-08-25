var levelDis = [0,21.282,16.355,10.064,5.540,
    2.909,1.485,0.752,0.378,0.190,0.095,0.048,
    0.024,0.012,0.006,0.003,0.00148,0.00074,0.00037,0.00019];
var types = ['','danger','warning','info','primary','success'];
var mapSize = 600;
var map;

var lat = parseFloat($("#lat").val());
var lng = parseFloat($("#lng").val());
var search = $("#search").val();

var restaurants = JSON.parse($("#restaurants").val());
var infoWindow;

var page = 1;
var miles = 10;
var markers = [];

function initMap() {
    var center = {lat: lat, lng: lng};
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: center
    });

    google.maps.event.addListener(map, 'zoom_changed', function () {
        google.maps.event.addListenerOnce(map, 'bounds_changed', function (e) {
            searchAction();
        });
    });

    initPoints();
}

function initPoints() {
    setMapOnAll(null);

    $.each(restaurants,function(n,restaurant){

            var latLng = new google.maps.LatLng(
                parseFloat(restaurant.latitude),parseFloat(restaurant.longitude));

            var content = "<strong>"+restaurant.name + "</strong><br>" + restaurant.address;

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                label: n + 1 + "",
                title: restaurant.name
            });

            marker.addListener('click', function() {
                if(infoWindow != null) infoWindow.close();
                infoWindow = new google.maps.InfoWindow({map: map});
                infoWindow.setPosition(marker.position);
                infoWindow.open(map, marker);
                infoWindow.setContent(content);
            });

            markers.push(marker);
        }
    );
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function searchAction() {
    var bound = map.getBounds();

    $.ajax({
        url: '/searchRestaurant',
        type: "get",
        data: {
            latFrom : bound.getNorthEast().lat(),
            latTo : bound.getSouthWest().lat(),
            lngFrom : bound.getNorthEast().lng(),
            lngTo : bound.getSouthWest().lng(),
            search : search,
            page : page,
            miles : miles
        },
        success: function(data){
            restaurants = data.restaurants;
            initPoints();
            initList();
        }
    });
}

function initList() {
    $("#restaurant_section").empty();
    var index = ( page - 1 ) * 10 + 1;

    for (var i = 0; i < restaurants.length; i++) {
        var content = "<div class='row'><div class=col-md-3><a style='margin-bottom: 0;' href='/restaurant."+
                restaurants[i].id
            +"' class='thumbnail'>";
        if(restaurants[i].url == "")
            content += "<img src='img/restaurant_default.jpg'>";
        else
            content += "<img src='"+restaurants[i].url+"'>";
        content += "</a></div><div class='col-md-8'><div class='row'><div class='col-md-6'><div class='btn-group'>";

        var rat = Math.floor(restaurants[i].rating);
        for(var j = 1; j < 6; j++){
            if(restaurants[i].rating >= j){
                content += "<button type='button' class='btn btn-"+types[rat]+" btn-sm' aria-label='Left Align'> " +
                    "<span style='padding-bottom: 1px;' class='glyphicon glyphicon-star' aria-hidden='true'></span></button>"
            }else{
                content += "<button type='button' class='btn btn-default btn-sm' aria-label='Left Align'> " +
                    "<span style='padding-bottom: 1px;' class='glyphicon glyphicon-star' aria-hidden='true'></span></button>"
            }
        }

        content += "</div><h4 style='margin-top: 10px;'><strong>";
        content += "<a href='/restaurant."+
                restaurants[i].id
            +"'>"+ index +" "+restaurants[i].name+"</a>"
        index++;

        content += "</strong></h4></div><div class='col-md-6'><p>"+restaurants[i].address+"</p></div></div>" +
            "<div><p style='font-style: italic; color: #5e5e5e; margin-top: 10px'>\"";
        content += restaurants[i].summary.substr(0,150);
        content += "\"...</p></div></div></div><hr>";

        $("#restaurant_section").append(content);
    }
    setPageButton();
}

function searchRestaurant(lat,lng) {
    var search = $("#input_search_name").val();
    if(search == "") search = "null";
    window.location.href= '/searchRestaurantPage&lat='+lat+"&lng="+lng +"&search="+search+"&page="+1+"&miles="+10;
}

function setPageButton() {
    if(page == 1) {
        $("#btn_prev").addClass("disabled");
    }else {
        $("#btn_prev").removeClass("disabled");
    }

    if(restaurants.length != 10)
        $("#btn_next").addClass("disabled");
    else
        $("#btn_next").removeClass("disabled");
}

$(function(){
    setPageButton();

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

    $("#btn_prev").on("click", function (e){
        if(!$(this).hasClass('disabled')) {
            page--;
            searchAction();
        }
    });

    $("#btn_next").on("click", function (e){
        if(!$(this).hasClass('disabled')) {
            page++;
            searchAction();
        }
    });
});
