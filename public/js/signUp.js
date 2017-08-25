$(function(){
    $("[data-toggle='popover']").popover();

    var email = $("#email").val();
    var password = $("#password").val();
    var confirm = $("#confirm").val();

    if(password != confirm){
        $("#alertMsg").html("Passwords don't match.");
        $(".alert").hide().show();
        return;
    }

    $("#signUp").on("click", function (e){
        $.ajax({
            url: "/signUp",
            type: "post",
            data: {
                email : $("#email").val(),
                password : $("#password").val(),
                role : "user"
            },
            success: function(data){
                if(data.result == 0){
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                }else{
                    window.location.href = "/loginPage";
                }
            }
        });
    });
});