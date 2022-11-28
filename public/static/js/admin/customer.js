$(document).ready(function () {
    var intP = 0;
    //为外面的盒子绑定一个点击事件
    $("#uploadImgBtn").click(function () {
        var input = $("#file");//1、先回去input标签
        input.on("change", function () { //2、给input标签绑定change事件
            var files = this.files;
            var len = files.length;
            if(len>3){
                layer.msg('图片超出限额～', {});
                return;
            }
            if (intP > 2) {
                layer.msg('图片不能再多了～', {});
                return;
            }
            var sum = len+intP;
            if(sum>3){
                layer.msg('图片超出限额～', {});
                return;
            }
            $.each(files, function (key, value) {//3、回显
                //每次都只会遍历一个图片数据
                var div = document.createElement("div"),
                    img = document.createElement("img");
                div.className = "pic";
                img.onclick = function (){
                    layer.confirm("你确定要删除吗？", {
                        btn: ['确定', '取消'] //按钮
                    }, function () {
                        var parentObj = div.parentNode;//获取div的父对象
                        parentObj.removeChild(div);//通过div的父对象把它删除
                        layer.msg('ok', {
                            time: 1000,
                            icon: 1
                        });
                    });
                }
                var fr = new FileReader();
                fr.onload = function () {
                    img.src = this.result;
                    div.appendChild(img);
                    document.getElementById("uppic").appendChild(div);
                }
                fr.readAsDataURL(value);
                intP += parseInt(1);
            })
        })
        //4、我们把当前input标签的id属性remove
        input.removeAttr("id");
        var newInput = '<input class="uploadImg" type="file" name="file[]" multiple id="file" accept="image/jpeg ,image/png,image/gif">';
        $(this).append($(newInput));
    })


})

function del(element){
    layer.confirm("你确定要删除吗？", {
        btn: ['确定', '取消'] //按钮
    }, function () {
        element.remove();
        layer.msg('ok', {
            time: 1000,
            icon: 1
        });
    });
}
