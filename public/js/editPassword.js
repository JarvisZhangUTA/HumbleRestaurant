$(function(){
    $("[data-toggle='popover']").popover();

    $("#confirm").on("click", function (e){
        var password = $("#password").val();
        var newPass = $("#newPass").val();
        var confirmPass = $("#confirmPass").val();

        if(newPass != confirmPass){
            $("#alertMsg").html("Passwords don't match.");
            $(".alert").hide().show();
            return;
        }

        if(newPass == password){
            $("#alertMsg").html("Try a new Password.");
            $(".alert").hide().show();
            return;
        }

        $.ajax({
            url: "/updatePassword",
            type: "post",
            data: {
                password : password,
                newPass : newPass
            },
            success: function(data){
                if(data.result == 0){
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                }else{
                    window.location.href = "/profilePasswordPage";
                }
            }
        });
    });
});