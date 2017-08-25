$(function(){
    $("[data-toggle='popover']").popover();

    $("#confirm").on("click", function (e){
        $.ajax({
            url: "/updateUser",
            type: "post",
            data: {
                email : $("#email").val(),
                name : $("#name").val()
            },
            success: function(data){
                if(data.result == 0){
                    $("#alertMsg").html(data.data);
                    $(".alert").hide().show('medium');
                }else{
                    window.location.href = "/profileUserPage";
                }
            }
        });
    });
});