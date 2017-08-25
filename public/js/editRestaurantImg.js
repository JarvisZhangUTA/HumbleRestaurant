$(function(){

    $("#img_file").show();

    $("#btn_delete").on("click", function (event){
        $.ajax({
            url: "/img-delete." + $("#id").val(),
            type: "post",
            data: {
                url : $(this).attr('value')
            },
            success: function(data){
                window.location.href = "/profileRestaurantImgPage." + $("#id").val();
            }
        });
    });

    $("#btn_default").on("click", function (event){
        $.ajax({
            url: "/img-default." + $("#id").val(),
            type: "post",
            data: {
                url : $(this).attr('value')
            },
            success: function(data){
                window.location.href = "/profileRestaurantImgPage." + $("#id").val();
            }
        });
    });
});