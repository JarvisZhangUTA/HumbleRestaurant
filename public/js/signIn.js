$(function(){
    $("[data-toggle='popover']").popover();

    var email = $("#email").val();
    var password = $("#password").val();

    $("#signIn").on("click", function (e){
        $.ajax({
            url: "/signIn",
            type: "post",
            data: {
                email : $("#email").val(),
                password : $("#password").val()
            },
            success: function(data){
                if(data.result == 0){
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                }else{
                    window.location.href = "/";
                }
            }
        });
    });
});