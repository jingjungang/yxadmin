<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;
use think\Cache;

include('Upload.php');

/**
 * jjg
 * 销售会议
 * 2022年11月2日10:50:59
 **/
class Meettingsale extends AdminBase
{

    public function meettingList()
    {
        $param['status'] = 1;
        if (request()->isPost()) {
            $param['status'] = input('param.status');
        }
        $data = model('Meettingsale')->getMeettings(10, $param);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);
        $this->assign("status", input('param.status',  $param['status']));

        return $this->fetch();
    }


    public function addMeetting()
    {
        $type = input("param.type", '');
        $userlist = model('User')->getUserList();
        $this->assign("userlist", $userlist);
        return $this->fetch();
    }

    public function saveMeetting()
    {
        $input = input();
        $input['type1'] = 2; //1学术会议 2销售类型
        $info = model('Meettingsale')->saveMeetting($input);
        if ($info) {
            $param['code'] = 1;
            $param['msg'] = "保存成功";
        } else {
            $param['code'] = 2;
            $param['msg'] = "保存失败";
        }
        return $param;
    }


    public function delMeetting()
    {
        $meetting_id = input("param.meetting_id");

        $info = model('Meettingsale')->delMeetting($meetting_id);

        return $info;

    }

    //编辑会议
    public function publishMeetting()
    {

        $type = input('type');
        if ($type == 'update') {
            $Meetting = model('Meettingsale')->getMeetting(input("param.id", ''));
            $this->assign("meetting", $Meetting);
        } else {

        }

        $userlist = model('User')->getUserList();
        $this->assign("userlist", $userlist);
        // var_dump($userlist);

        return $this->fetch();
    }

    public function updateMeetting()
    {

        $input = input();
        $input["handle_type"] = "update";
        $info = model('Meettingsale')->updateMeetting($input);

        return $info;
    }
     //会议详情
    public function editMeetting()
    {
        $mid = input("param.id", '');
        if ($mid == '') {
            $mid = session('$Meetting');
        } else {
            session('$Meetting', $mid);
        }
        // 会议查询
        $Meetting = model('Meettingsale')->getMeetting($mid);
        $this->assign("meetting", $Meetting);


        // 员工查询
        $userlist = db('user')->where('user_role<>1')->select();
        $this->assign("userlist", $userlist);
        Cache::set('userlist', $userlist, 3600);     // 将数据插入缓存文件中，设置过期时间为3600秒


        return $this->fetch();
    }

    // 审核会议
    public  function checkMeetting(){

        $data = $_POST;
        $flag = $data['flag'];
        $infos['code'] = 0;
        $transaction = db('meettingsale');
        try{
            if ($flag == 1) { //通过
                $params['status'] = 2;
                $res = $transaction->where('id in ('.$data['id'].')')->update($params);

                if ($res) {
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                }else{
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }

            }else if ($flag == 2) { //不通过
                $params['status'] = 4;
                $res = $transaction->where('id in ('.$data['id'].')')->update($params);
                if ($res) {
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                }else{
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }
            }else if($flag == 3) { //恢复
                $params['status'] = 1;
                $res = $transaction->where('id in ('.$data['id'].')')->update($params);
                if ($res) {
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                }else{
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }
            }else if($flag == 4) { //彻底删除
                $res = $transaction->where('id in ('.$data['id'].')')->delete();
                if ($res) {
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                }else{
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }
            }
        } catch (Exception $e) {
            $temp = $transaction->getLastSql();
            $transaction->rollback(); //事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }

        return $infos;
    }

}
