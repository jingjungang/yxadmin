<?php

namespace app\admin\controller;
header("Content-Type: text/html;charset=utf-8");

use think\Exception;
use think\Cache;

class Hospital extends AdminBase
{
    public $transaction;

    public function __construct(){
        parent::__construct();
        $this->transaction = db('Hospital');
    }

	public function HospitalList()
    {
    	$param['status'] = 1;
        if (request()->isPost()) {
            $this->assign("keywords", input('param.keywords', ''));
        	$this->assign("status", input('param.status',  $param['status']));
        }
        $data = model('Hospital')->getHospital(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);
        
        return $this->fetch();
    }

    // 新增
    public function addHospital()
    {
        if(request()->isPost()){
        	$data = $_POST;
        	try{

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
        	$li = db('hospital')->field('id,name,code')->select();
        	$this->assign("hospital", $li);
        	return $this->fetch();
        }
    }

    // 删除
    public  function delHospital(){
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
    public  function editHospital(){
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

    //关联会议
    public function innerMeettings(){

        $meettingid = input("param.id");
        $params['a.name']=$meettingid;
        $result = db('meettingHospital')->alias('a')
            ->join('meetting m', 'm.id = a.meettingid','left')
            ->where($params)
            ->field('m.*')
            ->order('m.id', 'DESC')
            ->paginate(10, false, ['query' => $params]);
        $t = db('meettingHospital')->getLastSql();
        if($result){
            $page = $result->render();// 获取分页显示
            $this->assign("li_meetting", $result);
            $this->assign("page", $page);
        }

        return $this->fetch();
    }
}