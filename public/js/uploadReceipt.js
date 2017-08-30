$(function() {
    //初始化fileinput
    var fileInput = new FileInput();
    fileInput.Init("uploadFile", "");


    $("#submit").on("click", function (e){
        var uploadFile = $("#uploadFile");

        if($("#amount").val() == ""){
            $("#alertMsg").html("Please fill in the payment amount.");
            $(".alert").hide().show();
            return;
        }
        if(uploadFile.val() == ""){
            $("#alertMsg").html("Please select the receipt image.");
            $(".alert").hide().show();
            return;
        }
        uploadFile.fileinput('upload');
    });
});

//初始化fileinput
var FileInput = function() {
    var oFile = new Object();

    //初始化fileinput控件（第一次初始化）
    oFile.Init = function(ctrlName) {
        var control = $('#' + ctrlName);

        //初始化上传控件的样式
        control.fileinput({
            uploadUrl: '/uploadReceipt', //上传的地址
            allowedFileExtensions: ['jpg', 'png', 'gif'], //接收的文件后缀
            uploadAsync: true, //默认异步上传
            showUpload: false, //是否显示上传按钮
            showRemove: true, //显示移除按钮
            showCaption: false, //是否显示标题
            dropZoneEnabled: true, //是否显示拖拽区域
            browseClass: "btn btn-primary", //按钮样式: btn-default、btn-primary、btn-danger、btn-info、btn-warning
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            uploadExtraData: function() {  // callback example
                var out = {
                    'date':$("#date").val(),
                    'rid':$("#rid").val(),
                    'uid':$("#uid").val(),
                    'amount':$("#amount").val()
                };
                return out;
            }
        });

        //文件上传完成之后发生的事件
        $("#uploadFile").on("fileuploaded", function(event, data, previewId, index) {
        });
    }
    return oFile; //这里必须返回oFile对象，否则FileInput组件初始化不成功
};