<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;
use think\Cache;

class Customer extends AdminBase
{
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
        		$transaction = db('customer');
        		$transaction->startTrans(); // 开启事务
        		$result = $transaction->insert($data);
	        	if($result){
	        		$infos['code'] = 1;
	        		$infos['msg'] = '添加成功';
	        	}else{
	        		$infos['code'] = 0;
	        		$infos['msg'] = '添加失败';
	        	}
        	}catch(Exception $e){
        		$transaction->rollback(); // 事务回滚
        		$infos['code'] = 0;
        		$infos['msg'] = $e->getMessage();
        	}
        	$transaction->commit(); // 关闭事务
        	return $infos;
        }else{
        	$li = db('hospital')->field('id,name,code')->select();
        	$this->assign("hospital", $li);
        	return $this->fetch();
        }
    }

    // 删除
    public  function delCustomer(){
        
    }
}