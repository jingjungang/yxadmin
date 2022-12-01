/**审核
 *   flag 1.通过 2.不通过
 */
function commitcheck(flag) {

    var che = document.getElementsByName("selectList");
    var li = [];
    var index = 0;
    for (var i = 0; i < che.length; i++) {
        if (che[i].checked == true) {
            if (che[i].defaultValue != '') {
                li[index] = che[i].defaultValue;
                index++;
            }
        }
    }
    if (li.length == 0) {
        alert("请选择会议");
    } else {
        var idStr = li.join(",");//li.toString();
        var title = '确定会议通过吗？';
        if(flag == 2){
            title = '确定会议不通过吗？';
        }else if(flag == 3){
            title = '确定恢复会议吗？';
        }else if(flag == 4){
            title = '确定彻底删除会议吗？';
        }
        layer.confirm(title, {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                url: 'checkMeetting',
                type: 'post',
                data: {
                    'id': idStr,
                    'flag': flag
                },
                success: function (data) {
                    if (data.code == 1) {
                        layer.msg(data.msg, {
                            time: 2000,
                            icon: 6
                        });
                        setTimeout(function () {
                            window.location.reload(); //刷新当前iframe页面
                        }, 100);
                    } else {
                        layer.msg(data.msg, {
                            time: 2000,
                            icon: 5
                        });
                    }
                },
                dataType: 'json'
            });
        });
    }

}



