<?php

namespace app\admin\controller;
/**
 * jjg
 * 2022年11月29日10:43:57
 * 积分规则
 */
class Rules extends AdminBase
{
    public $modle;

    public function __construct(){
        parent::__construct();
        $this->modle = db('Rules');
    }

    /*
     * 积分列表
     */
    public function Ruleslist()
    {
        $data = model('Rules')->getRules(10);
        $this->assign("data", $data['data']);
        $this->assign("page", $data['page']);

        return $this->fetch('Rules/Rules_list');
    }

    /**
     * 新增
     */
    public function addRules()
    {
        if (request()->isPost()) {
            $input = input();
            $result = model('Rules')->addRules($input);
            return $result;
        }
        return $this->fetch();
    }

    /**
     * 编辑
     */
    public function editRules()
    {
        if (request()->isPost()) {
            $input = input();
            $result = model('Rules')->updateRules($input);
            return $result;
        }
        $id = input('id');
        $result = $this->modle->where('id',$id)->find();
        $this->assign("data",$result);
        return $this->fetch();
    }

    /**
     * 删除
     */
    public function delRules(){
        $input = input();
        $id = $input['id'];
        $result = model('Rules')->delRules($id);
        return $result;
    }
}