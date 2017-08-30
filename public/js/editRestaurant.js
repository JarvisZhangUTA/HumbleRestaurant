$(function(){
    $("[data-toggle='popover']").popover();

    var lat = $("#lat").val();
    var lng = $("#lng").val();

    $("#confirm").on("click", function (e){
        var id = $("#id").val();
        var restaurantName = $("#restaurantName").val();
        var address = $("#address").val();
        var summary = $("#summary").val();
        var percentageDonation = $("#percentageDonation").val();
        var fund = $("#funds").val();

        if(restaurantName == "" || address == "" || summary == "" || percentageDonation == "" || fund == ""){
            $("#alertMsg").html("Values can't be empty.");
            $(".alert").hide().show();
            return;
        }

        if(lat == "" || lng == ""){
            $("#alertMsg").html("Cannot locate the address.");
            $(".alert").hide().show();
            return;
        }

        $.ajax({
            url: "/updateRestaurant",
            type: "post",
            data: {
                id : id,
                restaurantName : restaurantName,
                lat : lat,
                lng : lng,
                percentageDonation : percentageDonation,
                fund : fund,
                address : address,
                phone : $("#phone").val(),
                info : $("#info").val(),
                summary : summary
            },
            success: function(data){
                if(data.result == 0){
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                }else{
                    window.location.href = "/profileRestaurantPage."+id;
                }
            }
        });
    });

    $("#address").focusout(function() {
        var address = $("#address").val();
        if(address != "") {
            $("#address_loading").show();
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

                    $("#address_loading").attr("src", "img/correct.png");
                }
            });
        }
    });
});