<?php
// +----------------------------------------------------------------------
// | des: admin应用模块的基类
// +----------------------------------------------------------------------
// | Author: liu <1226740471@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;

class AdminBase extends Controller
{

    public function __construct()
    {
        parent::__construct();

        // do something...

        // echo "this is a base controller";

    }


    /**
     * 初始化操作
     */
    public function _initialize()
    {

        error_reporting(E_ALL ^ E_NOTICE); // 屏蔽模板输出不存在的变量时的错误提示信息

        // 不需要登入的请求
        $noLogin = array(
            'admin/Index/login',
            'admin/Index/loginOut',
            'admin/Index/vertify',
        );

        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();

        $request_url = $module . "/" . $controller . "/" . $action;

        if (!in_array($request_url, $noLogin) && !session('is_login')) {

            $this->redirect('admin/Index/login', 302); // 跳转到登入页面

        }

    }

    /**
     *  post存图和表单
     * @param $imagename input的name
     * @param $filename 存到哪个文件去
     * @param $key 存图的字段
     * @return array
     */
    public function uploadToDB($imagename, $filename, $key)
    {
        $data = $_POST;
        $files = request()->file($imagename);
        $index = 0;
        $len = count($_FILES[$imagename]['name']);
        $ar = [];// 放图片路径
        for ($i = 0; $i < $len; $i++) {
            $param = [];
            if ($files[$i]) {
                // 移动到框架应用根目录/upload/ 目录下
                $info = $files[$i]->validate(['size' => 2402712, 'ext' => 'jpg,png,jpeg,ppt,pptx'])->move(ROOT_PATH . DS . 'public' . DS . 'upload' . DS . $filename);
                $savename = $info->getSaveName();
                $array = explode('.', $savename);
                $filetype = array_pop($array); //获取后缀
                $allow1 = ['jpg', 'png', 'jpeg'];
                if ($info) {
                    $imgpath = DS . 'upload' . DS . $filename . DS . $savename;
                    $param['url'] = str_replace(DS, "/", $imgpath);
                    if (in_array($filetype, $allow1)) {
                        $ar[] = $param['url'];
                    }
                } else {
                    // 上传失败获取错误信息
                    $errorinfo = $files[$i]->getError();
                }
            }
            $index = $index + 1;
        }
        if (count($ar) > 0) {
            $data[$key] = implode(',', $ar);
        }
        return $data;
    }

}
