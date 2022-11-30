<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;

class Customerrelation extends AdminBase
{
    public $transaction;

    public function __construct(){
        parent::__construct();
        $this->transaction = db('Customerrelation');
    }

	public function CustomerrelationList()
    {
    	$param['status'] = 0;
        if (request()->isPost()) {
            $this->assign("keywords", input('param.keywords', ''));
        	$this->assign("status", input('param.status',  $param['status']));
        }
        $data = model('Customerrelation')->getCustomerrelation(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);
        
        return $this->fetch('Customerrelation/Customerrelation_list');
    }

    // 新增
    public function addCustomerrelation()
    {
        if(request()->isPost()){
        	try{
                $data = $this->uploadToDB('file','customer','pics');
                $this->transaction->startTrans(); // 开启事务
        		$result = $this->transaction->insert($data);
	        	if($result){
	        		$infos['code'] = 1;
	        		$infos['msg'] = '添加成功';
	        	}else{
	        		$infos['code'] = 0;
	        		$infos['msg'] = '添加失败';
	        	}
        	}catch(Exception $e){
                $this->transaction->rollback(); // 事务回滚
        		$infos['code'] = 0;
        		$infos['msg'] = $e->getMessage();
        	}
            $this->transaction->commit(); // 关闭事务
        	return $infos;
        }else{
            $customer = db('customer')->field('id,name')->select();
        	$li = db('hospital')->field('id,name,code')->select();
            $users = db('user')->field('user_id,user_nicename')->select();
            $this->assign("customer", $customer);
        	$this->assign("hospital", $li);
            $this->assign("users", $users);
        	return $this->fetch();
        }
    }

    // 删除
    public  function delCustomerrelation(){
        $id = $_POST['id'];
        $this->transaction->startTrans(); // 开启事务
        $infos['code'] = 1;
        try{
            $data['flag'] = 1;
            $result = $this->transaction->where('id',$id)->update($data);
            if($result){
                $infos['code'] = 1;
                $infos['msg'] = '操作成功';
            }else{
                $infos['code'] = 0;
                $infos['msg'] = '操作失败';
            }
        }catch(Exception $e){
            $this->transaction->rollback(); // 事务回滚
            $infos['code'] = 0;
            $infos['msg'] = $e->getMessage();
        }
        
        return $infos;
        
    }


    //编辑
    public  function editCustomerrelation(){
        if(!request()->isPost()){
            $id = input("param.id", '');

            $result = $this->transaction->where('id',$id)->find();
            $this->assign('data',$result);

            $customer = db('customer')->field('id,name')->select();
            $li = db('hospital')->field('id,name,code')->select();
            $users = db('user')->field('user_id,user_nicename')->select();
            $this->assign("customer", $customer);
            $this->assign("hospital", $li);
            $this->assign("users", $users);

            return $this->fetch();
        }else{
            $data = $_POST;
            $oldpics = '';
            if($_POST['oldpics']!=''){
                $oldpics = $data['oldpics'];
            }
            $len = count($_FILES['file']['name']);
            if ($len > 0){
                $data = $this->uploadToDB('file','customer','pics');
            }
            try{
                if($oldpics!=''){
                    if($data['pics']!=''){
                        $data['pics'] = $oldpics.','. $data['pics'];
                    }else{
                        $data['pics'] = $oldpics;
                    }
                }
                unset($data['oldpics']);
                $result = $this->transaction->where('id',$data['id'])->update($data);
                if($result){
                    $infos['code'] = 1;
                    $infos['msg'] = '操作成功';
                }else{
                    $infos['code'] = 0;
                    $infos['msg'] = '操作失败';
                }
            }catch(Exception $e){
                $this->transaction->rollback(); // 事务回滚
                $infos['code'] = 0;
                $infos['msg'] = $e->getMessage();
            }
            return $infos;
        }
    }


}