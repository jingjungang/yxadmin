<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;
use think\Cache;

include('Upload.php');

/**
 * jjg
 * 学术会议
 * 2022年9月21日16:52:24
 **/
class Meettingxs extends AdminBase
{

    public function meettingList()
    {
        $param['status'] = 1;
        if (request()->isPost()) {
            $param['status'] = input('param.status');
        }
        $data = model('Meetting')->getMeettings(10, $param);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);
        $this->assign("keywords", input('param.keywords', ''));
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
        $info = model('Meetting')->saveMeetting($input);
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

        $info = model('Meetting')->delArticle($meetting_id);

        return $info;

    }

    //编辑会议
    public function publishMeetting()
    {

        $type = input('type');
        if ($type == 'update') {
            $Meetting = model('Meetting')->getMeetting(input("param.id", ''));
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
        $info = model('Meetting')->updateMeetting($input);

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
        $Meetting = model('Meetting')->getMeetting($mid);
        $this->assign("meetting", $Meetting);


        // 员工查询
        $userlist = db('user')->where('user_role<>1')->select();
        $this->assign("userlist", $userlist);
        Cache::set('userlist', $userlist, 3600);     // 将数据插入缓存文件中，设置过期时间为3600秒

        // 医院查询
        $arr_hospital = db('hospital')->select();
        $this->assign("arr_hospital", $arr_hospital);
        Cache::set('arr_hospital', $arr_hospital, 3600);

        if ($Meetting) {
            // 1 关联医院
            $Hospitals = model('Meettinghospital')->getHospital(10, $Meetting['id']);
            $this->assign("Hospitals", $Hospitals['data']);
            $this->assign("page1", $Hospitals['page']);
            $this->assign("li_hospital", $arr_hospital);


            //  2 会议议程
            $li_Process = model('Meettingprocess')->getProcess(10, $Meetting['id']);
            if ($li_Process['code'] == 1) {
                $this->assign("Process", $li_Process['data']);
                $this->assign("li_Process", $li_Process['li_Process']);
                $this->assign("page2", $li_Process['page']);
            }

            // 3 组织员工
            $where = array('meettingid' => $Meetting['id']);
            $li_employee = db('meettingemployee')
                ->alias('a')
                ->join('user e', 'e.user_id = a.employeeid')
                ->field('a.id,a.work,e.user_id,e.user_nicename,e.part,e.job,e.user_phone')
                ->order('id', 'DESC')
                ->paginate(10, false, ['query' => $where]);

            if ($li_employee) {
                $page3 = $li_employee->render();// 获取分页显示
                $this->assign("li_employee", $li_employee);
                $this->assign("page3", $page3);
            }

            // 4.参会客户
            $where = array('meettingid' => $Meetting['id']);
            $arr = db('meettingcustomer')
                ->alias('a')
                ->join('hospital h', 'a.hospitalid = h.id')
                ->field('h.name as hname,a.*')
                ->order('id', 'DESC')
                ->paginate(10, false, ['query' => $where]);

            if ($arr) {
                $page4 = $arr->render();// 获取分页显示
                $this->assign("li_customer", $arr);
                $this->assign("page4", $page4);
            }

            // 5.费用清单
            $where = array('meettingid' => $Meetting['id']);
            $arr = db('meettingfee')
                ->alias('t')
                ->join('user u', 'u.user_id = t.uid')
                ->field('t.*,u.user_nicename as username')
                ->order('id', 'DESC')
                ->paginate(10, false, ['query' => $where]);
            if ($arr) {
                $page5 = $arr->render();// 获取分页显示
                $this->assign("li_fee", $arr);
                $this->assign("page5", $page5);
            }

            // 6.会后总结
            $where = array('meettingid' => $Meetting['id']);
            $li = db('meettingsummary')
                ->alias('t')
                ->join('user u', 'u.user_id = t.uid')
                ->field('t.*,u.user_nicename as username')
                ->order('id', 'DESC')
                ->paginate(10, false, ['query' => $where]);

            if ($li) {
                $page6 = $li->render();// 获取分页显示
                $this->assign("li_summary", $li);
                $this->assign("page6", $page6);
            }
        }
        return $this->fetch();
    }


    //会议详情-获取单个医院信息
    public function getHospitalinfos()
    {
        $input = input();
        if ($input["hname"]) {
            $para['name'] = $input["hname"];
        }
        $Hospitals = db('Hospital')->where($para)->find();
        if ($Hospitals) {
            $infos['code'] = 1;
            $infos['data'] = $Hospitals;
        } else {
            $infos['code'] = 0;
            $infos['msg'] = 'no data';
        }
        return $infos;
    }

    // 会议详情-新增医院
    public function addhospital()
    {
        $input = input();
        $hid = $input["hid"];
        $mid = $input["mid"];
        if (!$hid) {
            $infos['code'] = 0;
            $infos['msg'] = '医院id不存在';
            return $infos;
        }
        $data['meettingid'] = $mid;
        $data['hospitalid'] = $hid;
        $data['addtime'] = date('Y-m-d H:i:s', time());
        $result = db('meettinghospital')->insert($data);
        if ($result) {
            $infos['code'] = 1;
            $infos['msg'] = '保存成功';
        } else {
            $infos['code'] = 0;
        }
        return $infos;
    }

    // 会议详情-删除关联医院
    public function delHospital()
    {
        $data = input();
        $para['id'] = $data['id'];
        $info = db('meettinghospital')->where($para)->delete();
        if ($info) {
            $infos['code'] = 1;
        } else {
            $infos['code'] = 0;
            $infos['msg'] = '保存失败';
        }
        return $infos;

    }

    // 新增会议议程
    public function addOneProcess()
    {
        $data = $_POST;
        $files = request()->file('image');
        $index = 0;
        $len = count($_FILES['image']['name']);
        for ($i = 0; $i < $len; $i++) {
            $param = [];
            if ($files[$i]) {
                // 移动到框架应用根目录/upload/ 目录下
                $info = $files[$i]->validate(['size' => 2402712, 'ext' => 'jpg,png,jpeg,ppt,pptx'])->move(ROOT_PATH . DS . 'public' . DS . 'upload' . DS . 'meetting');
                $savename = $info->getSaveName();
                $array = explode('.', $savename);
                $filetype = array_pop($array); //获取后缀
                $allow1 = ['jpg', 'png', 'jpeg'];
                $allow2 = ['ppt', 'pptx'];
                if ($info) {
                    $imgpath = DS . 'upload' . DS . 'meetting' . DS . $savename;
                    $param['url'] = str_replace(DS, "/", $imgpath);
                    if (in_array($filetype, $allow1)) {
                        $data['photo'] = $param['url'];
                    }
                    if (in_array($filetype, $allow2)) {
                        $data['ppt'] = $param['url'];
                    }
                } else {
                    // 上传失败获取错误信息
                    $errorinfo = $files[$i]->getError();
                }
            }
            $index = $index + 1;
        }

        if ($errorinfo == '') {
            $data['addtime'] = date('Y-m-d H:i:s', time());
            if ($data['id']) {
                $res = db('meettingprocess')->where('id', $data['id'])->update($data);
            } else {
                $res = db('meettingprocess')->insert($data);
            }
            if ($res) {
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        } else {
            $infos['code'] = 0;
            $infos['msg'] = $errorinfo;
        }
        return $infos;
    }

    // 获取议程
    public function getProcessById()
    {
        $data = $_POST;
        $id = $data['id'];
        $res = db('meettingprocess')->where('id', $id)->find();
        if ($res) {
            $infos['data'] = $res;
            $infos['code'] = 1;
        } else {
            $infos['code'] = 0;
            $infos['msg'] = '获取失败';
        }

        return $infos;
    }

    // 删除议程
    public function delProcess()
    {
        $processid = input("param.process_id");

        $info = db('meettingprocess')->where('id=' . $processid)->delete();
        if ($info) {
            $infos['code'] = 1;
            $infos['msg'] = '删除成功';
        } else {
            $infos['code'] = 0;
            $infos['msg'] = '删除失败';
        }
        return $infos;

    }

    // 删除参会员工
    public function delEmployee()
    {
        $id = input("param.id");
        $transaction = db('meettingemployee');
        $transaction->startTrans();//开启事务
        try {
            $res = $transaction->where('id=' . $id)->delete();
            if ($res) {
                $infos['code'] = 1;
                $infos['msg'] = '删除成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '删除失败';
            }
        } catch (Exception $e) {
            $transaction->rollback();//事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        $transaction->commit();//关闭事务
        return $infos;

    }

    // 查询缓存员工
    public function displayEmployee()
    {
        $data = $_POST;
        $eid = $data['id'];
        if (Cache::get('userlist')) {   // 如果缓存文件存在
            $userlist = Cache::get('userlist');
        } else {   // 缓存文件不存在，则连接数据库进行数据调取
            $userlist = db('user')->where('user_role<>1')->order('id DESC')->select();
            Cache::set('userlist', $userlist, 3600);     // 将数据插入缓存文件中，设置过期时间为3600秒
        }
        $infos = [];
        foreach ($userlist as $user) {
            if ($user) {
                $id = $user['user_id'];
                if ($id == $eid) {
                    $infos['code'] = 1;
                    $infos['data'] = $user;
                }
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '查询失败了';
            }
        }
        return $infos;
    }

    // 新增员工
    public function addEmployee()
    {
        $data = $_POST;
        if ($data['work']) {
            $data['work'] = implode(',', $data['work']);
        }
        $data['addtime'] = date('Y-m-d H:i:s', time());
        $transaction = db('meettingemployee');
        try {
            $params = [];
            $params['meettingid'] = $data['meettingid'];
            $params['employeeid'] = $data['employeeid'];
            $res = $transaction->where($params)->find();
            if ($res) {
                $result = $transaction->where('id', $res['id'])->update($data);
            } else {
                $result = $transaction->insert($data);
            }
            if ($result) {
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        } catch (Exception $e) {
            $transaction->rollback(); //事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        return $infos;
    }

    // 根据id和表名删除数据
    public function deleteData()
    {
        $id = input("param.id");
        $tablename = input("param.tname");
        $transaction = db($tablename);
        $transaction->startTrans();//开启事务
        try {
            $res = $transaction->where('id=' . $id)->delete();
            if ($res) {
                $infos['code'] = 1;
                $infos['msg'] = '删除成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '删除失败';
            }
        } catch (Exception $e) {
            $transaction->rollback();//事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        $transaction->commit();//关闭事务
        return $infos;

    }

    // 新增客户
    public function addCustomer()
    {
        $data = $_POST;
        $data['addtime'] = date('Y-m-d H:i:s', time());
        $transaction = db('meettingcustomer');
        try {
            if (Cache::get('arr_hospital')) {
                $li = Cache::get('arr_hospital');
                foreach ($li as $item) {
                    $name = $item['name'];
                    if ($name == $data['hname']) {
                        $hid = $item['id'];
                    }
                }
            } else {   // 缓存文件不存在，则连接数据库进行数据调取
                $res = db('hospital')->where('name=' . $data['hname'])->find();
                $hid = $res['id'];
            }
            $data['hospitalid'] = $hid;

            $params = [];
            $params['meettingid'] = $data['meettingid'];
            $params['name'] = $data['name'];
            $res = $transaction->where($params)->find();

            foreach ($data as $k => $v) {
                if ($k == 'hname') {
                    unset($data[$k]);
                }
            }

            if ($res) {
                $result = $transaction->where('id', $res['id'])->update($data);
            } else {
                $result = $transaction->insert($data);
            }
            if ($result) {
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        } catch (Exception $e) {
            $transaction->rollback(); //事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        return $infos;
    }

    // 新增费用
    public function addFee()
    {
        $data = $_POST;
        $data['addtime'] = date('Y-m-d H:i:s', time());
        $transaction = db('meettingfee');
        try {
            if ($data['id'] == '') {
                $result = $transaction->insert($data);
            } else {
                $result = $transaction->where('id', $data['id'])->update($data);
            }

            if ($result) {
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        } catch (Exception $e) {
            $transaction->rollback(); //事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        return $infos;
    }

    // 获取fee数据
    function getFeeinfos()
    {
        $data = $_POST;
        $id = $data['id'];
        $transaction = db('meettingfee');
        try {
            $result = $transaction->where('id', $id)->find();
            if ($result) {
                $infos['code'] = 1;
                $infos['data'] = $result;
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '获取失败';
            }
        } catch (Exception $e) {
            $transaction->rollback(); //事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        return $infos;
    }

    // 总结新增
    function addSummary(){
        $data = $_POST;
        $files = request()->file('image');
        $index = 0;
        $len = count($files);
        $array_images = [];
        for ($i = 0; $i < $len; $i++) {
            $param = [];
            if ($files[$i]) {
                // 移动到框架应用根目录/upload/ 目录下
                $info = $files[$i]->validate(['size' => 2402712, 'ext' => 'jpg,png,jpeg,ppt,pptx'])->move(ROOT_PATH . DS . 'public' . DS . 'upload' . DS . 'meetting');
                $savename = $info->getSaveName();
                $array = explode('.', $savename);
                $filetype = array_pop($array); //获取后缀
                $allow = ['jpg', 'png', 'jpeg'];
                if (in_array($filetype, $allow)) {
                    if ($info) {
                        $imgpath = DS . 'upload' . DS . 'meetting' . DS . $savename;
                        $param['url'] = str_replace(DS, "/", $imgpath);
                        $array_images[] = $param['url'];
                    } else {
                        // 上传失败获取错误信息
                        $errorinfo = $files[$i]->getError();
                    }
                }else{
                    $errorinfo = '图片格式不正确';
                }

            }
            $index = $index + 1;
        }

        if ($errorinfo == '') {
            if(count($array_images)>0){
                $data['urls'] = implode(',',$array_images );
            }else{
                $data['urls'] = '';
            }
            $data['addtime'] = date('Y-m-d H:i:s', time());
            if ($data['id']!='') {
                $res = db('meettingsummary')->where('id', $data['id'])->update($data);
            } else {
                $res = db('meettingsummary')->insert($data);
            }
            if ($res) {
                $infos['code'] = 1;
                $infos['msg'] = '保存成功';
            } else {
                $infos['code'] = 0;
                $infos['msg'] = '保存失败';
            }
        } else {
            $infos['code'] = 0;
            $infos['msg'] = $errorinfo;
        }
        return $infos;
    }

    // 总结查询
    public function editSummary(){
        $id = $_POST['id'];
        $res = db('meettingsummary')->where('id',$id)->find();
        $infos['code'] = 0;
        if ($res){
            $infos['code'] = 1;
            $infos['data'] = $res;
        }
        return $infos;

    }

    // 审核会议
    public  function checkMeetting(){

        $data = $_POST;
        $flag = $data['flag'];
        $infos['code'] = 0;
        $transaction = db('meetting');
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
