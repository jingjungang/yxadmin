<?php

namespace app\admin\model;

use think\Model;

class Customer extends Model
{

    protected $pk = 'id';

    public function getCustomer($num = 10)
    {
        $keywords = input('param.keywords', '');
        $status = input('param.status');

        $where= '1=1 ';
        $param = [];
        if($status == 0){ 
            if($keywords !=''){
                $param['name'] = $keywords;
                $where .= " and name like" . "'%" . $keywords . "%'";
            }
            
        }else{
            $param['status'] = $status;
            if ($keywords) {
                $param['name'] = $keywords;
                $where .= " and name like" . "'%" . $keywords . "%'" . " and status =".$status;
            }else{
                $where .= " and status =".$status;
            }
        }


        $Customer = Customer::alias('a')->field('a.*')
            ->where($where)
            ->order('id', 'DESC')
            ->paginate($num, false, ['query' => $param]);
        $page = $Customer->render();// 获取分页显示


        if ($Customer) {

            return ['code' => 1, 'data' => $Customer, 'msg' => '数据查询成功', 'page' => $page];

        } else {

            return ['code' => 2, 'data' => '', 'msg' => '暂无数据', 'page' => ''];
        }

    }

    public function saveCustomer($param)
    {

        $result = $this->allowField(true)->save($param);
        return $result;
    }


    public function deleteCustomer($id)
    {

        $result = $this->where('id=' . $id)->setField('status', 3); //删除状态改为3

        if ($result) {

            return json(['code' => 1, 'msg' => '删除成功']);

        } else {

            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }


    public function updateCustomer($input)
    {

        $save = $this->allowField(true)->save($input, $input['id']);

        if ($save) {
            return ['code' => 1, 'msg' => '保存成功'];
        } else {
            return ['code' => 2, 'msg' => '保存失败'];
        }

    }


    public function getCustomerById($Id)
    {
        if($Id){
            $Meetting = $this->where("id=" . $Id)->find();
            if ($Meetting) {
                $Meetting = $Meetting->toArray();
                return $Meetting;
            } else {
                return '';
            }
        }else{
            return '';
        }

    }

}
