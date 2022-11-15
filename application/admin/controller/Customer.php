<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;
use think\Cache;

class Customer extends AdminBase
{
    public $transaction;

    public function __construct(){
        parent::__construct();
        $this->transaction = db('customer');
    }

	public function CustomerList()
    {
    	$param['status'] = 1;
        if (request()->isPost()) {
            $this->assign("keywords", input('param.keywords', ''));
        	$this->assign("status", input('param.status',  $param['status']));
        }
        $data = model('Customer')->getCustomer(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);
        
        return $this->fetch();
    }

    // 新增
    public function addCustomer()
    {
        if(request()->isPost()){
        	$data = $_POST;
        	try{

                $this->transactio->startTrans(); // 开启事务
        		$result = $this->transactio->insert($data);
	        	if($result){
	        		$infos['code'] = 1;
	        		$infos['msg'] = '添加成功';
	        	}else{
	        		$infos['code'] = 0;
	        		$infos['msg'] = '添加失败';
	        	}
        	}catch(Exception $e){
                $this->transactio->rollback(); // 事务回滚
        		$infos['code'] = 0;
        		$infos['msg'] = $e->getMessage();
        	}
            $this->transactio->commit(); // 关闭事务
        	return $infos;
        }else{
        	$li = db('hospital')->field('id,name,code')->select();
        	$this->assign("hospital", $li);
        	return $this->fetch();
        }
    }

    // 删除
    public  function delCustomer(){
        $id = $_POST['id'];
        $this->transaction->startTrans(); // 开启事务
        $infos['code'] = 1;
        try{
            $data['status'] = 2;
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
    public  function editCustomer(){
        if(!request()->isPost()){
            $id = input("param.id", '');
            $result = $this->transaction->where('id',$id)->find();
            $this->assign('li',$result);

            $li = db('hospital')->field('id,name,code')->select();
            $this->assign("hospital", $li);

            return $this->fetch();
        }else{
            $data=$_POST;
            try{
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

    //参与会议
    public function innerMeettings(){

        return $this->fetch();
    }
}