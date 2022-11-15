//基本信息
function publishArticleSubmit() {

    if ($.trim($("input[name='name']").val()) == '') {

        layer.msg('请填写会议名称', {
            time: 1000,
            icon: 2
        });

        return false;
    }


    if (!$("#type2").val()) {

        layer.msg('请选择类型', {
            time: 1000,
            icon: 2
        });

        return false;
    }

    if (!$("#province").val()) {

        layer.msg('请选择省份', {
            time: 1000,
            icon: 2
        });

        return false;
    }
    if (!$("#city").val()) {

        layer.msg('请选择市', {
            time: 1000,
            icon: 2
        });

        return false;
    }
    if (!$("#area").val()) {

        layer.msg('请选择区', {
            time: 1000,
            icon: 2
        });

        return false;
    }
    if (!$("#addressdetail").val()) {

        layer.msg('请填写详细地址', {
            time: 1000,
            icon: 2
        });

        return false;
    }
    if (!$("#uid").val()) {

        layer.msg('请选择创建员工', {
            time: 1000,
            icon: 2
        });

        return false;
    }

    var formData = new FormData(document.getElementById('article_form'));
    var url = "updateMeetting";

    $.ajax({
        url: url,
        type: 'post',
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: formData,
        success: function (data) {

            if (data.code == 1) {

                layer.msg(data.msg, {
                    time: 1000,
                    icon: 6
                });

            } else {

                layer.msg(data.msg, {
                    time: 1000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

//添加医院按钮
$("#toggle_modal").on('click', function () {
    $("#user-modal-form").modal('show');
});

//添加议程按钮
$("#toggle_modal_process").on('click', function () {
    $("#process-modal-form").modal('show');
});

//添加员工
$("#toggle_modal_employee").on('click', function () {
    $("#employee-modal-form").modal('show');
});

//添加客户
$("#toggle_modal_customer").on('click', function () {
    $("#customer-modal-form").modal('show');
});

//添加费用
$("#toggle_modal_fee").on('click', function () {
    $("#fee-modal-form").modal('show');
});

//添加总结
$("#toggle_modal_Summary").on('click', function () {
    $("#Summary-modal-form").modal('show');
});


// 获取单个医院信息
function getHospital() {
    var hname = $.trim($('.hname').val());
    $.ajax({
        type: "POST", //请求类型
        url: "getHospitalinfos",
        dataType: "json", //服务器返回的数据类型
        async: false, //是否同步
        data: {
            "hname": hname
        },
        success: function (data) { //回调结果，如果成功

            if (data.code == 1) {
                $('#w_othername').val(data.data.othername);
                $('#w_quality').val(data.data.quality);
                $('#w_province').val(data.data.province + data.data.city + data.data.area);
                if (data.data.divided == "1") {
                    $('#w_divided').val("是");
                } else if (data.data.divided == "2") {
                    $('#w_divided').val("否");
                }
                $('#w_code').val(data.data.code);
                $('#w_level').val(data.data.level);
                $('#w_address').val(data.data.address);
                $('#w_development').val(data.data.development);
                $('#w_hostname').val(data.data.hostname);
                $('#w_id').val(data.data.id);
            }
        }
    });

}

//添加医院
function addhospital() {
    var hid = $.trim($('#w_id').val());
    var mid = $.trim($('#mid').val());
    $.ajax({
        type: "POST", //请求类型
        url: "addhospital",
        dataType: "json", //服务器返回的数据类型
        async: false, //是否同步
        data: {
            "hid": hid,
            "mid": mid
        },
        success: function (data) { //回调结果，如果成功
            if (data.code == 1) {
                setTimeout(function () {
                    window.location.reload(); //刷新当前iframe页面
                }, 100);
            } else {
                alert(data.msg);
            }
        }
    });
}

// 添加议程
function addprocess() {
    var form = document.getElementById("process_form");
    var fd = new FormData(form);
    // fd.append('mid',$("#meetting_id").val())
    $.ajax({
        url: 'addOneProcess',
        type: 'post',
        async: true,
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: fd,
        success: function (data) {

            if (data.code == 1) {
                layer.alert('保存成功', {
                    icon: 6
                }, function () {
                    window.location.reload(); //刷新当前iframe页面
                    // parent.window.location.href = parent.window.location.href;
                });

            } else {

                layer.msg(data.msg, {
                    time: 2000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

// 编辑议程
$('.edit-Process').on('click', function () {
    var pid = $(this).data('id');
    $.ajax({
        url: 'getProcessById',
        type: 'post',
        data: {id: pid},
        success: function (data) {
            if (data.code == 1) {
                $('#m_mdate').val(data.data.mdate);
                $('#m_theme').val(data.data.theme);
                $('#m_speaker').val(data.data.speaker);
                $('#m_start').val(data.data.start);
                $('#m_end').val(data.data.end);

                document.getElementById("old_pic").src = data.data.photo;
                var old_pic = document.getElementById("old_pic_a");
                if (data.data.photo != ''&&data.data.photo !=null) {
                    old_pic.style.display = "block";
                } else {
                    old_pic.style.display = "none";
                }


                var old_ppt = document.getElementById("old_ppt");
                old_ppt.href = data.data.ppt;
                if (data.data.ppt != ''&&data.data.ppt !=null) {
                    old_ppt.style.display = "block";
                } else {
                    old_ppt.style.display = "none";
                }
                $('#processid').val(data.data.id);
                $("#process-modal-form").modal('show');
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

// 添加员工
function addEmployee() {
    var form = document.getElementById("employee_form");
    var fd = new FormData(form);
    $.ajax({
        url: 'addEmployee',
        type: 'post',
        async: true,
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: fd,
        success: function (data) {

            if (data.code == 1) {
                layer.msg(data.msg, {
                    time: 2000,
                    icon: 6
                });
                window.location.reload(); //刷新当前iframe页面
            } else {

                layer.msg(data.msg, {
                    time: 2000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

//  修改员工
$('.edit-employee').on('click', function () {
    // $record_id = $(this).data("id");
    var value = $(this).parent().parent().parent().parent().find("td");
    var temp = value.eq(7).text().replace(/\s*/g, "");
    var all_options = document.getElementById("c_eid").options;
    for (var i = 0; i < all_options.length; i++) {
        var item = all_options[i].value;
        if (item == temp) {
            all_options[i].selected = true;
        }
    }

    $('#e_depart').val(value.eq(2).text());
    $('#e_job').val(value.eq(3).text());
    $('#e_phone').val(value.eq(4).text());

    var workstr = value.eq(6).text();
    if (workstr != '') {
        var worklist = workstr.split(",");
        $(".ckbox").prop("checked", false);
        for (var i = 0; i < worklist.length; i++) {
            var item = worklist[i];
            if (item == '签到') {
                $("#inlineCheckbox1").prop("checked", true);
            } else if (item == '会场') {
                $("#inlineCheckbox2").prop("checked", true);
            } else if (item == '行程') {
                $("#inlineCheckbox3").prop("checked", true);
            } else if (item == '讲稿') {
                $("#inlineCheckbox4").prop("checked", true);
            } else if (item == '餐饮') {
                $("#inlineCheckbox5").prop("checked", true);
            } else if (item == '接送') {
                $("#inlineCheckbox6").prop("checked", true);
            } else if (item == '车辆') {
                $("#inlineCheckbox7").prop("checked", true);
            } else if (item == '陪同') {
                $("#inlineCheckbox8").prop("checked", true);
            }
        }
    }
    $("#employee-modal-form").modal('show');
});

// 修改参会客户
$('.edit-customer').on('click', function () {
    var value = $(this).parent().parent().parent().parent().parent().find("td"); // 取得行数组
    $('#c_name').val(value.eq(1).text());
    var sex = value.eq(2).text();
    if (sex == '男') {
        $('#sex1').attr('checked', 'checked');
    } else if (sex == '女') {
        $('#sex2').attr('checked', 'checked');
    }
    $('#c_depart').val(value.eq(6).text());
    $('#c_phone').val(value.eq(4).text());
    var title = value.eq(3).text();
    var arr_titles = document.getElementById("c_title").options;
    for (var i = 0; i < arr_titles.length; i++) {
        var item = arr_titles[i].value;
        if (item == title) {
            arr_titles[i].selected = true;
        }
    }
    var job = value.eq(8).text();
    if (job == '医师') {
        $('#job1').attr('checked', 'checked');
    } else if (job == '药师') {
        $('#job2').attr('checked', 'checked');
    } else if (job == '其他') {
        $('#job3').attr('checked', 'checked');
    }
    $('#c_hname').val(value.eq(5).text());

    $("#customer-modal-form").modal('show');
});


// 添加客户
function addCustomer() {
    if ($('#c_name').val().trim() == '') {
        alert('亲，姓名忘记填写了哦');
        return;
    }
    if ($('#c_phone').val().trim() == '') {
        alert('请填写手机号！');
        return;
    }

    let form = document.getElementById("customer_form");
    let fd = new FormData(form);
    $.ajax({
        url: 'addCustomer',
        type: 'post',
        async: true,
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: fd,
        success: function (data) {

            if (data.code == 1) {
                layer.msg(data.msg, {
                    time: 2000,
                    icon: 6
                });
                window.location.reload(); //刷新当前iframe页面
            } else {

                layer.msg(data.msg, {
                    time: 2000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

// 新增-修改费用
function addFee(){
    let form = document.getElementById("fee_form");
    let fd = new FormData(form);
    $.ajax({
        url: 'addFee',
        type: 'post',
        async: true,
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: fd,
        success: function (data) {

            if (data.code == 1) {
                layer.msg(data.msg, {
                    time: 2000,
                    icon: 6
                });
                $('#fee_id').val('');
                window.location.reload(); //刷新当前iframe页面
            } else {

                layer.msg(data.msg, {
                    time: 2000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

//会后总结-新增-更新
function addSummary(){
    var form = document.getElementById("Summary_form");
    var fd = new FormData(form);
    $.ajax({
        url: 'addSummary',
        type: 'post',
        async: true,
        processData: false, // 异步传输 formData 时要加上  processData: false  contentType: false
        contentType: false, // 否则会报 Illegal invocation 非法调用错误
        data: fd,
        success: function (data) {

            if (data.code == 1) {
                layer.msg(data.msg, {
                    time: 2000,
                    icon: 6
                });
                $('#s_id').val('');
                window.location.reload(); //刷新当前iframe页面
            } else {

                layer.msg(data.msg, {
                    time: 2000,
                    icon: 5
                });
            }
        },
        dataType: 'json'
    });
}

// 会后总结 edit
$('.edit-Summary').on('click', function () {
    var sid = $(this).data("id");
    $.post("editSummary", {
        id: sid,
        tname:'editSummary'
    }, function (data) {
        if (data.code == 1) {
            var data = data.data;
            $('#s_uid').val(data.uid);
            $('#s_content').val(data.content);
            $('#s_timing').val(data.timing);
            $('#s_judge').val(data.judge);
            if(data.status =='通过'){
                $('#s_status1').selected;
            }else if(data.status =='不通过'){
                $('#s_status2').selected;
            }else{
                $('#s_status3').selected;
            }
            $('#s_id').val(data.id);

            $("#Summary-modal-form").modal('show');
        } else {
            layer.msg(data.msg, {
                time: 1000,
                icon: 2
            });
        }
    }, 'json');
});

$(document).ready(function () {

    //表单
    $('#cnMap').cxSelect({
        url: '/static/js/cxjs/cityData.min.json',
        selects: ['province', 'city', 'region'],
        nodata: 'none'
    });

    $(".mdate").datepicker();

    var chosen = $(".chosen-select").chosen({
        max_selected_options: 10,
        width: "50%"
    });
    chosen.bind("chosen:maxselected", function () {
        layer.msg('最多选10项', {
            time: 800,
            icon: 2
        });
    });


    // 刷新不动选项卡功能
    $(".nav-tabs li").click(function () {
        var TabNum = $(this).index();
        sessionStorage.setItem("TabNum", TabNum);
    });

    $(function () {
        var TabNum = sessionStorage.getItem("TabNum");
        $(".nav-tabs li").eq(TabNum).addClass("active").siblings().removeClass("active");
        $(".tab-content .mytab").removeClass("active");
        var temp = Number(TabNum) + 1;
        // console.log(temp);
        $(".tab-content #tab-" + temp).addClass("active");
    })

    // 1 删除关联医院
    $(".del-meetting").click(function () {
        var hid = $(this).data("id");
        layer.confirm("你确定要删除此医院吗？", {

            btn: ['确定', '取消'] //按钮

        }, function () {

            $.post("delhospital", {
                id: hid,
            }, function (data) {

                if (data.code == 1) {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#hospital-" + hid).remove();

                } else {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });

                }

            }, 'json');

        });
    });

    // 2 删除议程 del-Process
    $(".del-Process").click(function () {
        var process_id = $(this).data("id");
        layer.confirm("你确定要删除此议程吗？", {

            btn: ['确定', '取消'] //按钮

        }, function () {

            $.post("delProcess", {
                process_id: process_id
            }, function (data) {

                if (data.code == 1) {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#Process-" + process_id).remove();

                } else {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });

                }

            }, 'json');

        });
    });

    // 3 删除员工 del-employee
    $(".del-employee").click(function () {
        var id = $(this).data("id");
        layer.confirm("你确定要删除此员工吗？", {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.post("delEmployee", {
                id: id
            }, function (data) {

                if (data.code == 1) {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#employee-" + id).remove();

                } else {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });

                }

            }, 'json');

        });
    });


    // 获取员工信息
    $(".employeeid").change(function () {
        var eid = $('.employeeid').val();
        $.ajax({
            url: 'displayEmployee',
            type: 'post',
            data: {'id': eid},
            success: function (data) {

                if (data.code == 1) {
                    var temp = data.data;
                    // console.log(temp.part);
                    $('#e_depart').val(temp.part);
                    $('#e_job').val(temp.job);
                    $('#e_phone').val(temp.user_phone);
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

    // 4 删除参会客户 del-customer
    $(".del-customer").click(function () {
        var id = $(this).data("id");
        layer.confirm("你确定要删除吗？", {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.post("deleteData", {
                id: id,
                tname: 'meettingcustomer'
            }, function (data) {

                if (data.code == 1) {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#customer-" + id).remove();

                } else {

                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });

                }

            }, 'json');

        });
    });

    // 5 费用清单-删除
    $('.del-fee').on('click', function () {
        var fee_id = $(this).data('id');
        layer.confirm("你确定要删除？", {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.post("deleteData", {
                id: fee_id,
                tname:'meettingfee'
            }, function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#fee-" + fee_id).remove();
                } else {
                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });
                }
            }, 'json');

        });
    });

    //6 费用清单编辑-信息获取
    $('.edit-fee').on('click', function () {
        var feeid = $(this).data('id');
        $.ajax({
            url: 'getFeeinfos',
            type: 'post',
            data: {'id': feeid},
            success: function (data) {

                if (data.code == 1) {
                    var temp = data.data;
                    var li_content = document.getElementById("fee_content").options;
                    for (var i = 0; i < li_content.length; i++) {
                        var item = li_content[i].value;
                        if (item == temp.content) {
                            li_content[i].selected = true;
                        }
                    }
                    $('#fee_money').val(temp.money);
                    $('#fee_details').val(temp.details);
                    var li_users = document.getElementById("fee_user").options;
                    for (var i = 0; i < li_users.length; i++) {
                        var item = li_users[i].value;
                        if (item == temp.uid) {
                            li_users[i].selected = true;
                        }
                    }
                    $('#fee_number').val(temp.number);
                    $('#fee_mark').val(temp.mark);
                    $('#fee_status').val(temp.status);
                    $('#fee_id').val(temp.id);

                    $('#fee-modal-form').modal('show');
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
    // 7.删除总结del-Summary
    $('.del-Summary').on('click', function () {
        var Summary_id = $(this).data('id');
        layer.confirm("你确定要删除？", {
            btn: ['确定', '取消'] //按钮
        }, function () {
            $.post("deleteData", {
                id: Summary_id,
                tname:'meettingsummary'
            }, function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 1
                    });
                    $("#fee-" + Summary_id).remove();
                } else {
                    layer.msg(data.msg, {
                        time: 1000,
                        icon: 2
                    });
                }
            }, 'json');

        });
    });

});


