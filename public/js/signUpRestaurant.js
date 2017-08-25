$(function(){
    $("[data-toggle='popover']").popover();

    var password = $("#password").val();
    var confirm = $("#confirm").val();

    var lng;
    var lat;

    if(password != confirm){
        $("#alertMsg").html("Passwords don't match.");
        $(".alert").hide().show();
        return;
    }

    $("#signUp").on("click", function (e){
        $.ajax({
            url: "/restaurantSignUp",
            type: "post",
            data: {
                email : $("#email").val(),
                password : $("#password").val(),
                name : $("#restaurantName").val(),
                address : $("#address").val(),
                summary : $("#summary").val(),
                lat : lat,
                lng : lng,
                role : "restaurant"
            },
            success: function(data){
                if(data.result == 1){
                    window.location.href = "/loginPage";
                }else{
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
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