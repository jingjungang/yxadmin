<?php
// +----------------------------------------------------------------------
// | des: admin应用模块的公共函数文件
// +----------------------------------------------------------------------
// | Author: liu <1226740471@qq.com>
// +----------------------------------------------------------------------

/**
 * 【des:检测用户权限】
 * @param $action  模块/控制器/操作
 * return boolean   true or false
 **/
function check_auth($action = '')
{

    include APP_PATH . "admin/conf/menu.php";  // 后台菜单

    $role_id = session("user_role");

    if ($role_id == 1) { // 超级管理员

        return true;
    }

    $roleAuth = db('role')->where("role_id", $role_id)->column('role_auth');

    $roleAuth = explode(",", $roleAuth[0]);

    if (in_array($action, $roleAuth))

        return true;
    else
        return false;
}


/**
 * 【des:防止表单在极短时间重复提交】
 * return boolean   true or false
 **/
function repeatSubmitLimit()
{

    // microtime()前部分为毫秒 后半部分为秒   用前后先加 就可以获取到当前时间
    // 精确到毫秒的时间戳 多次提交表单 时间差在1秒之内就提示
    $submit_time = explode(' ', microtime());
    $submit_time = ($submit_time[0] / 1000) + $submit_time[1];

    // 防止表单在极短时间重复提交  （有些强迫症患者提交按钮时喜欢快速点击两次）
    if (!Session('submit_time')) {

        Session('submit_time', $submit_time);

        // to do thomthing

    } else {

        $session_submit_time = Session('submit_time');

        if (($submit_time - $session_submit_time) < 1)

            return json(['code' => 1, 'msg' => '不要重复提交表单']);
        else

            Session('submit_time', $submit_time); // 刷新session值

        // to do
    }
}

/**
 * 【des:获取登入用户信息】
 * @param  $field  用户字段  默认为空则获取用户所有字段信息
 *  return  string
 **/
function getLoginUserInfo($field = '')
{

    $user_id = session('user_id');

    if ($field == 'user_id') {
        return $user_id;
    }

    if ($field) {
        $fieldInfo = db('user')->where("user_id", $user_id)->column($field);

        return $fieldInfo[0];

    } else {

        $allFieldInfo = db('user')->where("user_id", $user_id)->select();

        $allFieldInfo = collection($allFieldInfo)->toArray();

        return $allFieldInfo;
    }
}


function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        if ($suffix)
            return mb_substr($str, $start, $length, $charset) . "...";
        else
            return mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        if ($suffix)
            return iconv_substr($str, $start, $length, $charset) . "...";
        else
            return iconv_substr($str, $start, $length, $charset);
    }
    $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef]
              [x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    if ($suffix) return $slice . "…";
    return $slice;
}

?>