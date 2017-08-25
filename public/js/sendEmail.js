$(function(){
    $("[data-toggle='popover']").popover();
    var email = $("#email").val();
    $("#confirm").on("click", function (e){
        $.ajax({
            url: "/sendEmail",
            type: "post",
            data: {
                email : $("#email").val()
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